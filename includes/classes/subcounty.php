<?php

class subcounty
{

    public static function getSubCounty($id){

        $sql = database::performQuery("SELECT subcounty.name as subcounty, district.name as district , county.name as county
                                                 FROM subcounty,county,district 
                                                 WHERE subcounty.id=$id
                                                 AND district.id = county.district_id
                                                 AND county.id =subcounty.county_id
                                                  ");

        return $data = $sql->fetch_assoc();

    }


    public static function getSubcountyName($id){

        $sql = database::performQuery("SELECT name FROM subcounty WHERE id=$id");
        $ret = $sql->fetch_assoc();

        return $ret['name'];
    }

    //District Page
    public static function viewSubcounty() {
        $id = ucwords(strtolower($_REQUEST['id']));
        //Check If District Exists
        $sql = database::performQuery("SELECT * FROM subcounty WHERE id LIKE '$id'");
        if($sql->num_rows == 0)
             notFound(); 
            else
            {
                while ($data= $sql->fetch_assoc()) {
                    $subcounty = $data;
                }
                 
                $subcounty_info = self::subcountyDescription($subcounty['id']);
                $name = ucwords(strtolower($subcounty['name']));
                 
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
                                                                <span class="caption-subject font-green bold uppercase">'.$name.' Subcounty </span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                            '.ucwords($name).' Subcounty is found in  '.ucwords(strtolower($subcounty_info['district'])).' District in the '.ucwords(strtolower($subcounty_info['sub_region'])).'
                                                                Sub-Region of '.$subcounty_info['region'].' Uganda.  The Subcounty has '.self::countParishes($subcounty['id']).' Parishes and '.self::countVillages($subcounty['id']).' villages.
                                                                    The Subcounty has over '.self::countSubcountySchoolsWithID($subcounty['id']).' schools currently with
                                                                        '.self::subcountyDescription2($subcounty['id']).'.
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
                                                                <span class="caption-subject font-blue-sharp bold uppercase">'.$name.' Subcounty School Statistics</span>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h3>Schools by  Category</h3>
    
    
    
    
    
    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Category </th>
                                                                        <th> Markets </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewDistrictSchoolsCategory($subcounty);
                $content .=  self::viewDistrictTotalSchool($subcounty);
                $content .=' </tbody>
                                                            </table>
                                                        </div>
    
    
    
    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="map"></div>
                                  
                                                                   <br />
                                                                   <a class="btn btn-xs dark" href="javascript:;"> &nbsp; &nbsp; </a>  <b> '. $subcounty_info['district'].' District</b>
                                    
                                    
                                                                   <h3> '.ucwords(strtolower( $subcounty_info['district'])).' District  Links</h3>
																	<ul>
                                                                   <li><a target="_blank" href="http://'.strtolower( $subcounty_info['district']).'.go.ug">Official District Page</a></li>
                                                                   <li><a target="_blank" href="https://en.wikipedia.org/'. $subcounty_info['district'].'_District">Official District Wikipedia Page</a></li>
                                                                   </ul>
                                    
    
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
                                                                        <th> Markets </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewDistrictGender($subcounty);
                $content .=  self::viewDistrictOwnership($subcounty);
                $content .= self::viewDistrictBoarding($subcounty);
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
                                                                        <th> Markets </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewDistrictFoundingBody($subcounty);
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
                                                                <span class="caption-subject font-red bold uppercase">Parishes and Other '.$subcounty_info['district'].' District Subcounties</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
    
								
								
															<div class="row">
                                                                <div class="col-md-6">
                                                                    <h3>'.$name.' Parishes Schools</h3>
                                      
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Parish </th>
                                                                        <th> Markets </th>
                                                                        <th>  </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewSubcountyParishSchoolsWithID($subcounty['id']);
    
                $content .=' </tbody>
                                                            </table>
                                                        </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h3>Subcountys In '.ucwords(strtolower($subcounty_info['district'])).' District</h3>
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
                $content .=  district::viewDistrictSubcountySchoolsWithID($subcounty_info['district_id']);
    
                $content .=' </tbody>
                                                            </table>
                                                        </div>
                                  
    
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
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->';
                 
                return $content;
            }
             
    
    }



    private static function viewDistrictSchoolsCategory($subcounty){

        $sql = database::performQuery("
            SELECT category.name,category.id,COUNT(*) as schools
            FROM district,school,county,subcounty,parish,school_category,category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = category.id
            AND subcounty.id = $subcounty[id]
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
                                  <a href="'.ROOT.'/?category='.$data['id'].'&subcounty='.$subcounty['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
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
            AND subcounty.id = $subcounty[id]
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
                                <a href="'.ROOT.'/?category='.$datac['id'].'&subcounty='.$subcounty['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                            
                                </td>
                            </tr>';
                }
            }


        }



        return $content;
    }



    private static function viewDistrictFoundingBody($subcounty)
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
            AND subcounty.id = $subcounty[id]
            GROUP BY founding_body.id
            ORDER BY founding_body.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?founding_body='.$data['id'].'&subcounty='.$subcounty['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }
        
         
        return $content;
    }
    

private static function viewDistrictGender($subcounty)
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
            AND subcounty.id = $subcounty[id]
            GROUP BY school_type.id
            ORDER BY school_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?gender='.$data['id'].'&subcounty='.$subcounty['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    private static function viewDistrictOwnership($subcounty)
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
            AND subcounty.id = $subcounty[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?ownership='.$data['id'].'&subcounty='.$subcounty['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    
    private static function viewDistrictBoarding($subcounty)
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
            AND subcounty.id = $subcounty[id]
            GROUP BY boarding_type.id
            ORDER BY boarding_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?boarding='.$data['id'].'&subcounty='.$subcounty['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    
    

    private static function viewDistrictTotalSchool($subcounty)
    {
        $content = '';
        
            $content .='<tr>
                               <td>  <b> Total Schools</b> </td>
                                <td colspan=2> <b>'.self::countSubcountySchoolsWithID($subcounty['id']).'</b></td>
                               
                            </tr>';
       return $content;
         
        
    }

    public static function subcountyDescription($id) {
      $sql = database::performQuery("SELECT subcounty.id as id,
          subcounty.name as name,district.name as district,district.id as district_id, region.name as region,sub_region.name as sub_region,
          sub_region.id as sub_region_id FROM region,sub_region,district,county,subcounty
          WHERE 
          region.id =district.region_id 
          AND sub_region.id =district.sub_region_id 
          AND district.id = county.district_id
          AND county.id = subcounty.county_id
          AND subcounty.id=$id")  ;
       while ($data=$sql->fetch_assoc()) {
          return $data;
       }
    
    }
    
    
    //Returjn parent categories with their school total in the district
    public static function subcountyDescription2($id) {
        $sql = database::performQuery("
            
            SELECT category.id,category.name as name,COUNT(*) as total
            FROM district,school,county,subcounty,parish,category,school_category
            WHERE district.id=county.district_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = school.parish_id
				AND category.id = school_category.category_id
				AND school.id = school_category.school_id
				AND subcounty.id = $id
				AND category.parent = 0 
				GROUP BY category.id
            
            ")  ;
        $content = [];
        while ($data=$sql->fetch_assoc()) {
            $content[]= $data['total'].' '.ucwords(strtolower($data['name'])).' Schools';
        }
        
        return implode(', ',$content);
    
    }
    
    
    
    
    //Error 404 Not found
    
    
//     //count subcounties
//     public static function countSubcounties($id) {
//         $sql = database::performQuery("
//             SELECT COUNT(*) as total
//             FROM district,county,subcounty
//             WHERE district.id=county.district_id
//                 AND county.id= subcounty.county_id
//                 AND subcounty.id = $id
//                 GROUP BY district.id,county.id,subcounty.id
//             ");
//         return $sql->num_rows;
//     }
    

    //count parishes
    public static function countParishes($id) {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM district,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND subcounty.id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id
            ");
        return $sql->num_rows;
    }
    

    //count villages
    public static function countVillages($id) {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM district,county,subcounty,parish,village
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = village.parish_id
            AND subcounty.id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id,village.id
            ");
        return $sql->num_rows;
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
            AND subcounty.id = $id
            AND category_id = $cid
    
            ");
    
        while ($data = $sql->fetch_assoc())
            return $data['schools'];
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
    
             
            $content .='<li> <small style="font-size:10px"> <i class="icon-check" style="color:'.$color.'"></i> <a href="'.ROOT.'/find-a-market/district/'.ucwords(strtolower($data['name'])).'">'.ucwords(strtolower($data['name'])).' </a></small></li>';
             
        }
        return $content;
    
    }
    

    public static function countSubcountySchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND subcounty.id = $id
    
            ");
    
        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }


    public static function viewParishInfo($id)
    {
        $sql = database::performQuery(" SELECT county.name as county,
 district.name as district,subcounty.name as subcounty,
 parish.id as id,parish.name as name
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND parish.id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id
            ORDER BY district.id ASC,county.id ASC, subcounty.id ASC,parish.id ASC");
        $ret = $sql->fetch_assoc();

        return $ret;

    }
    
    public static function viewSubcountyParishSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT county.name as county,district.name as district,subcounty.name as subcounty,parish.id as id,parish.name as name, COUNT(*) as schools
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND subcounty.id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id
            ORDER BY district.id ASC,county.id ASC, subcounty.id ASC,parish.id ASC
            ");
        $content  ="";
        $new = '';
        $old = '';
        $colors = ['info','success','danger','warning'];
        while ($data = $sql->fetch_assoc())
        {
    
           
                    $content .='';
                    $content .=' <td><small> '.$data['name'].'</small></td>
                                <td><small> '.$data['schools'].'</small></td>
                                <td>
                                   
                                  <a href="'.ROOT.'/?parish='.$data['id'].'&action=search">  <span class="label label-sm label-success">View List</span></a>
                                </td>
                            </tr>';
        }

    
        return $content;
    }
     
    
    
    
    
}



?>