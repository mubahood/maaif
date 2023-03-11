<?php

class reportZonal
{

    public static function getAllZonesList(){

        $sql = database::performQuery("SELECT * FROM zone ORDER BY name ASC");
        $content = '';
        while($data = $sql->fetch_assoc()){

            $content .='<option value="'.$data['id'].'">'.strtoupper(strtolower($data['name'])).' ZARDI';
        }

        return $content;
    }

    public static function getZonalName($id){

        $sql = database::performQuery("SELECT name FROM zone WHERE id=$id");
        $ret = $sql->fetch_assoc();

        return $ret['name'];
    }


    public static function getZoneDetailsbyId($id){

       $sql = database::performQuery("SELECT * FROM zone WHERE id=$id");
       return ucwords(strtolower($sql->fetch_assoc()['name']));

   }

   public static function getZonaHead($id){

       $sql = database::performQuery("SELECT * FROM user,district,zone WHERE zone.id=$id AND user_category_id=51 AND district.zone_id = zone.id AND user.district_id = district.id");
       if($sql->num_rows> 0){
       return $sql->fetch_assoc();
       }
       else
       {
        return ['first_name'=>'Not Available','last_name'=>'Not Available','phone'=>'Not Available',];
       }

   }




   public static function countZoneDistrict($id){

       $sql = database::performQuery("SELECT * FROM district,zone WHERE zone.id=$id AND district.zone_id = zone.id ");
       return $sql->num_rows;

   }


    public static function countZoneExtensionStaff($id, $ids){

        $sql = database::performQuery("SELECT * FROM user,district,zone WHERE district.zone_id=$id AND user_category_id IN ($ids) AND district.zone_id = zone.id AND user.district_id = district.id");
        return $sql->num_rows;

    }



    public static function getActivtiesZoneSector($id, $ids){

       $content = '';
        $sql = database::performQuery("SELECT ext_activitys.name,COUNT(*) as total FROM user,ext_activitys,ext_area_daily_activity,zone,district
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                              AND ext_area_daily_activity.quarterly_activity_id =  ext_activitys.id  
                                                AND district.zone_id = zone.id 
                                                AND user.district_id = district.id
                                                AND  user_category_id IN ($ids)
                                                AND district.zone_id=$id
                                                 AND ext_activitys.id NOT LIKE 52
                                                 AND ext_area_daily_activity.quarterly_activity_id NOT LIKE  ''
                                                 AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                 GROUP BY quarterly_activity_id
                                                 ORDER BY total DESC");

        $content .='<table class="table table-striped table-condensed" style="width:100%">                     
                     <tr>
                     <th>No.</th>
                     <th>Activity Name</th>
                     <th>Total</th>
                     </tr>
                     <tbody>';

        if($sql->num_rows){
            $x=1;
            while ($data=$sql->fetch_assoc()){

                $content .='
                     <tr>
                     <td>'.$x.'</td>
                     <td>'.$data['name'].'</td>
                     <td>'.$data['total'].'</td>
                     </tr>';
             $x++;
            }

        }
        else{

            $content .='
                     <tr>
                     <td>None</td>
                     <td>None</td>
                     <td>None</td>
                     </tr>';

        }
        $content .= '</tbody></table>';
        return $content;

    }

    public static function getTopicsZoneSector($id, $ids){

        $content = '';
        $sql = database::performQuery("SELECT ext_topics.name,COUNT(*) as total FROM user,ext_topics,ext_area_daily_activity,zone,district 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                              AND ext_area_daily_activity.topic =  ext_topics.id    
                                                AND district.zone_id = zone.id 
                                                AND user.district_id = district.id
                                                AND  user_category_id IN ($ids)
                                                AND district.zone_id=$id
                                                 AND ext_topics.id NOT LIKE 119
                                                 AND ext_area_daily_activity.topic NOT LIKE ''
                                                 AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                 GROUP BY topic
                                                 ORDER BY total DESC");

        $content .='<table class="table table-striped table-condensed" style="width:100%">                     
                     <tr>
                     <th>No.</th>
                     <th>Topic Name</th>
                     <th>Total</th>
                     </tr>
                     <tbody>';

        if($sql->num_rows){
            $x=1;
            while ($data=$sql->fetch_assoc()){

                $content .='
                     <tr>
                     <td>'.$x.'</td>
                     <td>'.$data['name'].'</td>
                     <td>'.$data['total'].'</td>
                     </tr>';
                $x++;
            }

        }
        else{

            $content .='
                     <tr>
                     <td>None</td>
                     <td>None</td>
                     <td>None</td>
                     </tr>';

        }
        $content .= '</tbody></table>';
        return $content;

    }

    public static function getEntreprizesZoneSector($id, $ids){

        $content = '';
        $sql = database::performQuery("SELECT km_category.name,COUNT(*) as total FROM user,km_category,ext_area_daily_activity,district,zone 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                              AND ext_area_daily_activity.entreprise =  km_category.id                                                
                                               AND district.zone_id = zone.id 
                                                AND user.district_id = district.id
                                                AND  user_category_id IN ($ids)
                                                AND district.zone_id=$id
                                                 AND km_category.id NOT LIKE 198
                                                 AND `ext_area_daily_activity`.`entreprise` NOT LIKE ''
                                                  AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                 GROUP BY entreprise
                                                 ORDER BY total DESC");

        $content .='<table class="table table-striped table-condensed" style="width:100%">                     
                     <tr>
                     <th>No.</th>
                     <th>Entreprize Name</th>
                     <th>Total</th>
                     </tr>
                     <tbody>';

        if($sql->num_rows){
            $x=1;
            while ($data=$sql->fetch_assoc()){

                $content .='
                     <tr>
                     <td>'.$x.'</td>
                     <td>'.$data['name'].'</td>
                     <td>'.$data['total'].'</td>
                     </tr>';
                $x++;
            }

        }
        else{

            $content .='
                     <tr>
                     <td>None</td>
                     <td>None</td>
                     <td>None</td>
                     </tr>';

        }
        $content .= '</tbody></table>';
        return $content;

    }

    public static function getTop10LLGZoneSector($id, $ids, $order){

       $ord = '';
        if($order==1){
            $ord = 'total DESC';
        }
        else if($order==2){
            $ord = 'total ASC';
        }

        $content = '';
        $sql = database::performQuery("SELECT user.id,first_name,last_name,COUNT(*) as total,district.name as district FROM user,district,zone,ext_area_daily_activity 
                                               WHERE district.zone_id = zone.id 
                                                AND user.district_id = district.id
                                                AND user.id =  ext_area_daily_activity.user_id
                                                AND  user_category_id IN ($ids)
                                                AND district.zone_id=$id
                                                AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                 GROUP BY user.id
                                                 ORDER BY $ord
                                                 LIMIT 10");

        $content .='<table class="table table-striped table-condensed" style="width:100%">                     
                     <tr>
                     <th>No.</th>
                     <th>LLG Name / <br /><small>District</small></th>
                     <th>Total</th>
                     </tr>
                     <tbody>';

        if($sql->num_rows){
            $x=1;
            while ($data=$sql->fetch_assoc()){

                $content .='
                     <tr>
                     <td>'.$x.'</td>
                     <td>'.$data['first_name'].' '.$data['last_name'].' <br /> <small>'.$data['district'].'</small></td>
                     <td>'.$data['total'].'</td>
                     </tr>';
                $x++;
            }

        }
        else{

            $content .='
                     <tr>
                     <td>None</td>
                     <td>None</td>
                     <td>None</td>
                     </tr>';

        }
        $content .= '</tbody></table>';
        return $content;

    }

    public static function getBeneFiciariesZoneSector($id, $ids){


        $content = '';
        $sql = database::performQuery("SELECT SUM(num_ben_males) as total FROM user,ext_area_daily_activity,district,zone 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                               AND district.zone_id = zone.id 
                                                AND user.district_id = district.id
                                                AND  user_category_id IN ($ids)
                                               AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                AND district.zone_id=$id
                                                 ");

        $content .='<table class="table table-striped table-condensed" style="width:100%">                     
                     <tr>
                     <th>No.</th>
                     <th>Beneficiary Type</th>
                     <th>Total Reached</th>
                     </tr>
                     <tbody>';

        if($sql->num_rows) {
            $x = 1;
            while ($data = $sql->fetch_assoc()) {

                $content .= '
                     <tr>
                     <td>' . $x . '</td>
                     <td>Males </td>
                     <td>' . number_format($data['total']) . '</td>
                     </tr>';

            }
        }




            $sqlb = database::performQuery("SELECT SUM(num_ben_females) as total FROM user,ext_area_daily_activity,district,zone 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                               AND district.zone_id = zone.id 
                                                AND user.district_id = district.id
                                                AND  user_category_id IN ($ids)
                                               AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                AND district.zone_id=$id
                                                 ");

        if($sqlb->num_rows) {
            $x = 2;
            while ($datab = $sqlb->fetch_assoc()) {

                $content .= '
                     <tr>
                     <td>' . $x . '</td>
                     <td>Females </td>
                     <td>' . number_format($datab['total']) . '</td>
                     </tr>';

            }
        }



        $sqlc = database::performQuery("SELECT SUM(num_ben_total) as total FROM user,ext_area_daily_activity,district,zone 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                               AND district.zone_id = zone.id 
                                                AND user.district_id = district.id
                                                AND  user_category_id IN ($ids)
                                               AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                AND district.zone_id=$id
                                                 ");

        if($sqlc->num_rows) {
            $x = 3;
            while ($datac = $sqlc->fetch_assoc()) {

                $content .= '
                     <tr>
                     <td>' . $x . '</td>
                     <td>Total Beneficiaries  </td>
                     <td>' . number_format($datac['total']) . '</td>
                     </tr>';

            }
        }




        $content .= '</tbody></table>';
        return $content;

    }


    public static function getLocationsZoneSector($id, $ids){

        $content = '';
        $sql = database::performQuery("SELECT district.name as district,subcounty.name as subcounty,COUNT(*) as total FROM user,ext_area_daily_activity,district,county,subcounty,parish,village,zone 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                              AND ext_area_daily_activity.village_id =  village.id     
                                              AND district.zone_id = zone.id 
                                                 AND user.district_id = district.id
                                                 AND  user_category_id IN ($ids)
                                                 AND district.zone_id=$id
                                                 AND district.id= county.district_id
                                                 AND ext_area_daily_activity.village_id NOT LIKE ''
                                                 AND county.id = subcounty.county_id
                                                 AND subcounty.id = parish.subcounty_id
                                                 AND parish.id = village.parish_id   
                                                 AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                 GROUP BY district.id
                                                 ORDER BY total DESC");

        $content .='<table class="table table-striped table-condensed" style="width:100%">                     
                     <tr>
                     <th>No.</th>
                     <th>District Name</th>
                     <th>Total</th>
                     </tr>
                     <tbody>';

        if($sql->num_rows){
            $x=1;
            while ($data=$sql->fetch_assoc()){

                $content .='
                     <tr>
                     <td>'.$x.'</td>
                     <td>'.$data['district'].'</td>
                     <td>'.$data['total'].'</td>
                     </tr>';
                $x++;
            }

        }
        else{

            $content .='
                     <tr>
                     <td>None</td>
                     <td>None</td>
                     <td>None</td>
                     </tr>';

        }
        $content .= '</tbody></table>';
        return $content;

    }



    public static function getOutbreaksDistrictSector($id){

        $district = self::getZoneDetailsbyId($_REQUEST['id']);

        $content = '';
        $sql = database::performQuery("SELECT a9,COUNT(*) as total FROM mod_crisis,district,zone 
                                            WHERE a1 LIKE '%$district%' 
                                              AND district.zone_id = zone.id 
                                                AND district.name = mod_crisis.a1
                                                AND zone_id=$id
                                               AND DATE(a18) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                               GROUP BY a9
                                                 ORDER BY a9 ASC");

        $content .='<table class="table table-striped table-condensed" style="width:100%">                     
                     <tr>
                     <th>No.</th>
                     <th>Event Type</th>
                     <th>Total</th>
                     </tr>
                     <tbody>';

        if($sql->num_rows){
            $x=1;
            while ($data=$sql->fetch_assoc()){

                $content .='
                     <tr>
                     <td>'.$x.'</td>
                     <td>'.$data['a9'].'</td>
                     <td>'.$data['total'].'</td>
                     </tr>';
                $x++;
            }

        }
        else{

            $content .='
                     <tr>
                     <td>None</td>
                     <td>None</td>
                     <td>None</td>
                     </tr>';

        }
        $content .= '</tbody></table>';
        return $content;

    }


//    public static function getGrievancesDistrict(){
//
//        $district = self::getZoneDetailsbyId($_REQUEST['id']);
//
//        $content = '';
//        $sql = database::performQuery("SELECT grm_db.subcounty.name as subcounty,COUNT(*) as total FROM grm_db.grivance,grm_db.district,grm_db.county,grm_db.subcounty,grm_db.parish
//WHERE district.id = county.district_id
//AND county.id = subcounty.county_id
//AND subcounty.id = parish.subcounty_id
//AND parish.id = grivance.parish_id
//AND district.id =7
//GROUP BY subcounty.id
//ORDER BY subcounty.name ASC");
//
//        $content .='<table class="table table-striped table-condensed" style="width:100%">
//                     <tr>
//                     <th>No.</th>
//                     <th>Subcounty</th>
//                     <th>Total Grievances</th>
//                     </tr>
//                     <tbody>';
//
//        if($sql->num_rows){
//            $x=1;
//            while ($data=$sql->fetch_assoc()){
//
//                $content .='
//                     <tr>
//                     <td>'.$x.'</td>
//                     <td>'.$data['subcounty'].'</td>
//                     <td>'.$data['total'].'</td>
//                     </tr>';
//                $x++;
//            }
//
//        }
//        else{
//
//            $content .='
//                     <tr>
//                     <td>None</td>
//                     <td>None</td>
//                     <td>None</td>
//                     </tr>';
//
//        }
//        $content .= '</tbody></table>';
//        return $content;
//
//    }



    public static function plotDistrictLocations($id){

        $sql = database::performQuery("SELECT ext_area_daily_activity.id,gps_longitude,gps_latitude 
                                            FROM user,ext_area_daily_activity,district,zone 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                                AND gps_latitude != ''                                              
                                                AND district.zone_id = zone.id 
                                                AND user.district_id = district.id 
                                                AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                 AND district.zone_id=$id
                                                ");
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


    public static function plotDistrictEOMarkers($id){

        $sql = database::performQuery("SELECT ext_area_daily_activity.id,gps_longitude,gps_latitude 
                                            FROM user,ext_area_daily_activity,district,zone 
                                            WHERE user.id =  ext_area_daily_activity.user_id 
                                                AND gps_latitude != ''                                              
                                                 AND district.zone_id = zone.id 
                                                  AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                                                AND user.district_id = district.id
                                                AND district.zone_id=$id");
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

    public static function plotDistrictActivityMap($id){
       return '<div id="mapdiv"  style="width: 500px; height: 500px;"></div>
  <script src="https://www.openlayers.org/api/OpenLayers.js"></script>
  <script type="text/javascript">
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());

    var centerUG = new OpenLayers.LonLat( 32.583333 ,0.316667 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
          
  
     '.self::plotDistrictLocations($id).'
          
    var zoom=7;

    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
    
    '.self::plotDistrictEOMarkers($id).'
    
    map.setCenter (centerUG, zoom);
  </script>';
    }




    public static function generateZonalReport(){

       $content = '
<div class="col-sm-12 col-md-12 col-lg-12">

'.report::reportDateFilter().'   
<table class="table table-condensed">
    <tbody>
        <tr>
            <td colspan="3" style="width: 350.6pt;border: 1px solid windowtext;padding: 20px;height: auto;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>'.self::getZoneDetailsbyId($_REQUEST['id']).' ZARDI Cummulative Report  
 for the period between '.$_SESSION['date_from'].' and '.$_SESSION['date_to'].' </h5></p>
            </td>
            <td style="width: 116.9pt;border-top: 1px solid windowtext;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-image: initial;border-left: none;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><button type="button" onclick="window.print()" class="btn waves-effect waves-light btn-rounded btn-sm btn-success">Print Report</button></p>
            </td>
        </tr>
        <tr>
            <td style="width: 116.85pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 35.05pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>ZARDI:</h5> '.self::getZoneDetailsbyId($_REQUEST['id']).'</p>
            </td>
            <td style="width: 116.85pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 35.05pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>No. Districts :</h5> '.self::countZoneDistrict($_REQUEST['id']).' </p>
            </td>
            <td style="width: 116.9pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 35.05pt;vertical-align: top;" colspan="2">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h6>Zonal Coordinator :</h6> '.self::getZonaHead($_REQUEST['id'])['first_name'].'  '.self::getZonaHead($_REQUEST['id'])['last_name'].' ( '.self::getZonaHead($_REQUEST['id'])['phone'].')</p>
            </td>
           
        </tr>
        <tr>
            <td style="width: 116.85pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 40.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>No. Extension Staff (Crop) :</h5> '.self::countZoneExtensionStaff($_REQUEST['id'],'2,8,19,22,26').'</p>
            </td>
            <td style="width: 116.85pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 40.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>No. Extension Staff (Livestock) :</h5>  '.self::countZoneExtensionStaff($_REQUEST['id'],'3,9,20,23,27,30').'</p>
            </td>
            <td style="width: 116.9pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 40.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>No. Extension Staff (Fish) :</h5>  '.self::countZoneExtensionStaff($_REQUEST['id'],'4,7,21,28').'</p>
            </td>
            <td style="width: 116.9pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 40.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>No. Extension Staff (Entomology): </h5>  '.self::countZoneExtensionStaff($_REQUEST['id'],'12,13,29').'</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 35.5pt;vertical-align: top;">
                <h4>Summary of Activities Covered by Sector</h4>
                              
                
                
 <ul class="nav nav-pills m-t-30 m-b-30">
    <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Crop Sector</a> </li>
    <li class="nav-item"> <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Livestock Sector</a> </li>
    <li class="nav-item"> <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="true">Fish Sector</a> </li>
    <li class="nav-item"> <a href="#navpills-4" class="nav-link" data-toggle="tab" aria-expanded="true">Entomology Sector</a> </li>
</ul>
<div class="tab-content br-n pn">
<div id="navpills-1" class="tab-pane active">
        <div class="row">
            <div class="col-md-12">'.self::getActivtiesZoneSector($_REQUEST['id'],'2,8,19,22,26').'</div>
        </div>
    </div>
<div id="navpills-2" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getActivtiesZoneSector($_REQUEST['id'],'3,9,20,23,27,30').'</div>
        </div>
    </div>
<div id="navpills-3" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getActivtiesZoneSector($_REQUEST['id'],'4,7,21,28').'</div>
        </div>
    </div>
    <div id="navpills-4" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getActivtiesZoneSector($_REQUEST['id'],'12,13,29').'</div>
        </div>
    </div>
</div>


                
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 35.5pt;vertical-align: top;">
                <h4>Summary of Topics Covered by Sector</h4>
                                 
 <ul class="nav nav-pills m-t-30 m-b-30">
    <li class=" nav-item"> <a href="#topics-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Crop Sector</a> </li>
    <li class="nav-item"> <a href="#topics-2" class="nav-link" data-toggle="tab" aria-expanded="false">Livestock Sector</a> </li>
    <li class="nav-item"> <a href="#topics-3" class="nav-link" data-toggle="tab" aria-expanded="true">Fish Sector</a> </li>
    <li class="nav-item"> <a href="#topics-4" class="nav-link" data-toggle="tab" aria-expanded="true">Entomology Sector</a> </li>
</ul>
<div class="tab-content br-n pn">
<div id="topics-1" class="tab-pane active">
        <div class="row">
            <div class="col-md-12">'.self::getTopicsZoneSector($_REQUEST['id'],'2,8,19,22,26').'</div>
        </div>
    </div>
<div id="topics-2" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTopicsZoneSector($_REQUEST['id'],'3,9,20,23,27,30').'</div>
        </div>
    </div>
<div id="topics-3" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTopicsZoneSector($_REQUEST['id'],'4,7,21,28').'</div>
        </div>
    </div>
    <div id="topics-4" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTopicsZoneSector($_REQUEST['id'],'12,13,29').'</div>
        </div>
    </div>
</div>


                
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 40pt;vertical-align: top;">
                <h4>Summary of Enterprises Covered by Sector</h4>
                
                
                                                
 <ul class="nav nav-pills m-t-30 m-b-30">
    <li class=" nav-item"> <a href="#ent-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Crop Sector</a> </li>
    <li class="nav-item"> <a href="#ent-2" class="nav-link" data-toggle="tab" aria-expanded="false">Livestock Sector</a> </li>
    <li class="nav-item"> <a href="#ent-3" class="nav-link" data-toggle="tab" aria-expanded="true">Fish Sector</a> </li>
    <li class="nav-item"> <a href="#ent-4" class="nav-link" data-toggle="tab" aria-expanded="true">Entomology Sector</a> </li>
</ul>
<div class="tab-content br-n pn">
<div id="ent-1" class="tab-pane active">
        <div class="row">
            <div class="col-md-12">'.self::getEntreprizesZoneSector($_REQUEST['id'],'2,8,19,22,26').'</div>
        </div>
    </div>
<div id="ent-2" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getEntreprizesZoneSector($_REQUEST['id'],'3,9,20,23,27,30').'</div>
        </div>
    </div>
<div id="ent-3" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getEntreprizesZoneSector($_REQUEST['id'],'4,7,21,28').'</div>
        </div>
    </div>
    <div id="ent-4" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getEntreprizesZoneSector($_REQUEST['id'],'12,13,29').'</div>
        </div>
    </div>
</div>



                
                
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 40pt;vertical-align: top;">
                <h4>Summary of Beneficiaries Reached</h4>
                
                          
                                                
 <ul class="nav nav-pills m-t-30 m-b-30">
    <li class=" nav-item"> <a href="#ben-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Crop Sector</a> </li>
    <li class="nav-item"> <a href="#ben-2" class="nav-link" data-toggle="tab" aria-expanded="false">Livestock Sector</a> </li>
    <li class="nav-item"> <a href="#ben-3" class="nav-link" data-toggle="tab" aria-expanded="true">Fish Sector</a> </li>
    <li class="nav-item"> <a href="#ben-4" class="nav-link" data-toggle="tab" aria-expanded="true">Entomology Sector</a> </li>
</ul>
<div class="tab-content br-n pn">
<div id="ben-1" class="tab-pane active">
        <div class="row">
            <div class="col-md-12">'.self::getBeneFiciariesZoneSector($_REQUEST['id'],'2,8,19,22,26').'</div>
        </div>
    </div>
<div id="ben-2" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getBeneFiciariesZoneSector($_REQUEST['id'],'3,9,20,23,27,30').'</div>
        </div>
    </div>
<div id="ben-3" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getBeneFiciariesZoneSector($_REQUEST['id'],'4,7,21,28').'</div>
        </div>
    </div>
    <div id="ben-4" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getBeneFiciariesZoneSector($_REQUEST['id'],'12,13,29').'</div>
        </div>
    </div>
</div>


                
                
            </td>
            
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 39.55pt;vertical-align: top;">
                <h4>Summary of Locations District/Subcounty Visited</h4>
                
                                     
                                                
 <ul class="nav nav-pills m-t-30 m-b-30">
    <li class=" nav-item"> <a href="#loc-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Crop Sector</a> </li>
    <li class="nav-item"> <a href="#loc-2" class="nav-link" data-toggle="tab" aria-expanded="false">Livestock Sector</a> </li>
    <li class="nav-item"> <a href="#loc-3" class="nav-link" data-toggle="tab" aria-expanded="true">Fish Sector</a> </li>
    <li class="nav-item"> <a href="#loc-4" class="nav-link" data-toggle="tab" aria-expanded="true">Entomology Sector</a> </li>
</ul>
<div class="tab-content br-n pn">
<div id="loc-1" class="tab-pane active">
        <div class="row">
            <div class="col-md-12">'.self::getLocationsZoneSector($_REQUEST['id'],'2,8,19,22,26').'</div>
        </div>
    </div>
<div id="loc-2" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getLocationsZoneSector($_REQUEST['id'],'3,9,20,23,27,30').'</div>
        </div>
    </div>
<div id="loc-3" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getLocationsZoneSector($_REQUEST['id'],'4,7,21,28').'</div>
        </div>
    </div>
    <div id="loc-4" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getLocationsZoneSector($_REQUEST['id'],'12,13,29').'</div>
        </div>
    </div>
</div>

                
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 39.55pt;vertical-align: top;">
                <h4>Activity Map showing Activity Location</h4>
                
                 '.self::plotDistrictActivityMap($_REQUEST['id']).'
                
                  
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 44.95pt;vertical-align: top;">
                <h4>Top 10 Performing LLG  Staff by number of Activities Carried out by sector</h4>
                
                
                <ul class="nav nav-pills m-t-30 m-b-30">
    <li class=" nav-item"> <a href="#tllg-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Crop Sector</a> </li>
    <li class="nav-item"> <a href="#tllg-2" class="nav-link" data-toggle="tab" aria-expanded="false">Livestock Sector</a> </li>
    <li class="nav-item"> <a href="#tllg-3" class="nav-link" data-toggle="tab" aria-expanded="true">Fish Sector</a> </li>
    <li class="nav-item"> <a href="#tllg-4" class="nav-link" data-toggle="tab" aria-expanded="true">Entomology Sector</a> </li>
</ul>
<div class="tab-content br-n pn">
<div id="tllg-1" class="tab-pane active">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'2,8,19,22,26',1).'</div>
        </div>
    </div>
<div id="tllg-2" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'3,9,20,23,27,30',1).'</div>
        </div>
    </div>
<div id="tllg-3" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'4,7,21,28',1).'</div>
        </div>
    </div>
    <div id="tllg-4" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'12,13,29',1).'</div>
        </div>
    </div>
</div>

                
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 44.95pt;vertical-align: top;">
                <h4>Worst 10 Performing LLG Staff by number of Activities Carried out by sector</h4>
                
                  
                <ul class="nav nav-pills m-t-30 m-b-30">
    <li class=" nav-item"> <a href="#wllg-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Crop Sector</a> </li>
    <li class="nav-item"> <a href="#wllg-2" class="nav-link" data-toggle="tab" aria-expanded="false">Livestock Sector</a> </li>
    <li class="nav-item"> <a href="#wllg-3" class="nav-link" data-toggle="tab" aria-expanded="true">Fish Sector</a> </li>
    <li class="nav-item"> <a href="#wllg-4" class="nav-link" data-toggle="tab" aria-expanded="true">Entomology Sector</a> </li>
</ul>
<div class="tab-content br-n pn">
<div id="wllg-1" class="tab-pane active">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'2,8,19,22,26',2).'</div>
        </div>
    </div>
<div id="wllg-2" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'3,9,20,23,27,30',2).'</div>
        </div>
    </div>
<div id="wllg-3" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'4,7,21,28',2).'</div>
        </div>
    </div>
    <div id="wllg-4" class="tab-pane">
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($_REQUEST['id'],'12,13,29',2).'</div>
        </div>
    </div>
</div>
            </td>
        </tr>
       
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <h4>No. of Grievances Reported by Subcounty</h4>
                
                
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <h4>No. of &nbsp;Crises/Outbreaks Reported by Subcounty</h4>
                '.self::getOutbreaksDistrictSector($_REQUEST['id']).'
            </td>
        </tr>
        <!--<tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>No. of Farmer Questions Replied to and Pending by District/Subcounty</p>
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>No. of Profiles Submitted by District/Subcounty i.e Farmers, Farmer Groups, State &amp; Non State Actors e.t.c</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DPMO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by CAO</p>
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DAO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DVO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DFO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DEO</p>
            </td>
        </tr>-->
        <tr>
            <td colspan="4" style="width: 467.5pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <h4>Gallery of Photos </h4>
                '.self::getLatestEOPhotos($_REQUEST['id']).'
            </td>
        </tr>
    </tbody>
</table>
<p style=\'margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;\'>&nbsp;</p></div>';

       return $content;

   }


    public static function generateZonalSectorReport(){

       $zone_id = $_REQUEST['zone_id'];
       $sector =  $_REQUEST['sector'];
       switch($sector){
           case 1:
             $sector_use = '2,8,19,22,26';
               break;
           case 2:
               $sector_use = '3,9,20,23,27,30';
               break;
           case 3:
               $sector_use = '4,7,21,28';
               break;
           case 4:
               $sector_use = '12,13,29';
               break;

           default:
               $sector_use = '2,8,19,22,26';
               break;
       }

       $content = '<div class="col-sm-12 col-md-12 col-lg-12">

'.report::reportDateFilter().'   
<table class="table table-condensed">
    <tbody>
        <tr>
            <td colspan="3" style="width: 350.6pt;border: 1px solid windowtext;padding: 20px;height: auto;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>'.self::getZoneDetailsbyId($zone_id).' ZARDI Sector Report  
 for the period between '.$_SESSION['date_from'].' and '.$_SESSION['date_to'].' </h5></p>
            </td>
            <td style="width: 116.9pt;border-top: 1px solid windowtext;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-image: initial;border-left: none;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><button type="button" onclick="window.print()" class="btn waves-effect waves-light btn-rounded btn-sm btn-success">Print Report</button></p>
            </td>
        </tr>
        <tr>
            <td style="width: 116.85pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 35.05pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>ZARDI:</h5> '.self::getZoneDetailsbyId($zone_id).'</p>
            </td>
            <td style="width: 116.85pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 35.05pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>No. Sub-Counties :</h5> '.self::countZoneDistrict($zone_id).' </p>
            </td>
            <td style="width: 116.9pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 35.05pt;vertical-align: top;" colspan="2">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h6>Zonal Coordinator :</h6> '.self::getZonaHead($zone_id)['first_name'].'  '.self::getZonaHead($zone_id)['last_name'].' ( '.self::getZonaHead($zone_id)['phone'].')</p>
 
            </td>
           
        </tr>
        <tr>
            <td style="width: 116.85pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 40.45pt;vertical-align: top;" colspan="4">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'><h5>No. Extension Sector Staff :</h5> '.self::countZoneExtensionStaff($zone_id,$sector_use).'</p>
            </td>
            
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 35.5pt;vertical-align: top;">
                <h4>Summary of Activities Covered by Sector</h4>
              <div class="row">
              <div class="col-md-12">'.self::getActivtiesZoneSector($zone_id,$sector_use).'</div>
              </div>      
 

                
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 35.5pt;vertical-align: top;">
                <h4>Summary of Topics Covered by Sector</h4>
                
                <div class="row">
            <div class="col-md-12">'.self::getTopicsZoneSector($zone_id,$sector_use).'</div>
        </div>

               
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 40pt;vertical-align: top;">
                <h4>Summary of Enterprises Covered by Sector</h4>
    
        <div class="row">
            <div class="col-md-12">'.self::getEntreprizesZoneSector($zone_id,$sector_use).'</div>
        </div>
   
     
                
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 40pt;vertical-align: top;">
                <h4>Summary of Beneficiaries Reached</h4>
                
            <div class="row">
            <div class="col-md-12">'.self::getBeneFiciariesZoneSector($zone_id,$sector_use).'</div>
         
                
            </td>
            
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 39.55pt;vertical-align: top;">
                <h4>Summary of Locations District/Subcounty Visited</h4>
                
                                     
        <div class="row">
            <div class="col-md-12">'.self::getLocationsZoneSector($zone_id,$sector_use).'</div>
        </div>
   
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 39.55pt;vertical-align: top;">
                <h4>Activity Map showing Activity Location</h4>
                
                 '.self::plotDistrictActivityMap($zone_id).'
                
                  
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 44.95pt;vertical-align: top;">
                <h4>Top 10 Performing LLG  Staff by number of Activities Carried out by sector</h4>
                
                
        <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($zone_id,$sector_use,1).'</div>
        </div>
          </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 44.95pt;vertical-align: top;">
                <h4>Worst 10 Performing LLG Staff by number of Activities Carried out by sector</h4>
         <div class="row">
            <div class="col-md-12">'.self::getTop10LLGZoneSector($zone_id,$sector_use,2).'</div>
        </div>
           </td>
        </tr>
       
      
        <!--<tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>No. of Farmer Questions Replied to and Pending by District/Subcounty</p>
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>No. of Profiles Submitted by District/Subcounty i.e Farmers, Farmer Groups, State &amp; Non State Actors e.t.c</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 233.7pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DPMO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by CAO</p>
            </td>
            <td colspan="2" style="width: 233.8pt;border-top: none;border-left: none;border-bottom: 1px solid windowtext;border-right: 1px solid windowtext;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DAO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DVO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DFO</p>
                <p style=\'margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;\'>Remarks by DEO</p>
            </td>
        </tr>-->
        <tr>
            <td colspan="4" style="width: 467.5pt;border-right: 1px solid windowtext;border-bottom: 1px solid windowtext;border-left: 1px solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 67.45pt;vertical-align: top;">
                <h4>Gallery of Photos </h4>
                '.self::getLatestEOPhotos($_REQUEST['zone_id']).'
            </td>
        </tr>
    </tbody>
</table>
<p style=\'margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;\'>&nbsp;</p></div>';

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



    public static function getLatestEOPhotos($id){

        $sql = database::performQuery("SELECT url,activity_id,ext_area_daily_activity.id FROM user,ext_area_daily_activity_image,ext_area_daily_activity,district,zone 
                                               WHERE ext_area_daily_activity.id = ext_area_daily_activity_image.activity_id
                                               AND district.zone_id = $id 
                                                 AND district.zone_id = zone.id 
                                                 AND user.district_id = district.id
                                               AND user.id = ext_area_daily_activity.user_id
                                               ORDER BY RAND()
                                                LIMIT 0,20");
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




}