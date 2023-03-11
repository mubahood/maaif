<?php

class district
{

    public static function getDistrictName($id){

        $sql = database::performQuery("SELECT name FROM district WHERE id=$id");
        $ret = $sql->fetch_assoc();

        return $ret['name'];
    }

    public static function getAllDistrictsList(){

        $sql = database::performQuery("SELECT * FROM district ORDER BY name ASC");
        $content = '';
        while($data = $sql->fetch_assoc()){

            $content .='<option value="'.$data['id'].'">'.strtoupper(strtolower($data['name']));
        }

        return $content;
    }

    //Region
    public static function Alldistricts()
    {

        $content = '

<div class="row about-links-cont" data-auto-height="true">
        <div class="col-md-6 col-sm-12 about-links">
        <div class="row">
        
                    ' . self::viewAllDistricts() . '
        
                        </div>
        
                        </div>
                        <div class="col-md-6 col-sm-12" style="padding:60px">
                        <div id="map"></div>
                        </div>
                        </div>
         
                        ';

        return $content;
    }


    //tabulate results in 3 columns district
    public static function viewAllDistricts()
    {

        $content = '';
        $result = database::performQuery("SELECT district.name as name,COUNT(*) as schools
            FROM district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            GROUP BY district.name
            ORDER BY name ASC");
        $i = 1;
        $content .= '<div class="table-scrollable table-scrollable-borderless"> <table class="table table-hover table-light"><tr>';
        while ($row = $result->fetch_assoc()) {
            $content .= '<td><small> <i class="icon-check" style="color:#3598DC"></i> <a href="' . ROOT . '/find-a-market/district/' . strtolower($row['name']) . '">' . ucwords(strtolower($row['name'])) . ' District</a> (' . $row['schools'] . ') </small></td>';
            if ($i == 3) {
                $content .= '</tr><tr>';
                $i = 0;
            }
            $i++;
        }
        $content .= '</tr></table></div>';

        return $content;
    }


    //District Page
    public static function viewDistrict()
    {
        $name = ucwords(strtolower($_REQUEST['name']));
        //Check If District Exists
        $sql = database::performQuery("SELECT * FROM district WHERE name LIKE '$name'");
        if ($sql->num_rows == 0)
            notFound();
        else {
            while ($data = $sql->fetch_assoc()) {
                $district = $data;
            }

            $district_info = self::districtDescription($district['id']);


            $content = "";
            $content .= ' <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <!-- BEGIN BLOCKQUOTES PORTLET-->
                                                    <div class="portlet light ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <span class="caption-subject font-green bold uppercase">' . $name . ' District </span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
                                                            ' . ucwords($name) . ' District is a District found in the ' . ucwords(strtolower($district_info['sub_region'])) . '
                                                                Sub-Region of ' . $district_info['region'] . ' Uganda.  The district has ' . self::countSubcounties($district['id']) . ' sub counties,
                                                                    ' . self::countParishes($district['id']) . ' Parishes and ' . self::countVillages($district['id']) . ' villages.
                                                                    The District has over ' . self::countDistrictSchoolsWithID($district['id']) . ' markets currently with
                                                                        ' . self::districtDescription2($district['id']) . '.
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
                                                                <span class="caption-subject font-blue-sharp bold uppercase">' . $name . ' District Market Statistics</span>
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
                                                                        <th> Markets </th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
            $content .= self::viewDistrictSchoolsCategory($district);
            $content .= self::viewDistrictTotalSchool($district);
            $content .= ' </tbody>
                                                            </table>
                                                        </div>
    
    
    
    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="map"></div>
                                  
                                                                   <br />
                                                                   <a class="btn btn-xs" style="background: #33BABE" href="javascript:;"> &nbsp; &nbsp; </a>  <b> ' . ucwords(strtolower($name)) . ' District</b>
                                    
                                    
                                                                   <h3> ' . ucwords(strtolower($name)) . ' District  Links</h3>
																	<ul>
                                                                   <li><a target="_blank" href="http://' . strtolower($name) . '.go.ug">Official District Page</a></li>
                                                                   <li><a target="_blank" href="https://en.wikipedia.org/' . $name . '_District">Official District Wikipedia Page</a></li>
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
            $content .= self::viewDistrictGender($district);
//            $content .= self::viewDistrictOwnership($district);
//            $content .= self::viewDistrictBoarding($district);
              $content .= ' </tbody>
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
                                                                <span class="caption-subject font-red bold uppercase">District Subcounties and Nearby Districts</span>
                                                            </div>
    
                                                        </div>
                                                        <div class="portlet-body">
    
								
								
															<div class="row">
                                                                <div class="col-md-6">
                                                                    <h3>' . $name . ' Subcounty Markets</h3>
                                      
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:700">
                                                                        <th> Subcounty </th>
                                                                        <th> Markets </th>
                                                                        <th>  </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
            $content .= self::viewDistrictSubcountySchoolsWithID($district['id']);

            $content .= ' </tbody>
                                                            </table>
                                                        </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h3>Districts In ' . ucwords(strtolower($district_info['sub_region'])) . ' Sub Region</h3>
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
            $content .= self::viewDistrictSubregionSchoolsWithID($district['id'], $district_info['sub_region_id']);

            $content .= ' </tbody>
                                                            </table>
                                                        </div>
                                  
    
                                                                </div>
                                                            </div>
								
								
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END WELLS PORTLET-->
    
                                            </div>
                                            
                                            ' . ad::viewSidebar(ad::ad240_pri(), ad::ad240_208()) . '
                                            
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->';

            return $content;
        }


    }

    public static function districtDescription($id)
    {
        $sql = database::performQuery("SELECT district.id as id,district.name as name,region.name as region,sub_region.name as sub_region,sub_region.id as sub_region_id FROM region,sub_region,district WHERE region.id =district.region_id AND sub_region.id =district.sub_region_id AND district.id=$id");
        while ($data = $sql->fetch_assoc()) {
            return $data;
        }

    }

    public static function countSubcounties($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM district,county,subcounty
            WHERE district.id=county.district_id
                AND county.id= subcounty.county_id
                AND district.id = $id
                GROUP BY district.id,county.id,subcounty.id
            ");
        return $sql->num_rows;
    }

    public static function countParishes($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM district,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND district.id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id
            ");
        return $sql->num_rows;
    }

    public static function countVillages($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as total
            FROM district,county,subcounty,parish,village
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = village.parish_id
            AND district.id = $id
            GROUP BY district.id,county.id,subcounty.id,parish.id,village.id
            ");
        return $sql->num_rows;
    }

    public static function countDistrictSchoolsWithID($id)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND district.id = $id
    
            ");

        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }

    public static function districtDescription2($id)
    {
        $sql = database::performQuery("
            
            SELECT market_category.id,market_category.name as name,COUNT(*) as total
            FROM district,market,county,subcounty,parish,market_category
            WHERE district.id=county.district_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = market.parish_id
				AND market_category.id = market.market_category_id
				AND district.id = $id
				GROUP BY market_category.id
            
            ");
        $content = [];
        while ($data = $sql->fetch_assoc()) {
            $content[] = $data['total'] . ' ' . ucwords(strtolower($data['name'])) . ' ';
        }

        return implode(', ', $content);

    }

    private static function viewDistrictSchoolsCategory($district)
    {

        $sql = database::performQuery("
           SELECT * FROM market_category WHERE parent_id = 0
            ");

        $content = '';
        $colors = ['danger', 'success', 'info', 'warning'];
        while ($data = $sql->fetch_assoc()) {

            $content .= '<tr>
                               <td class="highlight"> <div class="' . $colors[rand(0, 3)] . '"></div> &nbsp; <b> ' . ucwords(strtolower($data['name'])) . ' </b> </td>
                                <td> </td>
                                <td>
                               </td>
                            </tr>';

            //Child Categories

            $sqlc = database::performQuery("
                   
           SELECT market_category.name,market_category.id,COUNT(*) as schools
            FROM district,market,county,subcounty,parish,market_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND market.market_category_id = market_category.id
            AND district.id = $district[id]
            AND parent_id = $data[id]
           GROUP BY market_category.id
            
            ");
            if ($sqlc->num_rows > 0) {
                while ($datac = $sqlc->fetch_assoc()) {

                    $content .= '<tr>
                                <td><small style="text-transform: capitalize;">' . ucwords(strtolower($datac['name'])) . '</small></td>
                                <td> ' . $datac['schools'] . '</td>
                                <td>
                                <a href="' . ROOT . '/?category=' . $datac['id'] . '&district=' . $district['id'] . '&action=search">  <span class="label label-sm label-success"> View List</span></a>
                            
                                </td>
                            </tr>';
                }
            }


        }


        return $content;
    }


    //Returjn parent categories with their school total in the district

    private static function viewDistrictTotalSchool($district)
    {
        $content = '';

        $content .= '<tr>
                               <td>  <b> Total Markets</b> </td>
                                <td colspan=2> <b>' . self::countDistrictSchoolsWithID($district['id']) . '</b></td>
                               
                            </tr>';
        return $content;


    }




    //Error 404 Not found


    //count subcounties

    private static function viewDistrictGender($district)
    {
        $content = '';
        $content .= '<tr>
                               <td class="highlight"> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql = database::performQuery("
    
                    
            SELECT dmp_category.id,dmp_category.name,COUNT(*) as schools
            FROM district,dmp,county,subcounty,parish,dmp_category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = dmp.parish_id
            AND dmp.dmp_category_id = dmp_category.id
            AND district.id = $district[id]
            GROUP BY dmp_category.id
            ");
        while ($data = $sql->fetch_assoc()) {
            $content .= '<tr>
                                <td><small> ' . $data['name'] . ' </small></td>
                                <td> ' . $data['schools'] . '</td>
                                <td>
                                  <a href="' . ROOT . '/?category=' . $data['id'] . '&district=' . $district['id'] . '&action=searchDMP">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    //count parishes

    private static function viewDistrictOwnership($district)
    {
        $content = '';
        $content .= '<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Ownership</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql = database::performQuery("
    
            SELECT ownership.id,ownership.name,COUNT(*) as schools
            FROM district,market,county,subcounty,parish,ownership
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND ownership.id = school.ownership_id
            AND district.id = $district[id]
            GROUP BY ownership.id
            ORDER BY ownership.name ASC
            ");
        while ($data = $sql->fetch_assoc()) {
            $content .= '<tr>
                                <td><small> ' . $data['name'] . ' </small></td>
                                <td> ' . $data['schools'] . '</td>
                                <td>
                                  <a href="' . ROOT . '/?ownership=' . $data['id'] . '&district=' . $district['id'] . '&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    //count villages

    private static function viewDistrictBoarding($district)
    {
        $content = '';
        $content .= '<tr>
                               <td class="highlight"> <div class="info"></div> &nbsp; <b> Boarding Facilities</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql = database::performQuery("
    
            SELECT boarding_type.id,boarding_type.name,COUNT(*) as schools
            FROM district,market,county,subcounty,parish,boarding_type
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND boarding_type.id = school.boarding_type_id
            AND district.id = $district[id]
            GROUP BY boarding_type.id
            ORDER BY boarding_type.name ASC
            ");
        while ($data = $sql->fetch_assoc()) {
            $content .= '<tr>
                                <td><small> ' . $data['name'] . ' </small></td>
                                <td> ' . $data['schools'] . '</td>
                                <td>
                                  <a href="' . ROOT . '/?boarding=' . $data['id'] . '&district=' . $district['id'] . '&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }

    private static function viewDistrictFoundingBody($district)
    {
        $content = '';
        $content .= '<tr>
                               <td class="highlight"> <div class="success"></div> &nbsp; <b> Founding Body</b> </td>
                                <td></td>
                                <td></td>
                            </tr>';

        $sql = database::performQuery("
            
            SELECT founding_body.id,founding_body.name,COUNT(*) as schools
            FROM district,market,county,subcounty,parish,founding_body
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND founding_body.id = school.founding_body_id
            AND district.id = $district[id]
            GROUP BY founding_body.id
            ORDER BY founding_body.name ASC
            ");
        while ($data = $sql->fetch_assoc()) {
            $content .= '<tr>
                                <td><small> ' . $data['name'] . ' </small></td>
                                <td> ' . $data['schools'] . '</td>
                                <td>
                                  <a href="' . ROOT . '/?founding_body=' . $data['id'] . '&district=' . $district['id'] . '&action=search">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    //Get Random 10 Districts with their school count for specific region

    public static function viewDistrictSubcountySchoolsWithID($id)
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
            ORDER BY district.id ASC,county.id ASC, subcounty.id ASC
            ");
        $content = "";
        $new = '';
        $old = '';
        $colors = ['info', 'success', 'danger', 'warning'];
        while ($data = $sql->fetch_assoc()) {

            $new = $data['county'];
            $content .= '<tr>';
            if ($new != $old)
                $content .= '<tr><td class="highlight" colspan=3> <div class="' . $colors[rand(0, 3)] . '"></div> &nbsp; <b>' . $data['county'] . ' COUNTY</b> </td></tr>';
            else
                $content .= '';
            $content .= ' <td><small> ' . $data['name'] . '</small></td>
                                <td><small> ' . $data['schools'] . '</small></td>
                                <td>
                                  <!--<a href="' . ROOT . '/find-a-market/subcounty/' . strtolower($data['district']) . '/' . makeSeo($data['name']) . '/' . $data['id'] . '">  <span class="label label-sm label-warning">Browse</span></a>-->
                                  <a href="' . ROOT . '/?subcounty=' . $data['id'] . '&action=search">  <span class="label label-sm label-success"> List</span></a>
                                
                                </td>
                            </tr>';
            $old = $new;
        }


        return $content;
    }

    public static function viewDistrictSubregionSchoolsWithID($id, $sid)
    {
        $sql = database::performQuery("
            SELECT district.id,district.name, COUNT(*) as schools
            FROM district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND district.id != $id
            AND district.sub_region_id = $sid
            GROUP BY district.id
            ORDER BY district.id ASC
            ");
        $content = "";
        while ($data = $sql->fetch_assoc()) {
            $content .= '<tr><td> ' . ucwords(strtolower($data['name'])) . ' District</td>
                                <td><small> ' . $data['schools'] . '</small></td>
                                <td>
                                  <a href="' . ROOT . '/find-a-market/district/' . strtolower($data['name']) . '">  <span class="label label-sm label-warning"> Browse </span></a>
                                </td>
                            </tr>';

        }


        return $content;
    }

    public static function countDistrictSchoolsWithCategory($id, $cid)
    {
        $sql = database::performQuery("
            SELECT COUNT(*) as schools
            FROM district,market,county,subcounty,parish,school_category,category
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND school.id = school_category.school_id
            AND school_category.category_id = category.id
            AND district.id = $id
            AND category_id = $cid
    
            ");

        while ($data = $sql->fetch_assoc())
            return $data['schools'];
    }

    public static function getSchoolsRegion($region)
    {

        $sql = database::performQuery("
            SELECT district.name,district.id,district.map_id,COUNT(*) as schools
            FROM district,market,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = market.parish_id
            AND region_id = $region
            GROUP BY district.name
            ORDER BY district.name ASC
            ");
        $x = 1;
        $content = '';

        while ($data = $sql->fetch_assoc()) {

            //Color Button Icons
            $color = "";
            switch ($region) {
                case 1:
                    $color = '#9A12B3';
                    break;
                case 2:
                    $color = '#F3C200';
                    break;
                case 3:
                    $color = '#26C281';
                    break;
                case 4:
                    $color = '#3598DC';
                    break;
                default:
                    break;

            }


            $content .= '<li> <small style="font-size:10px"> <i class="icon-check" style="color:' . $color . '"></i> <a href="' . ROOT . '/find-a-market/district/' . strtolower($data['name']) . '">' . ucwords(strtolower($data['name'])) . ' </a> <b>(' . $data['schools'] . ')</b></small></li>';

        }
        return $content;

    }


}


?>