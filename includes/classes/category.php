<?php

/**
 * Created by PhpStorm.
 * User: Herbert
 * Date: 19/11/2016
 * Time: 17:33
 */


class category
{



    //Return IDs for District with active Subregions
    public static function activeDistrict($id)
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id 
                                        FROM district,county,subcounty,parish,school
                                        WHERE school_type_id=$id
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


    //get Category Details
    public static function getCategoryDetails($id){
        $sql = database::performQuery("SELECT * FROM category WHERE id =$id ");
        return $sql->fetch_assoc()['name'];
    }
    //Map switch
    public static function prepMapSwitch(){

        $districts = self::activeDistrict($_SESSION['gender_active']);
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

    public static function countSchoolsWithCategoryId($id)
    {
        $sql = database::performQuery("
            SELECT *
            FROM school_category
            WHERE category_id = $id    
            ");
       return $sql->num_rows;
    }


   //All Districts COntent
    public static function countSchoolsWithCategoryIdContent()
    {
        $sql = database::performQuery("
            SELECT category.name as category,COUNT(*) as total,pic
            FROM school,category,school_category
            WHERE school.id = school_category.school_id
            AND category.id = school_category.category_id
            AND category.parent = 0
            GROUP BY category_id  
            ORDER BY category.id ASC
            ");
        $content = '';
        while($data=$sql->fetch_assoc())
        {
            $content .='
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-3">
                                                                        <img src="'.ROOT.'/images/home/'.$data['pic'].'">
                                                                        <div class="mt-overlay">
                                                                            <h2>'.$data['category'].' SCHOOLS</h2>
                                                                            <a class="mt-info" href="#">Browse '.$data['total'].'+ Schools</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            ';
        }
        return $content;
    }


    //All Districts COntent
    public static function countSchoolsWithCategoryIdContentHome()
    {
        $sql = database::performQuery("
            SELECT produce_category.name as category,COUNT(*) as total,pic,produce_category.id
            FROM market,produce_category,market_has_produce_category
            WHERE market.id = market_has_produce_category.market_id
            AND produce_category.id = market_has_produce_category.produce_category_id
            AND produce_category.parent BETWEEN 2 AND 11
            GROUP BY produce_category_id  
            ORDER BY produce_category.id ASC
            LIMIT 8
            ");
        $content = '';
        while($data=$sql->fetch_assoc())
        {
            $content .='
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-3">
                                                                        <img src="'.ROOT.'/images/home/'.$data['pic'].'">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">'.$data['category'].' SCHOOLS -  ('.number_format($data['total']).')</h2>
                                                                            <a class="mt-info" href="'.ROOT.'/find-a-market/category/'.$data['id'].'">Browse '.$data['total'].'+ Schools</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            ';
        }
        return $content;
    }




    public static function countDistrictSchoolsWithCategoryId($id)
            {
        $sql = database::performQuery("
            SELECT district.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,school_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id=$id
            GROUP BY district.name
    
            ");

        return $sql->num_rows;
    }


    //Region
    public static function Alldistricts(){

        $content ='
    
             <div class="row" data-auto-height="true">
                  <div class="row">
                        
          
                   '.self::countSchoolsWithCategoryIdContent().'


                  </div>
             </div>';

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
        $id = ucwords(strtolower($_REQUEST['id']));
        //Check If District Exists
        $sql = database::performQuery("SELECT * FROM category WHERE id ='$id'");
        if($sql->num_rows == 0)
            notFound();
        else
        {
            while ($data= $sql->fetch_assoc()) {
                $category = $data;
                $name = $data['name'];
                $parent = '';
                if($data['parent'] != 0)
                    $parent = self::checkParentCategory($data['parent']);
            }
            $_SESSION['category_active'] = $category['id'];

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
                                                                <span class="caption-subject font-green bold uppercase">'.ucwords(strtolower($category['name'])).' Schools in Uganda  </span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                             <p>'.ucwords(strtolower($name)).' Schools are a category of '.ucwords(strtolower($parent)).' Schools in Uganda.
                                                              There are over '.number_format(self::countSchoolsWithCategoryId($category['id'])).'
                                                               '.ucwords(strtolower($name)).' schools in Uganda on
                                                               school guide and we bring you all of them here in 
                                                        '.self::countDistrictSchoolsWithCategoryId($category['id']).' Districts. 
                                                       </p>
                                                        </div>
                                                    </div>
                                                    <!-- END BLOCKQUOTES PORTLET-->
                                                </div>
                                               
                                                <div>
                                                    <!-- BEGIN BLOCKQUOTES PORTLET-->
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="icon-social-dribbble font-green"></i>
                                                                <span class="caption-subject font-green bold uppercase">'.ucwords(strtolower($name)).' Schools by Type</span>
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
            $content .=  self::viewCategoryOwnership($category);
            $content .= self::viewCategoryBoarding($category);
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
            $content .=  self::viewDistrictFoundingBody($category);
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
                                                                
                                                                
                                                                '.self::prepAlldistricts($category['id']).'
                                                                
                                                                
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
                                                                
                                                                
                                                                '.self::viewGenderByLetter($category['id'],ucwords(strtolower($category['name']))).'
                                                                
                                                                
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


    private static function viewDistrictFoundingBody($category)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="success"></div> &nbsp; <b> Founding Body</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
            
            SELECT founding_body.id,founding_body.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,founding_body,school_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND founding_body.id = school.founding_body_id
            AND school.id = school_category.school_id
            AND school_category.category_id = $category[id]
            GROUP BY founding_body.id
            ORDER BY founding_body.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.$data['schools'].'</td>
                                <td>
                                  <a href="'.ROOT.'/?category='.$category['id'].'&founding_body='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
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
    
            SELECT school_type.id,school_type.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,school_type
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school_type.id = school.school_type_id
            AND district.id = $district[id]
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
    private static function viewCategoryOwnership($category)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Ownership</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
    
            SELECT ownership.id,ownership.name,COUNT(*) as schools
            FROM district,county,subcounty,parish,ownership,school,school_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND ownership.id = school.ownership_id
            AND school.id = school_category.school_id
            AND school_category.category_id = $category[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.$data['schools'].'</td>
                                <td>
                                  <a href="'.ROOT.'/?category='.$category['id'].'&ownership='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }

    private static function viewCategoryBoarding($category)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Boarding Facilities</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql= database::performQuery("
    
            SELECT boarding_type.id,boarding_type.name,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,boarding_type,school_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND boarding_type.id = school.boarding_type_id
            AND school.id = school_category.school_id
            AND school_category.category_id = $category[id]
            GROUP BY boarding_type.id
            ORDER BY boarding_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.$data['schools'].'</td>
                                <td>
                                  <a href="'.ROOT.'/?category='.$category['id'].'&boarding='.$data['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


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
            AND school_type_id = $id
            AND category_id = $cid
    
            ");

        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }




    public static function countDistrictSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM school
            WHERE school_type_id = $id    
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
            FROM school,school_category
            WHERE school.id = school_category.school_id
            AND school_category.category_id = $id
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
            FROM district,school,county,subcounty,parish,school_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = $id
            GROUP BY district.name
            ORDER BY name ASC");
        $i = 1;
        $content .='<div class="table-scrollable table-scrollable-borderless"> <table class="table table-hover table-light"><tr>';
        while ($row = $result->fetch_assoc()){
            $content .='<td><small> <i class="icon-check" style="color:#3598DC"></i> <a href="'.ROOT.'/?category='.$id.'&district='.$row['id'].'&action=search">' . ucwords(strtolower($row['name'])) . ' District</a> ('.$row['schools'].') </small></td>';
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
    public static function viewGenderByLetter($category, $name){

        $content ='';

        foreach (letters() as $letter)
        {
            if(self::schoolsByLetter($category,$letter) == 0)
                $content .= '';
            else
                $content .='<a href="'.ROOT.'/?category='.$category.'&letter='.$letter.'&action=search"><button class="btn yellow-gold btn-xs tooltips" data-container="body" data-placement="top" data-original-title="'.self::schoolsByLetter($category,$letter).' '.$name.'  Schools">'.$letter.'</button> </a>&nbsp;';
        }

        return $content;
    }



    public static function checkParentCategory($id){
        $sql = database::performQuery("SELECT * FROM category WHERE id LIKE '$id'");
        $ret = $sql->fetch_assoc();
        return $ret['name'];
    }
}



