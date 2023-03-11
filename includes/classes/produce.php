<?php

/**
 * Created by PhpStorm.
 * User: Herbert
 * Date: 19/11/2016
 * Time: 17:33
 */


class produce
{


    //Get Ownership Name
    public static function getProduceName($id){
        $sql = database::performQuery("SELECT name FROM produce_category WHERE id=$id");
        $ret = $sql->fetch_assoc();
        return $ret['name'];
    }

    //Return IDs for District with active Subregions
    public static function activeDistrict($id)
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id 
                                        FROM district,county,subcounty,parish,market,market_has_produce_category
                                        WHERE produce_category_id=$id
                                        AND district.id=county.district_id
                                        AND county.id= subcounty.county_id
                                        AND subcounty.id = parish.subcounty_id
                                        AND parish.id = market.parish_id
                                        AND market.id = market_has_produce_category.market_id
                                        ");
        while($data = $sql->fetch_assoc()){
            $content[]= 'UG-'.$data['map_id'].'';
        }

        return $content;
    }

    //Map switch
    public static function prepMapSwitch(){

        $districts = self::activeDistrict($_SESSION['produce_category_active']);
        $content = 'switch(region.id){';
        foreach($districts as $district){

            $content .= "case '$district': ";
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

    public static function countSchoolsWithTypeId($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM market_has_produce_category
            WHERE produce_category_id = $id    
            ");

        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }


    public static function countSchoolsWithOwnershipID($id)
    {
        $sql = database::performQuery("
            SELECT *
            FROM market_has_produce_category
            WHERE produce_category_id=$id    
    
            ");

        return $sql->num_rows;
    }


    public static function countDistrictSchoolsWithOwnershipID($id)
    {
        $sql = database::performQuery("
           SELECT district.name,COUNT(*) as schools
            FROM district,market,county,subcounty,parish,market_has_produce_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND market.id = market_has_produce_category.market_id
            AND produce_category_id = $id
            GROUP BY district.name
            ");

        return $sql->num_rows;
    }


    //Region
    public static function Alldistricts(){

        $content ='
            <!-- Start Slider -->
	   <div class="row" data-auto-height="true">
           <div class="row">
                 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-3">
                                                                        <img src="'.ROOT.'/images/home/boys.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2>GOVERNMENT SCHOOLS</h2>
                                                                            <a class="mt-info" href="'.ROOT.'/find-a-market/ownership/2">Broswe over '.number_format(self::countSchoolsWithTypeId(2)).'+ government schools in Uganda on school guide.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p>&nbsp;</p>
                                                        <p>Government Schools in Uganda are schools funded by the Government. There are over '.number_format(self::countSchoolsWithTypeId(2)).'+ Government schools in Uganda on school guide and we bring you all of them here in over
                                                        '.self::countSchoolsWithOwnershipID(2).' Districts. Browse Government schools in Uganda <a href="'.ROOT.'/find-a-market/ownership/2"><button class="btn btn-xs green">Here</button></a></p>
                                                           </div>
                                                </div>
                                            </div>
    
                                       
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-3">
                                                                        <img src="'.ROOT.'/images/home/int.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2>PRIVATE SCHOOLS</h2>
                                                                            <a class="mt-info" href="'.ROOT.'/find-a-market/ownership/1">Broswe over '.number_format(self::countSchoolsWithTypeId(1)).'+ private schools in Uganda on school guide.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p>&nbsp;</p>
                                                        <p>Private Schools in Uganda are schools funded by Entreprenuers. There are over '.number_format(self::countSchoolsWithTypeId(1)).'+ Private schools in Uganda on school guide and we bring you all of them here in over
                                                        '.self::countSchoolsWithOwnershipID(1).' Districts. Browse Private schools in Uganda <a href="'.ROOT.'/find-a-market/ownership/1"><button class="btn btn-xs green">Here</button></a></p>
                                                           </div>
                                                </div>
                                            </div>
    
                                       
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-3">
                                                                        <img src="'.ROOT.'/images/home/pri.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2>COMMUNITY SCHOOLS</h2>
                                                                            <a class="mt-info" href="'.ROOT.'/find-a-market/ownership/3">Broswe over '.number_format(self::countSchoolsWithTypeId(3)).'+ community schools in Uganda on school guide.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p>&nbsp;</p>
                                                        <p>Community Schools in Uganda are schools funded by their respective communities. There are over '.number_format(self::countSchoolsWithTypeId(3)).'+ Community schools in Uganda on school guide and we bring you all of them here in over
                                                        '.self::countSchoolsWithOwnershipID(3).' Districts. BrowseCommunity schools in Uganda <a href="'.ROOT.'/find-a-market/ownership/3"><button class="btn btn-xs green">Here</button></a></p>
                                                           </div>
                                                </div>
                                            </div>
    
                                        </div>
      
      
       </div>
       <!-- End Slider -->
      
                        ';

        return $content;
    }


    //tabulate results in 3 columns district
    public static  function viewAllDistricts()
    {

        $content = '';
        $result = database::performQuery("SELECT district.name as name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            GROUP BY district.name
            ORDER BY name ASC");
        $i = 1;
        $content .='<div class="table-scrollable table-scrollable-borderless"> <table class="table table-hover table-light"><tr>';
        while ($row = $result->fetch_assoc()){
            $content .='<td><small> <i class="icon-check" style="color:#3598DC"></i> <a href="'.ROOT.'/find-a-market/district/' . strtolower($row['name']) . '">' . ucwords(strtolower($row['name'])) . ' District</a> ('.$row['schools'].') </small></td>';
            if ($i == 3) {
                $content .= '</tr><tr>';
                $i = 0;
            }
            $i++;
        }
        $content .='</tr></table></div>';

        return $content;
    }


    public static function getParentProduceId(){

        //TODO Finish this
        $sql  = database::performQuery("SELECT * FROM produce_category WHERE i");
    }

    //District Page
    public static function viewSchool() {
        $name = ucwords(strtolower(self::getProduceName($_REQUEST['id'])));
        //Check If District Exists
        $sql = database::performQuery("SELECT * FROM produce_category WHERE name LIKE '%$name%'");
        if($sql->num_rows == 0)
            notFound();
        else
        {
            $name = $name.' ';
            while ($data= $sql->fetch_assoc()) {
                $produce_category = $data;
            }
            $_SESSION['produce_category_active'] = $produce_category['id'];

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
                                                                <span class="caption-subject font-green bold uppercase">'.ucwords(strtolower($name)).' Markets in Uganda  </span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                             <p>'.ucwords(strtolower($name)).' are traded in Uganda.
                                                              There are over '.number_format(self::countSchoolsWithTypeId($produce_category['id'])).'+ '.$name.' markets in Uganda on
                                                              AMIS and we bring you all of them here in over
                                                        '.self::countDistrictSchoolsWithOwnershipID($produce_category['id']).' Districts in Uganda. 
                                                       </p>
                                                        </div>
                                                    </div>
                                                    <!-- END BLOCKQUOTES PORTLET-->
                                                </div>
                                                <div>
                                                    <!-- BEGIN GENERAL PORTLET-->
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <h2>'.$name.' Markets Monitor</h2>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    
    
                                                                <h3>Current Market Price</h3>
                                                                
                                                                
                                                               
                                                               
                                                               <div class="dashboard-stat2 ">
                                                    <div class="display">
                                                        <div class="number">
                                                            <h3 class="font-green-sharp">
                                                                <span data-counter="counterup" data-value="'.self::getLatestPrice($_SESSION['produce_category_active']).'">'.number_format(self::getLatestPrice($_SESSION['produce_category_active'])).'</span>
                                                                <small class="font-green-sharp">/=</small>
                                                            </h3>
                                                            <small>Market Price</small>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fa fa-money"></i>
                                                        </div>
                                                    </div>
                                                    <div class="progress-info">
                                                        <div class="progress">
                                                            <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                                                                <span class="sr-only">76% progress</span>
                                                            </span>
                                                        </div>
                                                        <div class="status">
                                                            <div class="status-title"> progress </div>
                                                            <div class="status-number"> 76% </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                               
                                                               
                                                                
                                                                <h3>Volumes Traded Today</h3>
                                                               
                                                                
                                                                
    
                                                                   <div class="dashboard-stat2 ">
                                                    <div class="display">
                                                        <div class="number">
                                                            <h3 class="font-red-haze">
                                                                <span data-counter="counterup" data-value="'.self::getLatestVolumes($_SESSION['produce_category_active']).'">'.number_format(self::getLatestVolumes($_SESSION['produce_category_active'])).'</span>
                                                            </h3>
                                                            <small>Volumes Traded</small>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fa fa-pie-chart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="progress-info">
                                                        <div class="progress">
                                                            <span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
                                                                <span class="sr-only">85% change</span>
                                                            </span>
                                                        </div>
                                                        <div class="status">
                                                            <div class="status-title"> change </div>
                                                            <div class="status-number"> 85% </div>
                                                        </div>
                                                    </div>
                                                </div>
     
    
    
    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="map"></div>
                                  
                                                                   <br />
                                                                   <a class="btn btn-xs dark" href="javascript:;"> &nbsp; &nbsp; </a>  <b> Districts with '.ucwords(strtolower($name)).' Markets</b>
                                    
    
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
                                                                <span class="caption-subject font-green bold uppercase">Market Monitor</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                                       <div class="row">
                                                                       <div class="col-md-6">
    
                                    
                                      
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Price Tracker </th>
                                                                       
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                 
                                                                 <tr>
                                                                 
                                                                 <td><div id="container" style="height:400px;"></div></div>

                                                                </td>
                                                                </tr>
                                                                 
                                                                 </tbody>
                                                            </table>
                                                        </div>
    
                                
                                    
                                    
                                                                </div>
                                                            <div class="col-md-6">
    
                                    
    
                                    
                                    
                                        
    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Produce Quantity Tracker</th>
                                                                        
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                
                                                                
                                                                
                                                               <tr>                                                                 
                                                                 <td>
                                                                     <div id="containerVolumes" style="height:400px;"></div></div>
                                                                 </td>
                                                               </tr>
                                                                 
                                                                
                                                                </tbody>
                                                            </table>
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
                                                                <span class="caption-subject font-red bold uppercase">'.$name.'  Markets by District</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">   
								
								
															<div class="row">
                                                                <div class="col-md-12">
                                                                
                                                                
                                                                '.self::prepAlldistricts($produce_category['id']).'
                                                                
                                                                
                                                                </div>
                                                             
                                                            </div>
								
								
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END WELLS PORTLET-->
                                                
                                                <!-- BEGIN WELLS PORTLET-->
                                                <div>
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="icon-social-dribbble font-red"></i>
                                                                <span class="caption-subject font-red bold uppercase">'.$name.'  Markets Alphabetically</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">   
								
								
															<div class="row">
                                                                <div class="col-md-12">
                                                                
                                                                
                                                                '.self::viewGenderByLetter($produce_category['id'],ucwords(strtolower($name))).'
                                                                
                                                                
                                                                </div>
                                                             
                                                            </div>
								
								
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END WELLS PORTLET-->
    
                                            </div>
                                            
                                           
                                            
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->';

            return $content;
        }


    }



    private static function viewDistrictSchoolsCategory($founding_body){

        $sql = database::performQuery("
            SELECT category.name,category.id,COUNT(*) as schools
            FROM district,market,county,subcounty,parish,produce_category,market_has_produce_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = category.id
            AND founding_body_id = $founding_body[id]
            AND parent = 0
            GROUP BY category.id
            ");

        $content = '';
        $colors = ['danger','success','info','warning'];
        while ($data = $sql->fetch_assoc())
        {

            $content .='<tr>
                               <td class="highlight"> <div class="'.$colors[rand(0,3)].'"></div> &nbsp; <b> '.ucwords(strtolower($data['name'])).' Schools</b> </td>
                                <td> '.$data['schools'].'</td>
                                <td>
                                  <a href="'.ROOT.'/?category='.$data['id'].'&founding_body='.$founding_body['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';

            //Child Categories

            $sqlc = database::performQuery("
            SELECT category.name,category.id,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,school_category,category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = category.id
            AND founding_body_id = $founding_body[id]
            AND parent = $data[id]
           GROUP BY category.id
            
            ");
            if($sqlc->num_rows > 0){
                while ($datac = $sqlc->fetch_assoc())
                {

                    $content .='<tr>
                                <td><small style="text-transform: capitalize;">'.ucwords(strtolower($datac['name'])).'</small></td>
                                <td> '.$datac['schools'].'</td>
                                <td>
                                <a href="'.ROOT.'/?category='.$datac['id'].'&founding_body='.$founding_body['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                            
                                </td>
                            </tr>';
                }
            }


        }



        return $content;
    }




    private static function viewDistrictFoundingBody($gender)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="success"></div> &nbsp; <b> Founding Body</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
            
            SELECT founding_body.id,founding_body.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,founding_body
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND founding_body.id = school.founding_body_id
            AND founding_body_id = $gender[id]
            GROUP BY founding_body.id
            ORDER BY founding_body.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?founding_body='.$gender['id'].'&founding_body='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    private static function viewDistrictGender($foundingbody)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Gender Type</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
    
            SELECT school_type.id,school_type.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,school_type,founding_body
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school_type.id = school.school_type_id
            AND founding_body.id = school.founding_body_id
            AND founding_body.id = $foundingbody[id]
            GROUP BY school_type.id
            ORDER BY school_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.$data['schools'].'</td>
                                <td>
                                  <a href="">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    //TODO Fix this
    public static function getLatestPrice($id){
       $price = 50000;
        $sql = database::performQuery("SELECT value FROM market_price WHERE produce_category_id=$id ORDER BY id DESC LIMIT 1");
       if($sql->num_rows>0) {
           $ret = $sql->fetch_assoc();
           $price = $ret['value'];
       }

       return $price;
    }



    //TODO Fix this
    public static function getLatestVolumes($id){
         $res = 20;
        $sql = database::performQuery("SELECT SUM(value) as total FROM market_volume WHERE produce_category_id=$id AND DATE(date) LIKE '2018-06-18'");
       if($sql->num_rows>0) {
           $ret = $sql->fetch_assoc();
           $res = $ret['total'];
       }
       return $res;
    }


    private static function viewDistrictOwnership($founding_body)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Ownership</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
    
            SELECT ownership.id,ownership.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,ownership,founding_body
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND ownership.id = school.ownership_id
            AND founding_body.id = school.founding_body_id
            AND founding_body_id = $founding_body[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?founding_body='.$founding_body['id'].'&ownership='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }

    private static function viewDistrictBoarding($founding_body)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Boarding Facilities</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
    
            SELECT boarding_type.id,boarding_type.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,boarding_type
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND boarding_type.id = school.boarding_type_id
            AND founding_body_id = $founding_body[id]
            GROUP BY boarding_type.id
            ORDER BY boarding_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?founding_body='.$founding_body['id'].'&boarding='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    private static function viewDistrictTotalSchool($district)
    {
        $content = '';

        $content .='<tr>
                               <td>  <b> Total Schools</b> </td>
                                <td colspan=2> <b>'.number_format(self::countDistrictSchoolsWithID($district['id'])).'</b></td>
                               
                            </tr>';
        return $content;


    }



    public static function countDistrictSchoolsWithCategory($id,$cid)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM district,school,county,subcounty,parish,school_category,category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = category.id
            AND founding_body_id = $id
            AND category_id = $cid
    
            ");

        while ($data = $sql->fetch_assoc())
            return number_format($data['schools']);
    }




    public static function countDistrictSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM school
            WHERE founding_body_id = $id    
            ");

        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }



    public static function viewDistrictSubcountySchoolsWithID($id)
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
            ORDER BY district.id ASC,county.id ASC, subcounty.id ASC
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
                                  <a href="'.ROOT.'/find-a-market/subcounty/'.strtolower($data['district']).'/'.makeSeo($data['name']).'/'.$data['id'].'">  <span class="label label-sm label-warning"> View List</span></a>
                                </td>
                            </tr>';
            $old = $new;
        }



        return $content;
    }



    public static function viewDistrictSubregionSchoolsWithID($id,$sid)
    {
        $sql = database::performQuery("
            SELECT district.id,district.name, COUNT(*) as schools
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND district.id != $id
            AND district.sub_region_id = $sid
            GROUP BY district.id
            ORDER BY district.id ASC
            ");
        $content  ="";
        while ($data = $sql->fetch_assoc())
        {
            $content .='<tr><td> '.ucwords(strtolower($data['name'])).' District</td>
                                <td><small> '.$data['schools'].'</small></td>
                                <td>
                                  <a href="'.ROOT.'/find-a-market/district/'.strtolower($data['name']).'">  <span class="label label-sm label-info"> View List</span></a>
                                </td>
                            </tr>';

        }



        return $content;
    }



    //Region
    public static function prepAlldistricts($id){

        $content ='

        <div class="col-md-12 col-sm-12 about-links">
        <div class="row">
        
                    '.self::viewAllDistrictsInfo($id).'
        
                        </div>
        
                        </div>
                      
         
                        ';

        return $content;
    }



    //Region
    public static function schoolsByLetter($id,$letter){

        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM market,market_has_produce_category
            WHERE market.id = market_has_produce_category.market_id
            AND produce_category_id = $id  
              AND name LIKE '$letter%'
            ");

        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }


    //tabulate results in 3 columns district
    public static  function viewAllDistrictsInfo($id)
    {

        $content = '';
        $result = database::performQuery("SELECT district.name as name,district.id,COUNT(*) as schools
            FROM district,market,county,subcounty,parish,market_has_produce_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND market.id  = market_has_produce_category.market_id
            AND produce_category_id = $id
            GROUP BY district.name
            ORDER BY name ASC");
        $i = 1;
        $content .='<div class="table-scrollable table-scrollable-borderless"> <table class="table table-hover table-light"><tr>';
        while ($row = $result->fetch_assoc()){
            $content .='<td><small> <i class="icon-check" style="color:#3598DC"></i> <a href="'.ROOT.'/?founding_body='.$id.'&district='.$row['id'].'&action=search">' . ucwords(strtolower($row['name'])) . ' District</a> ('.$row['schools'].') </small></td>';
            if ($i == 4) {
                $content .= '</tr><tr>';
                $i = 0;
            }
            $i++;
        }
        $content .='</tr></table></div>';

        return $content;
    }






    //Region
    public static function viewGenderByLetter($gender,$name){

        $content ='';

        foreach (letters() as $letter)
        {
            if(self::schoolsByLetter($gender,$letter) == 0)
                $content .= '';
            else
                $content .='<a href="'.ROOT.'/?founding_body='.$gender.'&letter='.$letter.'&action=search"><button class="btn yellow-gold btn-xs tooltips" data-container="body" data-placement="top" data-original-title="'.self::schoolsByLetter($gender,$letter).' '.$name.'  Markets">'.$letter.'</button> </a>&nbsp;';
        }

        return $content;
    }
}



