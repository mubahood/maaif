<?php

/**
 * Created by PhpStorm.
 * User: Herbert
 * Date: 20/11/2016
 * Time: 20:54
 */
class reportList
{
    //Init class variables
    public $district;
    public $user_category_id;
    public $subcounty;
    public $name;



    /**
     * Constructor populate variables
     */
    public function __construct($region, $subregion, $district,$name,$results_view = 'list', $results_order = 'nameASC')
    {

    }


    //Searching using all parameters
    public function doSearchAll()
    {

        $sql = "
      SELECT * FROM user		  
        ";


        //Get results
        $tot = database::performQuery($sql);
        $this->total = $tot->num_rows;

        return $this->resultsByGridView($tot);
    }




    public static function checkExtensionofficerReportViewPermissions(){}
    public static function checkExtensionofficerExists($id){
        $sql = database::performQuery("SELECT * FROM user WHERE id=$id");
        if($sql->num_rows > 0)
            return true;
        //TODO redirect to user doesn't exist or 404 page here!
        else
            redirect_to(ROOT);

    }
    public static function prepeExtensionofficerReport($id){

        $content= '';

        //TODO redirect if ID dosent exist
        self::checkExtensionofficerExists($id);

        //TODO Redirect if no proper permissions exist
        self::checkExtensionofficerReportViewPermissions();

        $user = user::getUserDetails($id);
        $user_cat = user::getUserCategory($user['user_category_id']);

        //Being building report here
        $content .='
        <div class="col-sm-12 col-md-12 col-lg-12">

        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Filter Report</h4>
            <form class="m-t-30" action="#">
            <table class="table table-bordered table-condensed">
              <tr>

                <td>        
                  <div class="form-group">
                      <label>Choose a financial year</label>
                      <select class="form-control custom-select" name="financial_year" required>
                          <option value =""> -- select financial year -- </option>
                          <option value="2021/2022">2021/2022</option>
                          <option value="2022/2023">2022/2023</option>
                          <option value="2023/2024">2023/2024</option>
                          <option value="2024/2025">2024/2025</option>
                          <option value="2025/2026">2025/2026</option>
                      </select>
                  </div>                
                </td>

                <td>
                  <div class="form-group">
                      <label>Choose a quarter</label>
                      <select class="form-control custom-select" name="quarter" required >
                          <option value =""> -- select a quarter -- </option>
                          <option value="1">First Quarter</option>
                          <option value="2">Second Quarter</option>
                          <option value="3">Third Quarter</option>
                          <option value="4">Fourth Quarter</option>
                      </select>
                  </div>
                </td>
                                                
                <td> 
                  <div class="form-group">
                    <label>&nbsp;</label><br />
                    <input type="hidden" name="action" value="setQuarterlyActivityFilters" />
                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success">Filter</button>
                  </div>
                </td>              

            </div>
        </div>
        
        <table class="table-bordered table" border="1" style="font-weight: bold;font-size: 16px">
        <thead>
          <tr>
            <td colspan="3"> Extension Officer Report For '.$_SESSION['financial_year'].' ( Quarter  '.$_SESSION['quarter'].' ) </td>
            <td colspan="1">
            <button type="button" onclick="window.print()" class="btn waves-effect waves-light btn-rounded btn-sm btn-success">Print Report</button>
            </td>
          </tr>
        </thead>
        <tbody>
        <tr>  
          <td width="25%">Name:<br />
          <span style="font-size: 14px;font-weight: lighter">'.$user['first_name'].' '.$user['last_name'].' </span>
          </td>
          <td width="25%">Rank: <br />
           <span style="font-size: 14px;font-weight: lighter">'.$user_cat.'</span>
          </td>
          <td width="25%">Gender: <br />
           <span style="font-size: 14px;font-weight: lighter">'.$user['gender'].'</span>
          </td>
          <td width="25%">Financial Year: <br />
           <span style="font-size: 14px;font-weight: lighter">'.$_SESSION['financial_year'].'</span>
          </td>
        </tr>
        <tr>
          <td>District:<br />
          <span style="font-size: 14px;font-weight: lighter">'.district::getDistrictName($user['district_id']).'</span>
          </td>
          <td>Sub-county Attached:<br />
           <span style="font-size: 14px;font-weight: lighter">'.subcounty::getSubcountyName($user['location_id']).'</span>
         
          </td>
          <td>Phone: <br />
            <span style="font-size: 14px;font-weight: lighter">'.$user['phone'].'</span>
          </td>
          <td>Email: <br />
            <span style="font-size: 14px;font-weight: lighter">'.$user['email'].'</span>
          </td>
        </tr>
        <tr>
          <td colspan="2">Activities Covered: 
                 <table class="table table-sm m-b-0" style="font-weight: normal;font-size: 14px">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Activity</th>
                                <th scope="col">No. Covered</th>
                                <th scope="col">Beneficiaries</th>
                            </tr>
                        </thead>
                        <tbody>
                         '.self::getEOActivities($id).'                            
                        </tbody>
                 </table>
          
          </td>
          <td colspan="2">Locations Covered: <br />
          <table class="table table-sm m-b-0" style="font-weight: normal;font-size: 14px">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Location</th>
                                <th scope="col">No. Covered</th>
                                <th scope="col">Beneficiaries</th>
                            </tr>
                        </thead>
                        <tbody>
                         '.self::getEOLocations($id).'                            
                        </tbody>
                 </table>
          </td>
             
        </tr>
        <tr> 
          <td colspan="2">Activity Map:
         
           <div id="mapdiv"  style="width: 600px; height: 400px;"></div>
  <script src="https://www.openlayers.org/api/OpenLayers.js"></script>
  <script type="text/javascript">
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());

    var centerUG = new OpenLayers.LonLat( 32.583333 ,0.316667 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
          
  
     '.self::plotEOLocations($id).'
          
    var zoom=7;

    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
    
    '.self::plotEOMarkers($id).'
    
    map.setCenter (centerUG, zoom);
  </script>
         
         
          </td>
          <td colspan="2">Topics Covered: 
          
            <table class="table table-sm m-b-0" style="font-weight: normal;font-size: 14px">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Topic</th>
                                <th scope="col">No. Covered</th>
                                <th scope="col">Beneficiaries</th>
                            </tr>
                        </thead>
                        <tbody>
                         '.self::getEOTopics($id).'                            
                        </tbody>
                 </table>
          </td>
        </tr>
        <tr> 
          <td colspan="2">Entreprizes Covered:
          
          <table class="table table-sm m-b-0" style="font-weight: normal;font-size: 14px">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Entreprize</th>
                                <th scope="col">No. Covered</th>
                                <th scope="col">Beneficiaries</th>
                            </tr>
                        </thead>
                        <tbody>
                         '.self::getEOEntreprize($id).'                            
                        </tbody>
                 </table>
          </td>
          <td colspan="2">Beneficiaries Covered:</td>
        </tr>';

        if($user['user_category_id'] == 10)
        {
        $content .='<tr>
          <td colspan="4">Chief Administrative Officer Remarks</td>
        </tr>
       ';
        }
        else if($user['user_category_id'] == 2 || $user['user_category_id'] == 3 || $user['user_category_id'] == 4 || $user['user_category_id'] == 12)
        {
            $content .='<tr>
          <td colspan="4">District Production and Marketing Officer Remarks</td>
        </tr>
      ';
        }
        else
        {
            $content .='<tr>
          <td colspan="4">Subcounty Chief/Town Clerk Remarks</td>
        </tr>
       <tr>
          <td colspan="4">Subject Matter Specialist Remarks</td>
        </tr>';
        }

        $content .='
       <tr>
          <td colspan="4">Challenges Found
         <table class="table table-sm m-b-0" style="font-weight: normal;font-size: 14px">
                <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Challenges</th>
                  </tr>
                </thead>
                <tbody>
                  '.self::getChallenges($id).'                            
                </tbody>
              </table>
            </td> 
       <tr>
          <td colspan="4">Lessons Learnt
            <table class="table table-sm m-b-0" style="font-weight: normal;font-size: 14px">
              <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Lessons</th>
                </tr>
              </thead>
              <tbody>
                '.self::getLessons($id).'                            
              </tbody>
            </table>
          </td>

       </tr>
       
        
        <tr>
          <td>My Photo Submission Statistics<br />
           </td>
         
        </tr>
        <tr>
          <td colspan="4">
          
          <div class="row m-t-40">
                    <div class="col-md-12">
                        <h4 class="card-title">Gallery </h4>
                        <h6 class="card-subtitle m-b-20 text-muted">Some of the photos submitted this quarter!</h6> </div>
                </div>
                <div class="card-columns el-element-overlay">
                    
                    '.self::getLatestEOPhotos(0,9,$id).'
                   
                    
</td>
        </tr>
       
        </tbody>
        
        </table>  
        </div>     
        ';

        return $content;

    }

    public static function plotEOLocations($id){

        $sql = database::performQuery("SELECT * FROM ext_area_daily_activity WHERE user_id=$id AND gps_latitude != '' AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'");
        if($sql->num_rows > 0){

            $content ='';
            while($data=$sql->fetch_assoc()){

                $content .='
                
          var lonLat'.$data['id'].' = new OpenLayers.LonLat( '.$data['gps_longitude'].' ,'.$data['gps_latitude'].' )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
          
          ';
            }

            return $content;
        }
        else
            return '
            //Default Location
             var lonLat = new OpenLayers.LonLat( 32.583333 ,0.316667 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
          
            ';
    }


    public static function plotEOMarkers($id){

        $sql = database::performQuery("SELECT * FROM ext_area_daily_activity WHERE user_id=$id AND gps_latitude != '' AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'");
        if($sql->num_rows > 0){

            $content ='';
            while($data=$sql->fetch_assoc()){

                $content .='
                    markers.addMarker(new OpenLayers.Marker(lonLat'.$data['id'].'));                  
                   ';
            }

            return $content;
        }
        else
            return '
               markers.addMarker(new OpenLayers.Marker(lonLat));

          
            ';
    }


    //Get Acivities by EO
    public static function getEOActivities($id){
        $content = '';
        $sql = database::performQuery("SELECT quarterly_activity_id,ext_activitys.name,COUNT(*) as times, SUM(num_ben_total)  as total
                                            FROM `ext_area_daily_activity`,ext_activitys 
                                            WHERE `user_id` LIKE '$id' 
                                              AND ext_area_daily_activity.quarterly_activity_id = ext_activitys.id   
                                              AND ext_area_daily_activity.financial_year  =  '$_SESSION[financial_year]'
                                              AND ext_area_daily_activity.quarter = $_SESSION[quarter]
                                            GROUP BY quarterly_activity_id ORDER BY times DESC, name ASC
                                             ");
      if($sql->num_rows>0){
          $x =  1;
        while($data=$sql->fetch_assoc())
        {
            $content .='<tr>
                        <th>'.$x.'</th>
                        <td>'.$data['name'].'</td>
                        <td>'.$data['times'].'</td>
                        <td>'.number_format($data['total']).'</td>
                        </tr>';

            $x++;
        }
      }
      else
      {
          $content .='<tr>
                        <th>1</th>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        </tr>';
      }

      return $content;
    }


    //Get Topics by EO
    public static function getEOTopics($id){
        $content = '';
        $sql = database::performQuery("SELECT topic,ext_topics.name,COUNT(*) as times, SUM(num_ben_total)  as total
                                            FROM `ext_area_daily_activity`,ext_topics
                                            WHERE `user_id` LIKE '$id' AND ext_area_daily_activity.topic = ext_topics.id     
                                            AND topic != 119
                                            AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                            GROUP BY topic ORDER BY times DESC, name ASC
                                             ");
      if($sql->num_rows>0){
          $x =  1;
        while($data=$sql->fetch_assoc())
        {
            $content .='<tr>
                        <th>'.$x.'</th>
                        <td>'.$data['name'].'</td>
                        <td>'.$data['times'].'</td>
                        <td>'.number_format($data['total']).'</td>
                        </tr>';

            $x++;
        }
      }
      else
      {
          $content .='<tr>
                        <th>1</th>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        </tr>';
      }

      return $content;
    }


    public static function getActivityDetailByImage($id){

        $sql = database::performQuery("SELECT * FROM ext_area_daily_activity WHERE id=$id");
        return $sql->fetch_assoc();
    }


    public static function getActivityDetails($id){
        $sql = database::performQuery("SELECT * FROM ext_activitys WHERE id=$id");
        return $sql->fetch_assoc();
    }

    public static function getVillageDetails($id){
        $sql = database::performQuery("SELECT * FROM village WHERE id=$id");
        return $sql->fetch_assoc();
    }



    public static function getLatestEOPhotos($limit_a=0,$limit_b=1,$id){

        $sql = database::performQuery("SELECT url,activity_id,ext_area_daily_activity.id FROM ext_area_daily_activity_image,ext_area_daily_activity 
                                               WHERE ext_area_daily_activity.id = ext_area_daily_activity_image.activity_id
                                               AND user_id = $id 
                                               AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                               ORDER BY DATE(date) ASC
                                                LIMIT $limit_a,$limit_b");
        if($sql->num_rows > 0){
            $content = '';
            while($data = $sql->fetch_assoc()) {

                $activity_id = self::getActivityDetailByImage($data['id']);
               // print_r($activity_id);
                $activity = self::getActivityDetails($activity_id['quarterly_activity_id']);
               // print_r($activity);

                $village = self::getVillageDetails($activity_id['village_id']);

//                $content .='<div class="card">
//                        <div class="el-card-item">
//                            <div class="el-card-avatar el-overlay-1">
//                                <a class="image-popup-vertical-fit" href="'.ROOT.'/'.$data['url'].'"> <img src="'.ROOT.'/'.$data['url'].'" alt="user" /> </a>
//                            </div>
//                            <div class="el-card-content">
//                                <h4 class="m-b-0">'.$activity['name'].' - '.$village['name'].' </h4> <span class="text-muted"> '.date("Y-m-d",strtotime($activity_id['date'])).' </span>
//                            </div>
//                        </div>
//                    </div>';

                //New Lightbox Implementation
                $content .='<a class="image-link" href="'.ROOT.'/'.$data['url'].'" data-lightbox="gallery" data-title="'.$activity['name'].' - '.$village['name'].' - '.date("Y-m-d",strtotime($activity_id['date'])).'"><img class="example-image" src="'.ROOT.'/'.$data['url'].'" style="width:150px" alt="'.$activity['name'].' - '.$village['name'].' - '.date("Y-m-d",strtotime($activity_id['date'])).'" /></a>';

            }
            return $content;
        }
        else
            return "No Photo Avaialble";
    }

    //Get Entreprize by EO
    public static function getEOEntreprize($id){
        $content = '';
        $sql = database::performQuery("SELECT entreprise,km_category.name,COUNT(*) as times, SUM(num_ben_total)  as total
                                            FROM `ext_area_daily_activity`,km_category
                                            WHERE `user_id` LIKE '$id' AND ext_area_daily_activity.entreprise = km_category.id    
                                            AND entreprise != 198
                                            AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                            GROUP BY entreprise ORDER BY times DESC, name ASC
                                             ");
      if($sql->num_rows>0){
          $x =  1;
        while($data=$sql->fetch_assoc())
        {
            $content .='<tr>
                        <th>'.$x.'</th>
                        <td>'.$data['name'].'</td>
                        <td>'.$data['times'].'</td>
                        <td>'.number_format($data['total']).'</td>
                        </tr>';

            $x++;
        }
      }
      else
      {
          $content .='<tr>
                        <th>1</th>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        </tr>';
      }

      return $content;
    }

    //Get Locationn by EO
    public static function getEOLocations($id){
        $content = '';
        $sql = database::performQuery("SELECT `village_id`,village.name,COUNT(*) as times, SUM(num_ben_total) as total 
                                           FROM `ext_area_daily_activity`,village 
                                           WHERE ext_area_daily_activity.user_id LIKE '$id' AND ext_area_daily_activity.village_id = village.id 
                                           AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                           GROUP BY village_id ORDER BY times DESC,name ASC
                                           ");
      if($sql->num_rows>0){
          $x =  1;
        while($data=$sql->fetch_assoc())
        {
            $content .='<tr>
                        <th>'.$x.'</th>
                        <td>'.$data['name'].'</td>
                        <td>'.$data['times'].'</td>
                        <td>'.number_format($data['total']).'</td>
                        </tr>';

            $x++;
        }
      }
      else
      {
          $content .='<tr>
                        <th>1</th>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        </tr>';
      }

      return $content;
    }

    //Prepare user_category for search
    public function prepRegion()
    {
        if (isset($_REQUEST['user_cat']))
            return ' AND region.id=' . $_REQUEST['region'];
        else
            return '';
    }


    public static function switchUserManageList(){

        $id = $_SESSION['user']['location_id'];



        $user_cat = 0;
        switch($_SESSION['user']['user_category_id']){

            case 2:
                $user_cat ='';
                break;

            case 3:
                $user_cat ='';
                break;

            case 4:
                $user_cat ='';
                break;

            default:
                break;

        }

        $content = '';
        switch($_SESSION['user']['user_category_id']){


            case 1:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND subcounty.id = $id
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                   ";
                break;


            case 11:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,user,county,subcounty
                   WHERE district.id = ".$_SESSION['user']['district_id']."
                   AND district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9 OR user_category_id = 2 OR user_category_id = 3 OR user_category_id = 4  OR user_category_id = 10 )
              
                   ";
                break;


            case 10:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,user,county,subcounty
                   WHERE district.id = ".$_SESSION['user']['district_id']."
                   AND district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9 OR user_category_id = 2 OR user_category_id = 3 OR user_category_id = 4  OR user_category_id = 11  OR user_category_id = 12 OR user_category_id = 13  OR user_category_id = 14  OR user_category_id = 12  OR user_category_id = 19  OR user_category_id = 20  OR user_category_id = 21  OR user_category_id = 22  OR user_category_id = 23 OR user_category_id = 1)
              
                   ";
                break;

            case 6:
            case 5:
            case 15:

                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,user,county,subcounty
                   WHERE  district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                  
                   ";


                break;

            case 16:

                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,user,county,subcounty
                   WHERE  district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                    AND (user_category_id = 9 OR user_category_id = 20 OR user_category_id = 3 OR user_category_id = 10 OR user_category_id = 23 )
                   ";


                break;


            case 17:

                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,user,county,subcounty
                   WHERE  district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                    AND  (user_category_id = 8 OR user_category_id = 19 OR user_category_id = 22 OR user_category_id = 2 OR user_category_id = 10)
                   ";


                break;

            case 18:

                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,user,county,subcounty
                   WHERE  district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                    AND (user_category_id = 7 OR user_category_id = 21  OR user_category_id = 4  OR user_category_id = 10 )
                   ";


                break;

            case 2:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND district.id =  ".$_SESSION['user']['district_id']."
                   AND  (user_category_id = 8 OR user_category_id = 19 OR user_category_id = 22)
                   ";

                break;
            case 3:
            $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND district.id =  ".$_SESSION['user']['district_id']."
                   AND  (user_category_id = 9 OR user_category_id = 20 OR user_category_id = 23)
                   ";

            break;
            case 4:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND district.id =  ".$_SESSION['user']['district_id']."
                   AND (user_category_id = 7 OR user_category_id = 21)
                   ";

                break;

            default:
                $content ='';
                break;

        }


        return $content;
    }


    public static function getChallenges($id){

      $content = '';
      $sql = database::performQuery("SELECT * FROM `mod_ediary` WHERE a14 = $id");
      if($sql->num_rows>0){
          $x =  1;

        
        while($data=$sql->fetch_assoc())
        {
            $content .='<tr>
                        <th>'.$x.'</th>
                        <td>'.$data['a13'].'</td>
                        </tr>';

            $x++;
        }
      }
      else
      {
          $content .='<tr>
                        <th>1</th>
                        <td>None</td>
                        </tr>';
      }

      return $content;
    }

    public static function getLessons($id){

      $content = '';
      $sql = database::performQuery("SELECT * FROM `mod_ediary` WHERE a14 = $id");
      if($sql->num_rows>0){
          $x =  1;

        
        while($data=$sql->fetch_assoc())
        {
            $content .='<tr>
                        <th>'.$x.'</th>
                        <td>'.$data['a21'].'</td>
                        </tr>';

            $x++;
        }
      }
      else
      {
          $content .='<tr>
                        <th>1</th>
                        <td>None</td>
                        </tr>';
      }

      return $content;
    }


}
