<?php

class map
{
    
    // Function to set sub region colors
    public static function setSubRegionColor()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);
        
        $sql = database::performQuery("
           SELECT sub_region_id 
            FROM district 
             WHERE district.map_id = $id            
             ");
        
        $data = $sql->fetch_assoc();
        $id = $data['sub_region_id'];
        
        switch ($id) {
            case 1:
                echo 'blue';
                break;
            
            case 2:
                echo 'red';
                break;
            
            case 3:
                echo 'green';
                break;
            
            case 4:
                echo 'orange';
                break;
            
            case 5:
                echo 'yellow';
                break;
            
            case 6:
                echo 'purple';
                break;
            
            case 7:
                echo 'grey';
                break;
            
            case 8:
                echo '#76ff07';
                break;
            
            case 9:
                echo 'black';
                break;
            
            case 10:
                echo '#00adf7';
                break;
            
            case 11:
                echo 'pink';
                break;
            
            case 12:
                echo '#e0bcde';
                break;
            
            case 13:
                echo '#b75200';
                break;
            
            default:
                break;
        }
    }
    
    public static function setSubRegionColorFill()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);
    
        $sql = database::performQuery("
            SELECT sub_region_id
            FROM district
            WHERE district.map_id = $id
            ");
    
            $data = $sql->fetch_assoc();
            $id = $data['sub_region_id'];
    
           if($_SESSION['sub_region_active'] == $id)
                echo '#000000';
            else 
                echo '#d10a00';
    }
    
    // Function to set region colors
    public static function setRegionColor()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);
        
        $sql = database::performQuery("
           SELECT region_id 
            FROM district 
             WHERE district.map_id = $id            
             ");
        
        $data = $sql->fetch_assoc();
        $id = $data['region_id'];
        
        switch ($id) {
            case 1:
                echo '#9A12B3';
                break;
            
            case 2:
                echo '#F3C200';
                break;
            
            case 3:
                echo '#26C281';
                break;
            
            case 4:
                echo 'blue';
                break;
            
            default:
                break;
        }
    }
    
    
    
    public static function setRegionColorFill()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);
    
        $sql = database::performQuery("
            SELECT region_id
            FROM district
            WHERE district.map_id = $id
            ");
    
            $data = $sql->fetch_assoc();
            $id = $data['region_id'];
    
            if($_SESSION['region_active'] == $id)
                echo '#000000';
            else 
                echo '#d10a00';
    }


    public static function findDistrictIdByMapId(){
        $id = str_replace('UG-', '', $_REQUEST['id']);
        $sql=database::performQuery("SELECT district.id FROM district WHERE map_id =$id");
        $ret = $sql->fetch_assoc();

        return $ret['id'];
    }

    public static function findDistrictNameByMapId(){
        $id = str_replace('UG-', '', $_REQUEST['id']);
        $sql=database::performQuery("SELECT district.name FROM district WHERE map_id =$id");
        $ret = $sql->fetch_assoc();

        return $ret['name'];
    }

    public static function viewDistrictActivitiesByOfficers(){
        $id = self::findDistrictIdByMapId();
        $sql = database::performQuery("SELECT * FROM user_category WHERE id IN (4,8,9)");


        $content = '<div class="row" style="min-width:400px"><div class="col-md-12">
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:800">
                                                                        <th style="font-weight:800"> Category </th>
                                                                        <th style="font-weight:800"> No. Officers</th>
                                                                        <th style="font-weight:800"> No. Activities</th>                                                                   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
        $colors = ['danger','success','info','warning'];
        while ($data = $sql->fetch_assoc())
        {

            $content .='<tr>    <td class="highlight"> <div class="'.$colors[rand(0,3)].'"></div> &nbsp; <b> '.ucwords(strtolower($data['name'])).' </b> </td>
                                <td>'.self::countDistrictOfficers($id,$data['id']).'</td>
                                <td>'.self::countDistrictOfficersActivities($id,$data['id']).'</td>
                            </tr>';
        }

        $content .='</table></div></div>';




        echo $content;
    }




    public static function countDistrictOfficers($district_id,$category){

        $sql = database::performQuery("SELECT * FROM district,user WHERE district.id = user.district_id AND user_category_id=$category AND district_id=$district_id ");

        return $sql->num_rows;
    }

    public static function countDistrictOfficersActivities($district_id,$category){

        $sql = database::performQuery("SELECT * FROM district,user,ext_area_daily_activity WHERE district.id = user.district_id AND user_category_id=$category AND district_id=$district_id AND user.id = ext_area_daily_activity.user_id ");

        return $sql->num_rows;
    }

    public static function viewDistrictDMP($district_id)
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
            AND district.id = $district_id
            GROUP BY dmp_category.id
            ");
        while ($data = $sql->fetch_assoc()) {
            $content .= '<tr>
                                <td><small> ' . $data['name'] . ' </small></td>
                                <td> ' . $data['schools'] . '</td>
                                <td>
                                  <a href="' . ROOT . '/?category=' . $data['id'] . '&district=' . $district_id . '&action=searchDMP">  <span class="label label-sm label-success"> View List</span></a>
                                </td>
                            </tr>';
        }


        return $content;
    }


    // Function to calculate total schools per district
    public static function countDistrictSchools()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);
        
        $sql = database::performQuery("
           SELECT COUNT(*) as activities
            FROM district,ext_area_daily_activity,county,subcounty,parish,village
            WHERE district.id=county.district_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = village.parish_id
                AND village.id = ext_area_daily_activity.village_id
				AND district.map_id = $id
            
             ");
        
        while ($data = $sql->fetch_assoc())
            echo $data['activities'];
    }


    // Function to calculate total schools per district by category
    public static function countDistrictSchoolsCategory()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);
        
        $sql = database::performQuery("
           SELECT category_id,category.name as name,district.name as district, COUNT(*) as total
            FROM district,school,county,subcounty,parish,category,school_category
            WHERE district.id=county.district_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = school.parish_id
				AND category.id = school_category.category_id
				AND school.id = school_category.school_id
				AND district.map_id = $id
				AND category.parent = 0 
				GROUP BY category.id
            
             ");
        $content = "<div class=\"table-scrollable table-stripped  table-condensed table-hover table-scrollable-borderless\">
                                                            <table class=\"table table-hover table-light\">
                                                                <thead>
                                                                    <tr class=\"uppercase\">
                                                                        <th> Category</th>
                                                                        <th> Total School </th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   
                                                             ";
        while ($data = $sql->fetch_assoc()) {
            $name= $data['district'];
            $content .= '
                                                                    <tr>
                                                                        <td> ' . ucwords(strtolower($data['name'])) . ' Schools</b></td>
                                                                        <td>  ' . $data['total'] . '  </td>
                                                                      
                                                                    </tr>
';
        }

        $content .= '
        <tr>
        <td colspan="2">
        <a href="'.ROOT.'/find-a-market/district/'.strtolower($name).'"> <button class="btn btn-xs  btn-circle blue">Browse '.$name.' Schools</button></a>
        </td>
        </tr>      
                                                                </tbody>
                                                            </table>
                                                        </div>
        ';

        echo $content;
    }



    // Function to calculate total schools per district by category
    public static function countDistrictSchoolsCategoryGender()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);

        $sql = database::performQuery("
           SELECT school_type_id, school_type.name as name,district.id as district_id,district.name as district, COUNT(*) as total
            FROM district,school,county,subcounty,parish,school_type
            WHERE district.id=county.district_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = school.parish_id
				AND school_type.id = school.school_type_id
				AND district.map_id = $id
				GROUP BY school_type.id
            
             ");
        $content = "<div class=\"table-scrollable table-stripped  table-condensed table-hover table-scrollable-borderless\">
                                                            <table class=\"table table-hover table-light\">
                                                                <thead>
                                                                    <tr class=\"uppercase\">
                                                                        <th> Category</th>
                                                                        <th> Schools </th>
                                                                        <th> &nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   
                                                             ";
        while ($data = $sql->fetch_assoc()) {
            $name= $data['district'];
            $content .= '
                                                                    <tr>
                                                                        <td> ' . ucwords(strtolower($data['name'])) . ' Schools</b></td>
                                                                        <td>  ' . $data['total'] . '  </td>
                                                                      <td> <a href="'.ROOT.'/?action=search&gender='.$data['school_type_id'].'&district='.$data['district_id'].'"> <button class="btn btn-xs  btn-circle blue">view</button></a>  </td>
                                                                    </tr>
';
        }

        $content .= '
            
                                                                </tbody>
                                                            </table>
                                                        </div>
        ';

        echo $content;
    }



    // Function to calculate total schools per district by category
    public static function countDistrictSchoolsCategoryFoundingBody()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);

        $sql = database::performQuery("
           SELECT founding_body_id,district.id as district_id, founding_body.name as name,district.name as district, COUNT(*) as total
            FROM district,school,county,subcounty,parish,founding_body
            WHERE district.id=county.district_id
                AND county.id= subcounty.county_id
                AND subcounty.id = parish.subcounty_id
                AND parish.id = school.parish_id
				AND founding_body.id = school.founding_body_id
				AND district.map_id = $id
				GROUP BY founding_body.id
            
             ");
        $content = "<div class=\"table-scrollable table-stripped  table-condensed table-hover table-scrollable-borderless\">
                                                            <table class=\"table table-hover table-light\">
                                                                <thead>
                                                                    <tr class=\"uppercase\">
                                                                        <th> Category</th>
                                                                        <th> Schools </th>
                                                                        <th> &nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   
                                                             ";
        while ($data = $sql->fetch_assoc()) {
            $name= $data['district'];
            $content .= '
                                                                    <tr>
                                                                        <td> ' . ucwords(strtolower($data['name'])) . ' Schools</b></td>
                                                                        <td>  ' . $data['total'] . '  </td>
                                                                      <td> <a href="'.ROOT.'/?action=search&founding_body='.$data['founding_body_id'].'&district='.$data['district_id'].'"> <button class="btn btn-xs  btn-circle blue">view</button></a>  </td>
                                                                    </tr>
';
        }

        $content .= '
            
                                                                </tbody>
                                                            </table>
                                                        </div>
        ';

        echo $content;
    }



    public static function plotAllDistrictsMap() {
       echo'
  <script type="text/javascript">         
//Plot Ugandan Region with colors
$("#map").mapSvg({
    source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
    responsive: 1,
    zoom: {on:1},
    colors: {
        baseDefault: "#33BABE",
        background: "rgba(238,238,238,0)",
        disabled: "#d10a00",
        selected: 30,
        hover: 18,
        base: "#33BABE",
        stroke: "#ffffff"
    },
    
    tooltips: {mode: function(){
        return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
	popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetails(this.id) ;
    }, on: true, priority: "local"},
	afterLoad: function(){
		        
    }
});
  </script>         
	';
    }


    public static function plotRegionMap() {
        echo'
  <script type="text/javascript">         
//Plot Ugandan Region with colors
$("#map").mapSvg({
    source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	colors: {
        baseDefault: "#5c5cff",
        background: "rgba(238,238,238,0)",
        disabled: "#d10a00",
        selected: 30,
        hover: 18,
        base: "#5c5cff",
        stroke: "#ffffff"
    },
    
    tooltips: {mode: function(){
         return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
	popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> " + districtSchoolDetails(this.id) + "<h5>Total Activities:<b> "+countSchoolDistrict(this.id) +" </h5></b>" ;
    }, on: true, priority: "local"},
	afterLoad: function(){
		
		 var regions = this.getData().regions;
        regions.forEach(function(region){
         
         
         '.region::prepMapSwitchAllRegions().'
         
        });
         
    }
});
  </script>         
	';
    }


    public static function plotRegionMapFill() {
        echo'
  <script type="text/javascript">
//Plot Ugandan Region with colors
$("#map").mapSvg({
    source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	colors: {
        baseDefault: "#33BABE",
        background: "rgba(238,238,238,0)",
        disabled: "#d10a00",
        selected: 30,
        hover: 18,
        base: "#33BABE",
        stroke: "#ffffff"
    },
    
    tooltips: {mode: function(){
         return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
	popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetails(this.id) ;
    }, on: true, priority: "local"},
	afterLoad: function(){
    
		 var regions = this.getData().regions;
        regions.forEach(function(region){
         '.region::prepMapSwitch().'
        });
     
    }
});
  </script>
	';
    }



    //Plot Subregion Map
    public static function plotSubRegionMap() {
      echo'
          <script type="text/javascript">
//Plot Ugandan Sub Region with colors		
$(\'#map\').mapSvg({
    source: \''.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg\',
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	colors: {
        baseDefault: "#33BABE",
        background: "rgba(238,238,238,0)",
        disabled: "#d10a00",
        selected: 30,
        hover: 18,
        base: "#33BABE",
        stroke: "#ffffff"
    },
    
    tooltips: {mode: function(){
         return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
	popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetails(this.id) ;
    }, on: true, priority: "local"},
	afterLoad: function(){
		
		 var regions = this.getData().regions;
        regions.forEach(function(region){
          region.setFill(subRegionColor(region.id));  
        });
         
    }
});
     </script>     
          ';
    }




    public static function plotSubRegionMapFill() {
        echo'
          <script type="text/javascript">
          
     //Plot Ugandan Sub Region with colors
$(\'#map\').mapSvg({
    source: \''.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg\',
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	colors: {
        baseDefault: "#33BABE",
        background: "rgba(238,238,238,0)",
        disabled: "#d10a00",
        selected: 30,
        hover: 18,
        base: "#33BABE",
        stroke: "#ffffff"
    },
    
    tooltips: {mode: function(){
         return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
	popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetails(this.id) ;
    }, on: true, priority: "local"},
	afterLoad: function(){
                       
          var regions = this.getData().regions;
        regions.forEach(function(region){
        
        '.subregion::prepMapSwitch().'      
        
          
        });
     
    }
});
     </script>
          ';
    }


    //Plot district by number of schools gradient map
    public static function plotDistrictGradientMap() {
        echo'
            
    
	<script type="text/javascript">		
//Plot Ugandan districts with colors where the one with most schools is lighter		
$("#map").mapSvg({
    source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	menu: {on: 1, containerId: "mapsvg-menu"},
    colors: {
        baseDefault: "#33BABE",
        background: "rgba(238,238,238,0)",
        disabled:"#d10a00",
        selected: 30,
        hover: 18,
        base: "#33BABE",
        stroke: "#ffffff"
    },
    gauge: {
        colors: {low: "#bd2200",high: "#ffe3c1"}
    },
    tooltips: {mode: function(){
         return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
    popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetails(this.id) ;
    }, on: true, priority: "local"},
    afterLoad: function(){
        var regions = this.getData().regions;
        regions.forEach(function(region){
            region.setGaugeValue(countSchoolDistrict(region.id));
        });
        this.setGauge({on:1});

    }
});
	</script>
            ';
    }


    //Plot district by number of schools gradient map
    public static function plotGenderGradientMap() {
        echo'
            
    
	<script type="text/javascript">		
//Plot Ugandan districts with colors where the one with most schools is lighter		
$("#map").mapSvg({
    source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	menu: {on: 1, containerId: "mapsvg-menu"},
    colors: {
        baseDefault: "#33BABE",
        background: "rgba(238,238,238,0)",
        disabled:"#d10a00",
        selected: 30,
        hover: 18,
        base: "#33BABE",
        stroke: "#ffffff"
    },
    gauge: {
        colors: {low: "#bd2200",high: "#ffe3c1"}
    },
    tooltips: {mode: function(){
         return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
    popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetailsGender(this.id) ;
    }, on: true, priority: "local"},
    afterLoad: function(){
        var regions = this.getData().regions;
        regions.forEach(function(region){
           '.gender::prepMapSwitch().' 
        });
        

    }
});
	</script>
            ';
    }



    //Plot district by number of schools gradient map
    public static function plotFoundingBodyGradientMap() {
        echo'
            
    
	<script type="text/javascript">		
//Plot Ugandan districts with colors where the one with most schools is lighter		
$("#map").mapSvg({
    source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	menu: {on: 1, containerId: "mapsvg-menu"},
    colors: {
        baseDefault: "#33BABE",
        background: "rgba(238,238,238,0)",
        disabled:"#d10a00",
        selected: 30,
        hover: 18,
        base: "#33BABE",
        stroke: "#ffffff"
    },
    gauge: {
        colors: {low: "#bd2200",high: "#ffe3c1"}
    },
    tooltips: {mode: function(){
         return (this.title ? " "+this.title : " ")+" District ";
    }, on: true, priority: "local"},
    popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetailsFoundingBody(this.id) ;
    }, on: true, priority: "local"},
    afterLoad: function(){
        var regions = this.getData().regions;
        regions.forEach(function(region){
           '.foundingbody::prepMapSwitch().' 
        });
        

    }
});
	</script>
            ';
    }




    //plot district map
    public static function plotDistrictMap($name)
    {
        $sql = database::performQuery("SELECT map_id FROM district WHERE name LIKE '$name'");
        $data = $sql->fetch_assoc();
        $id = $data['map_id'];
        
        echo'
	 
            <script type="text/javascript">
            $("#map").mapSvg({
               source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
                responsive: 1,
                zoom: {on: 1},
                scroll: {on:1},
				menu: {on: 1, containerId: "mapsvg-menu"},
                colors: {
                    baseDefault: "#e59814",
                    background: "#fff",
                    disabled: "#d10a00",
                    selected: 30,
                    hover: 18,
                    base: "#c99700",
                    stroke: "#ffffff"
                },
                gauge: {
                    colors: {low: "#bd2200",high: "#ffe3c1"}
                },
                tooltips: {mode: function(){
                     return (this.title ? " "+this.title : " ")+" District ";
                }, on: true, priority: "local"},
                popovers: {mode: function(){
                    return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> <h5>Total Markets:<b> "+countSchoolDistrict(this.id) +" </h5></b>" + districtSchoolDetails(this.id) ;
                }, on: true, priority: "local"},
                afterLoad: function(){
					 var regions = this.getData().regions;
                    regions.forEach(function(region){
						if(region.id=="UG-'.$id.'")
						{region.setFill("#5c5cff");}
					    else if(region.id != "UG-'.$id.'")
						{
							region.setDisabled(true);
						}
                    });
      
                }
            });
        </script>
	 
            ';
    }

    public static function viewDistrictOutbreaksByOfficers(){
        $id = self::findDistrictNameByMapId();
        $sql = database::performQuery("SELECT a9,COUNT(*) as tot FROM mod_crisis WHERE a1='$id' GROUP BY a9");


        $content = '<div class="row" style="min-width:400px"><div class="col-md-12">
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr class="uppercase" style="font-weight:800">
                                                                        <th style="font-weight:800"> Category </th>
                                                                        <th style="font-weight:800"> No. Incidents</th>                                                                   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
        $colors = ['danger','success','info','warning'];
        while ($data = $sql->fetch_assoc())
        {

            $content .='<tr>    <td class="highlight"> <div class="'.$colors[rand(0,3)].'"></div> &nbsp; <b> '.ucwords(strtolower($data['a9'])).' </b> </td>
                                <td>'.$data['tot'].'</td>
                             
                            </tr>';
        }

        $content .='</table></div></div>';




        echo $content;
    }


    public static function plotOutbreaksHeatMap() {
        echo'
  <script type="text/javascript">         
//Plot outbreaks and crises with colors
$("#map").mapSvg({
    source: "'.ROOT.'/includes/theme/maps/geo-calibrated/uganda.svg",
    responsive: 1,
    zoom: {on:1},
    scroll: {on:1},
	colors: {
        baseDefault: "#5c5cff",
        background: "rgba(238,238,238,0)",
        disabled: "#d10a00",
        selected: 30,
        hover: 18,
        base: "#5c5cff",
        stroke: "#ffffff"
    },
    
    gauge: {
                    colors: {low: "#bd2200",high: "#ffe3c1"}
             },
    tooltips: {mode: function(){
                     return (this.title ? " "+this.title : " ")+" District ";
                }, on: true, priority: "local"},
	popovers: {mode: function(){
        return (this.title ? "<h4> <b>"+this.title : "  ")+" District </b></h4> " + districtOubreaksDetails(this.id) + "<h5>Total Incidents: <b> "+countAllDistrictOutbreaks(this.id) +" </h5></b>" ;
    }, on: true, priority: "local"},
	afterLoad: function(){
		
		 var regions = this.getData().regions;
        regions.forEach(function(region){        
         
         '.outbreak::prepMapSwitchOutbreaks().'
         
        });
         
    }
});
  </script>         
	';
    }



    // Function to calculate total incidents per district
    public static function countAllDistrictOutbreaks()
    {
        $id = str_replace('UG-', '', $_REQUEST['id']);

        $sql = database::performQuery("
           SELECT COUNT(*) as outbreaks
            FROM district,mod_crisis
            WHERE district.name=mod_crisis.a1
                AND district.map_id = $id
              AND DATE(a8) BETWEEN '$_SESSION[outbreak_datefrom]' AND '$_SESSION[outbreak_dateto]'
            
             ");

        while ($data = $sql->fetch_assoc())
            echo $data['outbreaks'];
    }

}

?>