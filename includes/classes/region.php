<?php

class region
{

    public static function getConnection(){
        $dbConfig = database::getDBConfigs();
        $servername = $dbConfig['host'];
        $username = $dbConfig['user'];
        //$password = "";
        $password = $dbConfig['password'];
        $dbname = $dbConfig['database'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;

    }



    public static function getSubRegionByRegion($id){


        $sql= database::performQuery("SELECT * FROM sub_region WHERE region_id=$id ORDER BY name ASC");
        $sub_reg_arr = array();
        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Sub-Region');
        while($data=$sql->fetch_assoc()){

            $sub_reg_arr[] = array("id" => $data['id'], "name" =>  strtoupper($data['name']));

        }

        // encoding array to json format
        echo json_encode($sub_reg_arr);
    }



    public static function getDistrictBySubRegion($id){


        $sql= database::performQuery("SELECT * FROM district WHERE sub_region_id=$id  ORDER BY name ASC");
        $sub_reg_arr = array();
        $sub_reg_arr[] = array("id" => 0, "name" => 'Select District');
        while($data=$sql->fetch_assoc()){

            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

        }

        // encoding array to json format
        echo json_encode($sub_reg_arr);
    }



    public static function getCountyByDistrict($id){


        $sql= database::performQuery("SELECT * FROM county WHERE district_id=$id  ORDER BY name ASC");
        $sub_reg_arr = array();
        $sub_reg_arr[] = array("id" => 0, "name" => 'Select County / Municipality');
        while($data=$sql->fetch_assoc()){

            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

        }

        // encoding array to json format
        echo json_encode($sub_reg_arr);
    }



    public static function getSubcountyByCounty($id){

        $sql= database::performQuery("SELECT * FROM subcounty WHERE county_id=$id  ORDER BY name ASC");
        $sub_reg_arr = array();
        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Sub-County / Division');
        while($data=$sql->fetch_assoc()){

            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

        }

        // encoding array to json format
        echo json_encode($sub_reg_arr);
    }



    public static function getParishBySubcounty($id){


        $sql= database::performQuery("SELECT * FROM parish WHERE subcounty_id=$id ORDER BY name ASC");
        $sub_reg_arr = array();
        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Parish / Town');
        while($data=$sql->fetch_assoc()){

            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

        }

        // encoding array to json format
        echo json_encode($sub_reg_arr);
    }




    public static function getVillageByParish($id){


        $sql= database::performQuery("SELECT * FROM village WHERE parish_id=$id ORDER BY name ASC");
        $sub_reg_arr = array();
        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Village / Ward');
        while($data=$sql->fetch_assoc()){

            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

        }

        // encoding array to json format
        echo json_encode($sub_reg_arr);
    }



//
//    public static function getSubRegionByRegion($id){
//
//
//        $sql= database::performQuery("SELECT * FROM sub_region WHERE region_id=$id ORDER BY name ASC");
//        $sub_reg_arr = array();
//        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Sub-Region');
//        while($data=$sql->fetch_assoc()){
//
//            $sub_reg_arr[] = array("id" => $data['id'], "name" =>  strtoupper($data['name']));
//
//        }
//
//        // encoding array to json format
//        echo json_encode($sub_reg_arr);
//    }
//
//
//
//    public static function getDistrictBySubRegion($id){
//
//
//        $sql= database::performQuery("SELECT * FROM district WHERE sub_region_id=$id  ORDER BY name ASC");
//        $sub_reg_arr = array();
//        $sub_reg_arr[] = array("id" => 0, "name" => 'Select District');
//        while($data=$sql->fetch_assoc()){
//
//            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
//
//        }
//
//        // encoding array to json format
//        echo json_encode($sub_reg_arr);
//    }



//    public static function getCountyByDistrict($id){
//
//
//        $sql= database::performQuery("SELECT * FROM county WHERE district_id=$id  ORDER BY name ASC");
//        $sub_reg_arr = array();
//        $sub_reg_arr[] = array("id" => 0, "name" => 'Select County / Municipality');
//        while($data=$sql->fetch_assoc()){
//
//            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
//
//        }
//
//        // encoding array to json format
//        echo json_encode($sub_reg_arr);
//    }
//
//
//
//    public static function getSubcountyByCounty($id){
//
//        $sql= database::performQuery("SELECT * FROM subcounty WHERE county_id=$id  ORDER BY name ASC");
//        $sub_reg_arr = array();
//        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Sub-County / Division');
//        while($data=$sql->fetch_assoc()){
//
//            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
//
//        }
//
//        // encoding array to json format
//        echo json_encode($sub_reg_arr);
//    }
//
//

//    public static function getParishBySubcounty($id){
//
//
//        $sql= database::performQuery("SELECT * FROM parish WHERE subcounty_id=$id ORDER BY name ASC");
//        $sub_reg_arr = array();
//        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Parish / Town');
//        while($data=$sql->fetch_assoc()){
//
//            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
//
//        }
//
//        // encoding array to json format
//        echo json_encode($sub_reg_arr);
//    }
//
//
//
//
//    public static function getVillageByParish($id){
//
//
//        $sql= database::performQuery("SELECT * FROM village WHERE parish_id=$id ORDER BY name ASC");
//        $sub_reg_arr = array();
//        $sub_reg_arr[] = array("id" => 0, "name" => 'Select Village / Ward');
//        while($data=$sql->fetch_assoc()){
//
//            $sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
//
//        }
//
//        // encoding array to json format
//        echo json_encode($sub_reg_arr);
//    }



    //Return IDs for District with regions
    public static function activeRegion($id)
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id FROM district WHERE region_id=$id");
        while($data = $sql->fetch_assoc()){
            $content[]= 'UG-'.$data['map_id'].'';
        }

        return $content;
    }


    //Map switch
    public static function prepMapSwitch(){

        $regions = self::activeRegion($_SESSION['region_active']);
        $content = 'switch(region.id){';
        foreach($regions as $region){

            $content .= "case '$region': ";
        }
        $content .= '
        region.setFill(\'#33BABE\');
        break;
                
        default:
        region.setDisabled(true);
        break;
        
        }

       
       ';
        return $content;
    }



    //Map switch
    public static function prepMapSwitchAllRegions(){

        $central = self::activeRegion(1);
        $east = self::activeRegion(2);
        $north = self::activeRegion(3);
        $west = self::activeRegion(4);
        $content = 'switch(region.id){';


        foreach($central as $region){

            $content .= "case '$region': ";
        }
        $content .= '
        region.setFill(\'#9A12B3\');
        break;';




        foreach($east as $region){

            $content .= "case '$region': ";
        }
        $content .= '
        region.setFill(\'#F3C200\');
        break;';




        foreach($north as $region){

            $content .= "case '$region': ";
        }
        $content .= '
        region.setFill(\'#26C281\');
        break;';



        foreach($west as $region){

            $content .= "case '$region': ";
        }
        $content .= '
        region.setFill(\'0000FF\');
        break;';



        $content .='default:
        break;
        
        }

       
       ';
        return $content;
    }



    //Region
    public static function Allregions(){
        
        $content ='<div class="row about-links-cont" data-auto-height="true">
                                            <div class="col-md-6 about-links">
                                                <div class="row">
                                                    <div class="col-sm-6 about-links-item">
                                                    <a href="'.ROOT.'/find-a-market/region/central">    <h4><button class=" btn btn-xs btn-circle purple-seance"/>Central Region markets</h4> </a>
                                                        <ul>
                                                            '.self::regionBio('Central')['brief'].' The region has over '.self::regionBio('Central')['schools'].' markets. Find more about this region <a href="'.ROOT.'/find-a-market/region/central"> here</a>.
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm-6 about-links-item">
                                                     <a href="'.ROOT.'/find-a-market/region/western">    <h4><button class="btn btn-xs btn-circle blue"/>Western Region markets</h4> </a>
                                                        <ul>
                                                            '.self::regionBio('Western')['brief'].' The region has over '.self::regionBio('Western')['schools'].' markets. Find more about this region <a href="'.ROOT.'/find-a-market/region/western"> here</a>.
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 about-links-item">
                                                     <a href="'.ROOT.'/find-a-market/region/eastern">    <h4><button class="btn btn-xs btn-circle yellow-crusta"/>Eastern Region markets</h4> </a>
                                                        <ul>
                                                           '.self::regionBio('Eastern')['brief'].' The region has over '.self::regionBio('Eastern')['schools'].' markets. 
                                                               Find more about this region <a href="'.ROOT.'/find-a-market/region/eastern"> here</a>.
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm-6 about-links-item">
                                                    <a href="'.ROOT.'/find-a-market/region/northern">     <h4><button class="btn btn-xs  btn-circle green-jungle"/>Northern Region markets</h4> </a>
                                                        <ul>
                                                            '.self::regionBio('Northern')['brief'].' The region has over '.self::regionBio('Northern')['schools'].' markets. Find more about this region <a href="'.ROOT.'/find-a-market/region/northern"> here</a>.
                                                        </ul>
                                                    </div>
                                                </div>
    
                                            </div>
                                            <div class="col-md-6 col-sm-12" style="padding:60px">
                                                <div id="map"></div>
                                            </div>
                                        </div>
    
    
    
                        ';
        
       return $content;
    }
    
    
    //District Page
    public static function viewRegion() {
        $name = ucwords(strtolower($_REQUEST['name']));
        //Check If District Exists
        $sql = database::performQuery("SELECT * FROM region WHERE name LIKE '$name'");
        if($sql->num_rows == 0)
             notFound(); 
            else
            {
                while ($data= $sql->fetch_assoc()) {
                    $region = $data;
                }
                $_SESSION['region_active'] = $region['id'];
                  
                $content = "";
                $content .=' <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <!-- BEGIN BLOCKQUOTES PORTLET-->
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <span class="caption-subject font-green bold uppercase">'.$name.' Region </span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                            '.ucwords($name).'  Region is one of the four administrative regions found in Uganda. 
                                                                The region has 
                                                                '.number_format(self::countDistrict($region['id'])).' Districts,
                                                                    '.number_format(self::countCounties($region['id'])).' Counties,
                                                                     '.number_format(self::countSubcounties($region['id'])).' sub counties,
                                                                        '.number_format(self::countParishes($region['id'])).' Parishes and 
                                                                             '.number_format(self::countVillages($region['id'])).' Villages.
                                                                   
                                                                        
                                                                        The region has over '.number_format(self::countRegionSchoolsWithID($region['id'])).' markets with
                                                                        '.self::districtDescription2($region['id']).'.
                                                    </div>
                                                    </div>
                                                    <!-- END BLOCKQUOTES PORTLET-->
                                                </div>
                                                <div>
                                                    <!-- BEGIN GENERAL PORTLET-->
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="icon-social-dribbble font-blue-sharp"></i>
                                                                <span class="caption-subject font-blue-sharp bold uppercase">'.$name.' Region Market Statistics</span>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h3>Markets by  Category</h3>
    
    
    
    
    
    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Category </th>
                                                                        <th> Market </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewRegionSchoolsCategory($region);
                $content .=  self::viewRegionTotalSchool($region);
                $content .=' </tbody>
                                        </table>
                                                        </div>
    
    
    
    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="map"></div>
                                  
                                                                   <br />
                                                                   <a class="btn btn-xs" style="background: #33BABE" href="javascript:;"> &nbsp; &nbsp; </a>  <b> '.ucwords(strtolower($name)).' Region</b>
                                    
                                    
                                                                
    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END GENERAL PORTLET-->
                                                <div>
                                                    <!-- BEGIN BLOCKQUOTES PORTLET-->
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="icon-social-dribbble font-green"></i>
                                                                <span class="caption-subject font-green bold uppercase">Direct Market Players</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                                       <div class="row">
                                                                       <div class="col-md-6">
    
                                    
                                      
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Types </th>
                                                                        <th> Total </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewRegionGender($region);
                    $content .=' </tbody>
                                             </table>
                                                        </div>
    
                                
                                    
                                    
                                                                </div>
                                                            <div class="col-md-6">
    
                                    
    
                                    
                                    
                                        
    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            
                                                        </div>
    
                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END BLOCKQUOTES PORTLET-->
                                                </div>
                                                <!-- BEGIN WELLS PORTLET-->
                                                <div>
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="icon-social-dribbble font-red"></i>
                                                                <span class="caption-subject font-red bold uppercase">Districts In '.ucwords(strtolower($region['name'])).' Region</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
    
								
								
															<div class="row">
                                                                <div class="col-md-6">
                                                                   <h3>Region Districts</h3>
                                                                            <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> District </th>
                                                                        <th> Markets </th>
                                                                        <th>  </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewRegionDistrictSchoolsWithID($region['id']);
    
                $content .=' </tbody>           </table>
                                                        </div>                                                                        
                                                        
                                                                </div>
                    
                    
                     <div class="col-md-6">
                    <h3>Other Regions</h3>
                                                                   
                                                                            <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Region </th>
                                                                        <th> Markets </th>
                                                                        <th>  </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewRegionSchoolsWithID($region['id']);
    
                $content .=' </tbody>           </table>
                                                        </div>                                                                        
                                                        
                                                                </div>
                                   
                                                            </div>
								
								
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END WELLS PORTLET-->
    
                                            </div>
                                            
                                        
                                            
    
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->';
                 
                return $content;
            }
             
    
    }



    private static function viewRegionSchoolsCategory($region){

        $sql = database::performQuery("
            SELECT * FROM market_category
            WHERE parent_id = 0
            
            ");

        $content = '';
        $colors = ['danger','success','info','warning'];
        while ($data = $sql->fetch_assoc())
        {

            $content .='<tr>
                               <td class="highlight red"> <div class="'.$colors[rand(0,3)].'"></div> &nbsp; <b> '.ucwords(strtolower($data['name'])).'</b> </td>
                                <td> &nbsp; </td>
                                <td>
                                  &nbsp;
                                </td>
                            </tr>';

            //Child Categories

            $sqlc = database::performQuery("
            SELECT market_category.name,market_category.id,COUNT(*) as schools
            FROM region,district,market,county,subcounty,parish,market_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND region.id = district.region_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND market.market_category_id = market_category.id
            AND region.id = $region[id]
            AND parent_id = $data[id]
           GROUP BY market_category.id
            
            ");
            if($sqlc->num_rows > 0){
                while ($datac = $sqlc->fetch_assoc())
                {

                    $content .='<tr>
                                <td><small style="text-transform: capitalize;">'.ucwords(strtolower($datac['name'])).'</small></td>
                                <td> '.$datac['schools'].'</td>
                                <td>
                                <a href="'.ROOT.'/?category='.$datac['id'].'&region='.$region['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                            
                                </td>
                            </tr>';
                }
            }


        }



        return $content;
    }



    private static function viewRegionFoundingBody($region)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="success"></div> &nbsp; <b> Founding Body</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';
        
        $sql= database::performQuery("
            
            SELECT founding_body.id,founding_body.name,COUNT(*) as schools
            FROM region,district,school,county,subcounty,parish,founding_body
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND founding_body.id = school.founding_body_id
            AND region.id = $region[id]
            GROUP BY founding_body.id
            ORDER BY founding_body.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?founding_body='.$data['id'].'&region='.$region['id'].'&action=search">  <span class="label label-sm label-success"> View</span></a>
                                </td>
                            </tr>';
        }
        
         
        return $content;
    }
    

private static function viewRegionGender($region)
    {
        $content = '';
        $content .='<tr>
                                <td></td>
                                <td></td>
                            </tr>';
    
        $sql= database::performQuery("
    
            SELECT dmp_category.id,dmp_category.name,COUNT(*) as schools
            FROM region,district,dmp,county,subcounty,parish,dmp_category
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = dmp.parish_id
            AND dmp.dmp_category_id = dmp_category.id
            AND region.id = $region[id]
            GROUP BY dmp_category.id
            ORDER BY dmp_category.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?category='.$data['id'].'&region='.$region['id'].'&action=searchDMP">  <span class="label label-sm label-success"> View</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    private static function viewRegionOwnership($district)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Ownership</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';
    
        $sql= database::performQuery("
    
            SELECT ownership.id,ownership.name,COUNT(*) as schools
            FROM region,district,school,county,subcounty,parish,ownership
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND ownership.id = school.ownership_id
            AND region.id = $district[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?ownership='.$data['id'].'&region='.$district['id'].'&action=search">  <span class="label label-sm label-success"> View</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    
    private static function viewRegionBoarding($region)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Boarding Facilities</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';
    
        $sql= database::performQuery("
    
            SELECT boarding_type.id,boarding_type.name,COUNT(*) as schools
            FROM region,district,school,county,subcounty,parish,boarding_type
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND boarding_type.id = school.boarding_type_id
            AND region.id = $region[id]
            GROUP BY boarding_type.id
            ORDER BY boarding_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?boarding='.$data['id'].'&region='.$region['id'].'&action=search">  <span class="label label-sm label-success"> View</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    

    private static function viewRegionTotalSchool($district)
    {
        $content = '';
        
            $content .='<tr>
                               <td>  <b> Total Markets</b> </td>
                                <td colspan=2> <b>'.self::countRegionSchoolsWithID($district['id']).'</b></td>
                               
                            </tr>';
       return $content;
         
        
    }

    public static function regionBio($name) {
        $sql = database::performQuery("SELECT region.name,brief,COUNT(*) as schools
            FROM region,district,county,subcounty,parish,market
            WHERE region.name LIKE '$name'
            AND region.id = district.region_id
            AND district.id = county.district_id
            AND county.id = subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id");
        return $sql->fetch_assoc();
    }

    public static function getParentMarket($id){

        $content = '';
        $sql = database::performQuery("SELECT * FROM market_category WHERE id=$id");
        while($data=$sql->fetch_assoc()){

            $content = $data['name'];
        }

        return $content;
    }


    //Returjn parent categories with their school total in the district
    public static function districtDescription2($id) {
        $sql = database::performQuery("
            
            SELECT market_category.id,market_category.parent_id,market_category.name as name,COUNT(*) as total
            FROM region,district,market,county,subcounty,parish,market_category
            WHERE district.id=county.district_id
                AND region.id = district.region_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = market.parish_id
				AND market_category.id = market.market_category_id
				AND region.id = $id
				GROUP BY market_category.id
            
            ")  ;
        $content = [];
        while ($data=$sql->fetch_assoc()) {
            $content[]= $data['total'].'  '.self::getParentMarket($data['parent_id']).' '.ucwords(strtolower($data['name'])).' Markets';
        }
        
        return implode(', ',$content);
    
    }
    
    
    
    
    
    //count subcounties
    public static function countDistrict($id) {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM region,district
            WHERE region.id=district.region_id
            AND region.id = $id
            GROUP BY region.id,district.id
            ");
        return $sql->num_rows;
    }
    
    
    
    //count subcounties
    public static function countCounties($id) {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM region,district,county
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND region.id = $id
            GROUP BY region.id,district.id,county.id
            ");
        return $sql->num_rows;
    }
    
    //count subcounties
    public static function countSubcounties($id) {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM region,district,county,subcounty
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND region.id = $id
            GROUP BY region.id,district.id,county.id,subcounty.id
            ");
        return $sql->num_rows;
    }
    

    //count parishes
    public static function countParishes($id) {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM region,district,county,subcounty,parish
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND region.id = $id
            GROUP BY region.id,district.id,county.id,subcounty.id,parish.id
            ");
        return $sql->num_rows;
    }
    

    //count villages
    public static function countVillages($id) {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM region,district,county,subcounty,parish,village
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = village.parish_id
            AND region.id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id,village.id
            ");
        return $sql->num_rows;
    }
    

    public static function countRegionSchoolsWithCategory($id,$cid)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM region,district,market,county,subcounty,parish,market_category,produce_category
            WHERE district.id=county.district_id
            AND region.id  = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND market.id = school_category.school_id
            AND school_category.category_id = category.id
            AND region.id = $id
            AND category_id = $cid
    
            ");
    
        while ($data = $sql->fetch_assoc())
            return number_format($data['schools']);
    }
    
    

    //Get Random 10 Districts with their school count for specific region
    public static function getSchoolsRegion($region){
    
        $sql = database::performQuery("
            SELECT district.name,district.id,district.map_id,COUNT(*) as schools
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND region_id = $region
            GROUP BY district.name
            ORDER BY district.name ASC
            ");
        $x=1;
        $content = '';
    
        while ($data = $sql->fetch_assoc()) {
    
            //Color Button Icons
            $color = "";
            switch($region)
            {
                case 1: $color = '#9A12B3'; break;
                case 2: $color = '#F3C200'; break;
                case 3: $color = '#26C281'; break;
                case 4: $color = '#3598DC'; break;
                default: break;
                	
            }
    
             
            $content .='<li> <small style="font-size:10px"> <i class="icon-check" style="color:'.$color.'"></i> <a href="'.ROOT.'/find-a-market/district/'.strtolower($data['name']).'">'.ucwords(strtolower($data['name'])).' </a> <b>('.$data['schools'].')</b></small></li>';
             
        }
        return $content;
    
    }
    

    public static function countRegionSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM region,district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND region.id = $id
    
            ");
    
        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }
    
    
    
    public static function viewRegionSubcountySchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT county.name as county,district.name as district,subcounty.id as id,subcounty.name as name, COUNT(*) as schools
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND district.id = $id
            GROUP BY district.id,county.id,subcounty.id
            ORDER BY district.name ASC,county.id ASC, subcounty.id ASC
            ");
        $content  ="";
        $new = '';
        $old = '';
        $colors = ['info','success','danger','warning'];
        while ($data = $sql->fetch_assoc())
        {
    
            $new = $data['county'];
            $content .='<tr>';
            if($new != $old)
                $content .='<tr><td class="highlight" colspan=3> <div class="'.$colors[rand(0,3)].'"></div> &nbsp; <b>'.$data['county'].' COUNTY</b> </td></tr>';
                else
                    $content .='';
                    $content .=' <td><small> '.$data['name'].'</small></td>
                                <td><small> '.$data['schools'].'</small></td>
                                <td>
                                  <a href="'.ROOT.'/find-a-market/subcounty/'.strtolower($data['district']).'/'.makeSeo($data['name']).'/'.$data['id'].'">  <span class="label label-sm label-warning"> View</span></a>
                                </td>
                            </tr>';
                    $old = $new;
        }
    
    
    
        return $content;
    }
     
    
    
    public static function viewRegionDistrictSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT district.id,district.name, COUNT(*) as schools
            FROM district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND district.region_id = $id
            GROUP BY district.id
            ORDER BY district.name ASC
            ");
        $content  ="";
        while ($data = $sql->fetch_assoc())
        {
            $content .='<tr><td> '.ucwords(strtolower($data['name'])).' District</td>
                                <td><small> '.$data['schools'].'</small></td>
                                <td>
                                  <a href="'.ROOT.'/find-a-market/district/'.strtolower($data['name']).'">  <span class="label label-sm label-info"> View</span></a>
                                </td>
                            </tr>';
    
        }
    
    
    
        return $content;
    }
     
    

    public static function viewRegionSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT region.id,region.name, COUNT(*) as schools
            FROM region,district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND region.id = district.region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            GROUP BY region.id
            ORDER BY region.id ASC
            ");
        $content  ="";
        while ($data = $sql->fetch_assoc())
        {
            $content .='<tr><td> '.ucwords(strtolower($data['name'])).' Region</td>
                                <td><small> '.$data['schools'].'</small></td>
                                <td>
                                  <a href="'.ROOT.'/find-a-market/region/'.strtolower($data['name']).'">  <span class="label label-sm label-info"> View</span></a>
                                </td>
                            </tr>';
    
        }
    
    
    
        return $content;
    }





    public static function getCountiesByDistrict(){

        $id =  database::prepData($_REQUEST['id']);

        $conn = self::getConnection();

        $sql =  "SELECT  * FROM `county` WHERE district_id = ?";


        $stmt =  $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $counties = [];

        if($stmt->execute()) {
            $result = $stmt->get_result();
            $counties[] = array("id" => 0, "name" => "--select county--");

            while($data = $result->fetch_assoc()){

                $counties[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

            }
            echo json_encode($counties);
        }
    }


    public static function getSubCountiesByCounty(){

        $id =  database::prepData($_REQUEST['id']);

        $conn = self::getConnection();

        $sql =  "SELECT  * FROM `subcounty` WHERE county_id = ?";


        $stmt =  $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $subcounties = [];

        if($stmt->execute()) {
            $result = $stmt->get_result();
            $subcounties[] = array("id" => 0, "name" => "--select sub county--");
            while($data = $result->fetch_assoc()){

                $subcounties[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

            }
            echo json_encode($subcounties);
        }
    }

    public static function getSubcountiesByDistrict(){

        $id =  database::prepData($_REQUEST['id']);

        $sql= database::performQuery("SELECT * FROM county WHERE district_id=$id  ORDER BY name ASC");
        $county_ids = array();
        while($data=$sql->fetch_assoc()){
            $county_ids[] = $data['id'];

        }

        $county_ids = implode("', '", $county_ids);
       
        
        $subcounties[] = array("id" => "", "name" => "--select sub county--");
        $sql= database::performQuery("SELECT * FROM subcounty WHERE county_id IN ('$county_ids')  ORDER BY name ASC");
        while($data=$sql->fetch_assoc()){
            $subcounties[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
        }
        
        echo json_encode($subcounties);
    }

    public static function getParishesBySubCounty(){

        $id =  database::prepData($_REQUEST['id']);
         
        $parishes[] = array("id" => "", "name" => "--select parish--");

        $sql= database::performQuery("SELECT * FROM parish WHERE subcounty_id=$id  ORDER BY name ASC");

        while($data=$sql->fetch_assoc()){
            $parishes[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
        }
        
        echo json_encode($parishes);
        
    }

    public static function getVillagesByParish(){

        $id =  database::prepData($_REQUEST['id']);

        $conn = self::getConnection();

        $sql =  "SELECT * FROM `village` WHERE parish_id = ?";


        $stmt =  $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $villages = [];

        if($stmt->execute()) {
            $result = $stmt->get_result();
            $villages[] = array("id" => 0, "name" => "--select village--");
            while($data = $result->fetch_assoc()){

                $villages[] = array("id" => $data['id'], "name" => strtoupper($data['name']));

            }
            echo json_encode($villages);
        }
    }



}



?>