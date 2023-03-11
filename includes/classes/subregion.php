<?php

class subregion
{
    //Return IDs for District with active Subregions
    public static function activeSubregion($id)
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id FROM district WHERE sub_region_id=$id");
        while($data = $sql->fetch_assoc()){
           $content[]= 'UG-'.$data['map_id'].'';
        }

     return $content;
    }
    //Return IDs for District with active Subregions
    public static function inActiveSubregion($id)
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id FROM district WHERE sub_region_id!=$id");
        while($data = $sql->fetch_assoc()){
            $content[]= 'UG-'.$data['map_id'].'';
        }

        return implode(',',$content);
    }


    //Region
    public static function Allsubregions(){
        
        $content ='<div class="row about-links-cont" data-auto-height="true">
                                            <div class="col-md-6 about-links">
                                                <div class="row">
                                                    <div class="col-sm-6 about-links-item">
                                                    <a href="'.ROOT.'/find-a-market/region/central">    <h4><button class=" btn btn-xs btn-circle purple-seance"/>Central Region Schools</h4> </a>
                                                        <ul>
                                                            '.self::regionBio('Central')['brief'].' The region has over '.self::regionBio('Central')['schools'].' schools. Find more about this region <a href="'.ROOT.'/find-a-market/region/central"> here</a>.
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm-6 about-links-item">
                                                     <a href="'.ROOT.'/find-a-market/region/western">    <h4><button class="btn btn-xs btn-circle blue"/>Western Region Schools</h4> </a>
                                                        <ul>
                                                            '.self::regionBio('Western')['brief'].' The region has over '.self::regionBio('Western')['schools'].' schools. Find more about this region <a href="'.ROOT.'/find-a-market/region/western"> here</a>.
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 about-links-item">
                                                     <a href="'.ROOT.'/find-a-market/region/eastern">    <h4><button class="btn btn-xs btn-circle yellow-crusta"/>Eastern Region Schools</h4> </a>
                                                        <ul>
                                                           '.self::regionBio('Eastern')['brief'].' The region has over '.self::regionBio('Eastern')['schools'].' schools. 
                                                               Find more about this region <a href="'.ROOT.'/find-a-market/region/eastern"> here</a>.
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm-6 about-links-item">
                                                    <a href="'.ROOT.'/find-a-market/region/northern">     <h4><button class="btn btn-xs  btn-circle green-jungle"/>Northern Region Schools</h4> </a>
                                                        <ul>
                                                            '.self::regionBio('Northern')['brief'].' The region has over '.self::regionBio('Northern')['schools'].' schools. Find more about this region <a href="'.ROOT.'/find-a-market/region/northern"> here</a>.
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

    //Map switch
   public static function prepMapSwitch(){

       $subregions = self::activeSubregion($_SESSION['sub_region_active']);
       $content = 'switch(region.id){';
       foreach($subregions as $subregion){

           $content .= "case '$subregion': ";
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
    
    //District Page
    public static function viewSubegion() {
        $name = ucwords(strtolower($_REQUEST['name']));
        //Check If District Exists
        $sql = database::performQuery("SELECT * FROM sub_region WHERE name LIKE '$name'");
        if($sql->num_rows == 0)
             notFound();         
          else
            {
                while ($data= $sql->fetch_assoc()) {
                    $region = $data;
                }
                $_SESSION['sub_region_active'] = $region['id'];
                  
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
                                                                <span class="caption-subject font-green bold uppercase">'.$name.' Sub Region </span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                            '.ucwords($name).'  Sub Region is one of the thirteen recognized administrative sub regions found in Uganda. 
                                                                The sub region has over
                                                                '.number_format(self::countDistrict($region['id'])).' Districts,
                                                                    '.number_format(self::countCounties($region['id'])).' Counties,
                                                                     '.number_format(self::countSubcounties($region['id'])).' sub counties,
                                                                        '.number_format(self::countParishes($region['id'])).' Parishes and 
                                                                             '.number_format(self::countVillages($region['id'])).' Villages.
                                                                   
                                                                        
                                                                        The sub region has over '.number_format(self::countSubRegionSchoolsWithID($region['id'])).' markets with
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
                                                                <span class="caption-subject font-blue-sharp bold uppercase">'.$name.' Sub Region Market Statistics</span>
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
                                                                        <th> Markets</th>
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
                                                                        <th> Markets </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
               $content .=  self::viewRegionGender($region);
//                $content .=  self::viewRegionOwnership($region);
//                $content .= self::viewRegionBoarding($region);
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
                                                                <span class="caption-subject font-red bold uppercase">Districts In '.ucwords(strtolower($region['name'])).' Sub Region</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
    
								
								
															<div class="row">
                                                                <div class="col-md-6">
                                                                   <h3>Sub Region Districts</h3>
                                                                            <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> District </th>
                                                                        <th> Schools </th>
                                                                        <th>  </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                $content .=  self::viewRegionDistrictSchoolsWithID($region['id']);
    
                $content .=' </tbody>           </table>
                                                        </div>                                                                        
                                                        
                                                                </div>
                    
                    
                     <div class="col-md-6">
                    <h3>Other Sub Regions</h3>
                                                                   
                                                                            <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Region </th>
                                                                        <th> Schools </th>
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


    private static function viewRegionSchoolsCategory($sub_region){

        $sql = database::performQuery("
             SELECT * FROM market_category WHERE parent_id = 0
            ");

        $content = '';
        $colors = ['danger','success','info','warning'];
        while ($data = $sql->fetch_assoc())
        {

            $content .='<tr>
                               <td class="highlight"> <div class="'.$colors[rand(0,3)].'"></div> &nbsp; <b> '.ucwords(strtolower($data['name'])).' Market</b> </td>
                                <td> '.$data['schools'].'</td>
                                <td>
                               &nbsp;
                               </td>
                            </tr>';

            //Child Categories

            $sqlc = database::performQuery("
     SELECT market_category.name,market_category.id,COUNT(*) as schools
            FROM sub_region,district,market,county,subcounty,parish,market_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND sub_region.id = district.sub_region_id            
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND market.market_category_id = market_category.id
             AND sub_region.id = $sub_region[id]
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
                                <a href="'.ROOT.'/?category='.$datac['id'].'&subregion='.$sub_region['id'].'&action=search">  <span class="label label-sm label-success"> View List</span></a>
                            
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
            FROM sub_region,district,market,county,subcounty,parish,founding_body
            WHERE district.id=county.district_id
            AND sub_region.id = district.sub_region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND founding_body.id = school.founding_body_id
            AND sub_region_id = $region[id]
            GROUP BY founding_body.id
            ORDER BY founding_body.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?founding_body='.$data['id'].'&subregion='.$region['id'].'&action=search">  <span class="label label-sm label-success"> View</span></a>
                                </td>
                            </tr>';
        }
        
         
        return $content;
    }
    

private static function viewRegionGender($region)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Gender Type</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';
    
        $sql= database::performQuery("
    
            
            SELECT dmp_category.id,dmp_category.name,COUNT(*) as schools
            FROM sub_region,district,dmp,county,subcounty,parish,dmp_category
            WHERE district.id=county.district_id
            AND sub_region.id = district.sub_region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = dmp.parish_id
            AND dmp.dmp_category_id = dmp_category.id
            AND sub_region.id = $region[id]
            GROUP BY dmp_category.id
            
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?category='.$data['id'].'&subregion='.$region['id'].'&action=searchDMP">  <span class="label label-sm label-success"> View</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    private static function viewRegionOwnership($sub_region)
    {
        $content = '';
        $content .='<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Ownership</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';
    
        $sql= database::performQuery("
    
            SELECT ownership.id,ownership.name,COUNT(*) as schools
            FROM sub_region,district,market,county,subcounty,parish,ownership
            WHERE district.id=county.district_id
            AND sub_region.id = district.sub_region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND ownership.id = school.ownership_id
            AND sub_region_id = $sub_region[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?ownership='.$data['id'].'&subregion='.$sub_region['id'].'&action=search">  <span class="label label-sm label-success"> View</span></a>
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
            FROM sub_region,district,market,county,subcounty,parish,boarding_type
            WHERE district.id=county.district_id
            AND sub_region.id = district.sub_region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND boarding_type.id = school.boarding_type_id
            AND sub_region_id = $region[id]
            GROUP BY boarding_type.id
            ORDER BY boarding_type.name ASC
            ");
        while($data = $sql->fetch_assoc()){
            $content .='<tr>
                                <td><small> '.$data['name'].' </small></td>
                                <td> '.number_format($data['schools']).'</td>
                                <td>
                                  <a href="'.ROOT.'/?boarding='.$data['id'].'&subregion='.$region['id'].'&action=search">  <span class="label label-sm label-success"> View</span></a>
                                </td>
                            </tr>';
        }
    
         
        return $content;
    }
    

    private static function viewRegionTotalSchool($district)
    {
        $content = '';
        
            $content .='<tr>
                               <td>  <b> Total Schools</b> </td>
                                <td colspan=2> <b>'.self::countSubRegionSchoolsWithID($district['id']).'</b></td>
                               
                            </tr>';
       return $content;
         
        
    }

    public static function regionBio($name) {
        $sql = database::performQuery("SELECT region.name,brief,COUNT(*) as schools
            FROM district,county,subcounty,parish,market,sub_region
            WHERE sub_region.name LIKE '$name'
            AND sub_region.id = district.sub_region_id
            AND district.id = county.district_id
            AND county.id = subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id");
        return $sql->fetch_assoc();
    }
    
    //Returjn parent categories with their school total in the district
    public static function districtDescription2($id) {
        $sql = database::performQuery("
           				
				
				SELECT market_category.id,market_category.parent_id,market_category.name as name,COUNT(*) as total
            FROM sub_region,district,market,county,subcounty,parish,market_category
            WHERE district.id=county.district_id
                AND sub_region.id = district.sub_region_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = market.parish_id
				AND market_category.id = market.market_category_id
				AND sub_region_id = $id
				GROUP BY market_category.id
            
            ")  ;
        $content = [];
        while ($data=$sql->fetch_assoc()) {
            $content[]= $data['total'].' '.ucwords(strtolower($data['name'])).' Markets';
        }
        
        return implode(', ',$content);
    
    }
    
    
    
    
    
    //count subcounties
    public static function countDistrict($id) {
        $sql = database::performQuery("
            SELECT *
            FROM district
            WHERE sub_region_id = $id
            ");
        return $sql->num_rows;
    }
    
    
    
    //count subcounties
    public static function countCounties($id) {
        $sql = database::performQuery("
            SELECT *
            FROM district,county
            WHERE district.id=county.district_id
            AND sub_region_id = $id
            GROUP BY district.id,county.id
            ");
        return $sql->num_rows;
    }
    
    //count subcounties
    public static function countSubcounties($id) {
        $sql = database::performQuery("
            SELECT *
            FROM district,county,subcounty
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND sub_region_id = $id
            GROUP BY district.id,county.id,subcounty.id
            ");
        return $sql->num_rows;
    }
    

    //count parishes
    public static function countParishes($id) {
        $sql = database::performQuery("
            SELECT *
            FROM district,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND sub_region_id = $id
            GROUP BY sub_region_id,district.id,county.id,subcounty.id,parish.id
            ");
        return $sql->num_rows;
    }
    

    //count villages
    public static function countVillages($id) {
        $sql = database::performQuery("
            SELECT *
            FROM district,county,subcounty,parish,village
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = village.parish_id
            AND sub_region_id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id,village.id
            ");
        return $sql->num_rows;
    }
    

    public static function countSubRegionSchoolsWithCategory($id,$cid)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM sub_region,district,market,county,subcounty,parish,school_category,category
            WHERE district.id=county.district_id
            AND sub_region.id = district.sub_region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = category.id
            AND sub_region_id = $id
            AND category_id = $cid
    
            ");
    
        while ($data = $sql->fetch_assoc())
            return number_format($data['schools']);
    }
    
    

    //Get Random 10 Districts with their school count for specific region
    public static function getSchoolsRegion($sub_region){
    
        $sql = database::performQuery("
            SELECT district.name,district.id,district.map_id,COUNT(*) as schools
            FROM district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND sub_region_id = $sub_region
            GROUP BY district.name
            ORDER BY district.name ASC
            ");
        $x=1;
        $content = '';
    
        while ($data = $sql->fetch_assoc()) {
    
            //Color Button Icons
            $color = "";
            switch($sub_region)
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
    

    public static function countSubRegionSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM sub_region,district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND sub_region.id = district.sub_region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND sub_region_id = $id
    
            ");
    
        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }
    
    
    
    public static function viewSubRegionSubcountySchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT county.name as county,district.name as district,subcounty.id as id,subcounty.name as name, COUNT(*) as schools
            FROM district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
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
            AND district.sub_region_id = $id
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
            SELECT sub_region.id,sub_region.name, COUNT(*) as schools
            FROM sub_region,district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND sub_region.id = district.sub_region_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            GROUP BY sub_region_id
            ORDER BY sub_region_id ASC
            ");
        $content  ="";
        while ($data = $sql->fetch_assoc())
        {
            $content .='<tr><td> '.ucwords(strtolower($data['name'])).' Sub Region</td>
                                <td><small> '.$data['schools'].'</small></td>
                                <td>
                                  <a href="'.ROOT.'/find-a-market/subregion/'.strtolower($data['name']).'">  <span class="label label-sm label-info"> View</span></a>
                                </td>
                            </tr>';
    
        }
    
    
    
        return $content;
    }
     
    
}



?>