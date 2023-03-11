<?php

/**
 * Created by PhpStorm.
 * User: Herbert
 * Date: 19/11/2016
 * Time: 17:33
 */


class ownership
{


    //Get Ownership Name
    public static function getOwnershipName($id){
        $sql = database::performQuery("SELECT name FROM ownership WHERE id=$id");
        $ret = $sql->fetch_assoc();
        return $ret['name'];
    }

    //Return IDs for District with active Subregions
    public static function activeDistrict($id)
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id 
                                        FROM district,county,subcounty,parish,school
                                        WHERE ownership_id=$id
                                        AND district.id=county.district_id
                                        AND county.id= subcounty.county_id
                                        AND subcounty.id = parish.subcounty_id
                                        AND parish.id = school.parish_id
                                        ");
        while($data = $sql->fetch_assoc()){
            $content[]= 'UG-'.$data['map_id'].'';
        }

        return $content;
    }

    //Map switch
    public static function prepMapSwitch(){

        $districts = self::activeDistrict($_SESSION['gender_active']);
        $content = 'switch(region.id){';
        foreach($districts as $district){

            $content .= "case '$district': ";
        }
        $content .= '
        region.setFill(\'#878787\');
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
            FROM school
            WHERE ownership_id = $id    
            ");

        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }


    public static function countSchoolsWithOwnershipID($id)
    {
        $sql = database::performQuery("
            SELECT *
            FROM school
            WHERE ownership_id=$id    
    
            ");

        return $sql->num_rows;
    }


    public static function countDistrictSchoolsWithOwnershipID($id)
    {
        $sql = database::performQuery("
            SELECT district.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,ownership
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND ownership.id = school.ownership_id
            AND ownership.id=$id
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


    //District Page
    public static function viewSchool() {
        $name = ucwords(strtolower(self::getOwnershipName($_REQUEST['id'])));
        //Check If District Exists
        $sql = database::performQuery("SELECT * FROM ownership WHERE name LIKE '%$name%'");
        if($sql->num_rows == 0)
            notFound();
        else
        {
            while ($data= $sql->fetch_assoc()) {
                $ownership = $data;
            }
            $_SESSION['ownership_active'] = $ownership['id'];

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
                                                                <span class="caption-subject font-green bold uppercase">'.ucwords(strtolower($ownership['name'])).' Schools in Uganda  </span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                             <p>'.ucwords(strtolower($ownership['name'])).' Schools in Uganda are schools funded exclusively by '.$name.'.
                                                              There are over '.number_format(self::countSchoolsWithTypeId($ownership['id'])).'+ '.$name.' schools in Uganda on
                                                               school guide and we bring you all of them here in over
                                                        '.self::countDistrictSchoolsWithOwnershipID($ownership['id']).' Districts in Uganda. 
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
                                                                <i class="icon-social-dribbble font-blue-sharp"></i>
                                                                <span class="caption-subject font-blue-sharp bold uppercase">'.$name.'  School Statistics</span>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h3>'.$name.' Schools by  Category</h3>
    
    
    
    
    
    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Category </th>
                                                                        <th> Schools </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
           $content .=  self::viewDistrictSchoolsCategory($ownership);
            $content .=  self::viewDistrictTotalSchool($ownership);
            $content .=' </tbody>
                                                            </table>
                                                        </div>
    
    
    
    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="map"></div>
                                  
                                                                   <br />
                                                                   <a class="btn btn-xs dark" href="javascript:;"> &nbsp; &nbsp; </a>  <b> Districts with '.ucwords(strtolower($name)).' Schools</b>
                                    
    
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
                                                                <span class="caption-subject font-green bold uppercase">School Types</span>
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
                                                                        <th> Schools </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
            $content .=  self::viewDistrictOwnership($ownership);
            $content .= self::viewDistrictBoarding($ownership);
            $content .=' </tbody>
                                                            </table>
                                                        </div>
    
                                
                                    
                                    
                                                                </div>
                                                            <div class="col-md-6">
    
                                    
    
                                    
                                    
                                        
    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Types</th>
                                                                        <th> Schools </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
            $content .=  self::viewDistrictFoundingBody($ownership);
            $content .=' </tbody>
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
                                                                <span class="caption-subject font-red bold uppercase">'.$name.'  Schools by District</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">   
								
								
															<div class="row">
                                                                <div class="col-md-12">
                                                                
                                                                
                                                                '.self::prepAlldistricts($ownership['id']).'
                                                                
                                                                
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
                                                                <span class="caption-subject font-red bold uppercase">'.$name.'  Schools Alphabetically</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">   
								
								
															<div class="row">
                                                                <div class="col-md-12">
                                                                
                                                                
                                                                '.self::viewGenderByLetter($ownership['id'],ucwords(strtolower($ownership['name']))).'
                                                                
                                                                
                                                                </div>
                                                             
                                                            </div>
								
								
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END WELLS PORTLET-->
    
                                            </div>
                                            
                                            '.ad::viewSidebar(ad::ad240_pri(),ad::ad240_208()).'
                                            
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->';

            return $content;
        }


    }




    private static function viewDistrictSchoolsCategory($ownership){

        $sql = database::performQuery("
            SELECT category.name,category.id,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,school_category,category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = category.id
            AND ownership_id = $ownership[id]
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
                                  <a href="'.ROOT.'/?category='.$data['id'].'&ownership='.$ownership['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
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
            AND ownership_id = $ownership[id]
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
                                <a href="'.ROOT.'/?category='.$datac['id'].'&ownership='.$ownership['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                            
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
            AND ownership_id = $gender[id]
            GROUP BY founding_body.id
            ORDER BY founding_body.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?ownership='.$gender['id'].'&founding_body='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    private static function viewDistrictGender($district)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Gender Type</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
    
            SELECT ownership.id,ownership.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,ownership
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND ownership.id = school.ownership_id
            AND district.id = $district[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
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
    private static function viewDistrictOwnership($gender)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Ownership</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
    
            SELECT ownership.id,ownership.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,ownership
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND ownership.id = school.ownership_id
            AND ownership_id = $gender[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?ownership='.$gender['id'].'&ownership='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }

    private static function viewDistrictBoarding($gender)
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
            AND ownership_id = $gender[id]
            GROUP BY boarding_type.id
            ORDER BY boarding_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?ownership='.$gender['id'].'&boarding='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
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
            AND ownership_id = $id
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
            WHERE ownership_id = $id    
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
            FROM school
            WHERE ownership_id = $id  
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
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND ownership_id = $id
            GROUP BY district.name
            ORDER BY name ASC");
        $i = 1;
        $content .='<div class="table-scrollable table-scrollable-borderless"> <table class="table table-hover table-light"><tr>';
        while ($row = $result->fetch_assoc()){
            $content .='<td><small> <i class="icon-check" style="color:#3598DC"></i> <a href="'.ROOT.'/?ownership='.$id.'&district='.$row['id'].'&action=search">' . ucwords(strtolower($row['name'])) . ' District</a> ('.$row['schools'].') </small></td>';
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
                $content .='<a href="'.ROOT.'/?ownership='.$gender.'&letter='.$letter.'&action=search"><button class="btn yellow-gold btn-xs tooltips" data-container="body" data-placement="top" data-original-title="'.self::schoolsByLetter($gender,$letter).' '.$name.'  Schools">'.$letter.'</button> </a>&nbsp;';
        }

        return $content;
    }
}



