<?php
//include('../../weather_constants.php');

class weather
{
public static function getAllWeatherDistrictsList(){

$sql = database::performQuery("SELECT * FROM weather_parish GROUP BY District");
$content = '';
while($data = $sql->fetch_assoc()){

$content .='<option value="'.$data['District'].'">'.strtoupper(strtolower($data['District'])).'</option>';
}

return $content;
}



public static function getSubcountyByDistrict($district){


$sql= database::performQuery("SELECT id,Subcounty FROM weather_parish WHERE District LIKE '$district' GROUP BY Subcounty");
$sub_reg_arr = array();
$sub_reg_arr[] = array("id" => 0, "name" => 'Select Sub-County / Division');

while($data=$sql->fetch_assoc()){

$sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['Subcounty']));

}

// encoding array to json format
echo json_encode($sub_reg_arr);
}

public static function getParishBySubcounty($district,$subcounty){


$sql= database::performQuery("SELECT id,Parish FROM weather_parish WHERE District LIKE '$district' AND Subcounty LIKE '$subcounty'");
//  echo "SELECT id,Parish FROM weather_parish WHERE District LIKE '$district' AND Subcounty LIKE '$subcounty'<br /><br />";
$sub_reg_arr = array();
$sub_reg_arr[] = array("id" => 0, "name" => 'Select Parish / Town');
while($data=$sql->fetch_assoc()){

$sub_reg_arr[] = array("id" => $data['id'], "name" => strtoupper($data['Parish']));

}



// encoding array to json format
echo json_encode($sub_reg_arr);
}

public static function returnWeatherDataFromDatabase($parish_id,$no_of_days=14){
    $date_today = makeMySQLDate();
    $date_last = date("Y-m-d",strtotime("+$no_of_days day", strtotime($date_today)));
    $sql = database::performQuery("SELECT * FROM weather_infomation WHERE parish_id=$parish_id AND forecast_date BETWEEN '$date_today' AND '$date_last'");
    
    $content = '';
    if($sql->num_rows > 0){

            $dates = [];
            $tempmin = [];
            $tempmax = [];
            $amount = [];
            $chance = [];

$content .= '<!--begin::Row-->
            <div class="row">';

            while($data=$sql->fetch_assoc())
            {
                $dates[] = "'$data[forecast_date]'";
                $tempmin[] = $data['minimum_temperature'];
                $tempmax[]=$data['maximum_temperature'];
                $amount[]=$data['rainfall_amount'];
                $chance[]=$data['rainfall_chance'];

                $content .='<div class="col-md-2">
                                <div class="weatherbox">
                                    <div class="datebox">
                                        <span style="background-color:#f7c403; padding:4px 7px 4px 7px; border:2px solid #fff; border-radius:5px;">'.getWeekday($data['forecast_date']).' </span> <br>'.$data['forecast_date'] .' </div>
                                    <div class="wicon">
                                        <img src="'.$data['weather_icon'].'" width="79" height="57">
                                    </div>
                                    <div class="wconditinons">
                                        <b>'.$data['weather_description'].'</b><br>
                                        Min Temp: <b>'.$data['minimum_temperature'].'</b><br>
                                        Max Temp: <b>'.$data['maximum_temperature'].'</b><br>
                                        Rainfall Chance: <b>'.$data['rainfall_chance'].'</b>%<br>
                                        Rainfall Amount: <b>'.$data['rainfall_amount'].'</b>mm<br>
                                    </div>
                                </div>
                            </div>';


            } // end while

            $_SESSION['next7daysprecamount'] = implode(',',$amount);
            $_SESSION['next7daysprecchance'] = implode(',',$chance);
            $_SESSION['next7daystempmin'] = implode(',',$tempmin);
            $_SESSION['next7daystempmax'] = implode(',',$tempmax);
            $_SESSION['next7daysdates'] = implode(',',$dates);
        }
        return $content;
}

public static function returnWeatherDataFromApi($parish_id,$no_of_days=14){
     
    $sql = "select id,longitude,latitude from weather_parish where id=$parish_id limit 1";
    $res = database::performQuery($sql);
    
    if($res->num_rows > 0)
    {
        $parish = $res->fetch_assoc();
        
        $parish_latitude = $parish['latitude'];
        $parish_longitude = $parish['longitude'];
        
        $content = '';
        try 
        {     
           

            $result = self::getWeatherFromRapidApi($parish_latitude,$parish_longitude,$no_of_days);           
            $lists = $result['list'];
            $city = $result['city'];
            foreach($lists as $key)
            {
                $forecast_date = date('Y-m-d',$key['dt']);
                $sql_check = "select * from weather_infomation where parish_id=$parish_id and forecast_date='$forecast_date'";
                $already_added = database::performQuery($sql_check);
                $maximum_temperature = number_format($key['temp']['max'],1);
                $minimum_temperature = number_format($key['temp']['min'],1);
                $average_temperature = number_format((($maximum_temperature+$minimum_temperature)/2),1);
                $temperature_units = 'celcius';
                $rainfall_chance = number_format($key['pop'],1)*100;
                $rainfall_amount = $key['rain'] ?? 0;
                $rainfall_units = 'mm';
                $wind_average = number_format($key['speed'],1);
                $wind_units = "m/s";
                $wind_direction = $key['deg']." degrees";
                $wind_max = number_format($key['speed'],1);
                $wind_min = number_format($key['speed'],1);
                $cloud_cover = number_format($key['clouds'],1);
                $sunshine_level = number_format($key['humidity'],1);
                $soil_temperature = 0;
                $created_at = date('Y-m-d H:i:s');
                $weather_description = $key['weather'][0]['description'];
                $weather_icon = "http://openweathermap.org/img/w/" .$key['weather'][0]['icon']. ".png";
                
                $dates[] = "'$forecast_date'";
                $tempmin[] = $minimum_temperature;
                $tempmax[]=$maximum_temperature;
                $amount[]=$rainfall_amount;
                $chance[]=$rainfall_chance;

                $content .='<div class="col-md-2">
                                <div class="weatherbox">
                                    <div class="datebox">
                                        <span style="background-color:#f7c403; padding:4px 7px 4px 7px; border:2px solid #fff; border-radius:5px;">'.getWeekday($forecast_date).' </span> <br>'.$forecast_date .' </div>
                                    <div class="wicon">
                                        <img src="'.$weather_icon.'" width="79" height="57">
                                    </div>
                                    <div class="wconditinons">
                                        <b>'.$weather_description.'</b><br>
                                        Min Temp: <b>'.$minimum_temperature.'</b><br>
                                        Max Temp: <b>'.$maximum_temperature.'</b><br>
                                        Rainfall Chance: <b>'.$rainfall_chance.'</b>%<br>
                                        Rainfall Amount: <b>'.$rainfall_amount.'</b>mm<br>
                                    </div>
                                </div>
                            </div>';


            } // end foreach

            $_SESSION['next7daysprecamount'] = implode(',',$amount);
            $_SESSION['next7daysprecchance'] = implode(',',$chance);
            $_SESSION['next7daystempmin'] = implode(',',$tempmin);
            $_SESSION['next7daystempmax'] = implode(',',$tempmax);
            $_SESSION['next7daysdates'] = implode(',',$dates);
        
             return $content;

        }
        catch(\Exception $e)
        {
            $txt = date('Y-m-d H:i:s').':'.$e->getMessage();
            $myfile = file_put_contents('weather_api_error_logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
            
        }
    }
    
}




public static function getWeatherContent7Days(){

    $styles = '';

    $scripts = '

            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>

            <script type="text/javascript">

                  /*Next Seven Days Temperature */
                    Highcharts.chart(\'nextseventemp\', {
                        title: {
                            text: \'Temperature Forecast\'
                        },
                        subtitle: {
                            text:  \'' . $_SESSION['location_title'] . '\'
                        },
                        yAxis: {
                            title: {
                                text: \'Temp in Degrees\'
                            }
                        },
                        legend: {
                            layout: \'vertical\',
                            align: \'right\',
                            verticalAlign: \'middle\'
                        },
                       xAxis: {
                            categories: [' . $_SESSION['next7daysdates'] . ']
                        },
                        series: [{
                            name: \'Temperature Min\',
                            data: [' . $_SESSION['next7daystempmin'] . ']
                        },{
                            name: \'Temperature max\',
                            data: [' . $_SESSION['next7daystempmax'] . ']
                        }],

                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: \'horizontal\',
                                        align: \'center\',
                                        verticalAlign: \'bottom\'
                                    }
                                }
                            }]
                        }

                    });

                     /*Next Seven Days Forecast */
                    Highcharts.chart(\'nextsevenprec\', {
                        title: {
                            text: \'Precipitation Forecast\'
                        },
                        subtitle: {
                            text: \'' . $_SESSION['location_title'] . '\'
                        },
                        yAxis: {
                            title: {
                                text: \'Chance in %\'
                            }
                        },
                        legend: {
                            layout: \'vertical\',
                            align: \'right\',
                            verticalAlign: \'middle\'
                        },
                       xAxis: {
                             categories: [' . $_SESSION['next7daysdates'] . ']
                        },
                        series: [{
                            name: \'Precipitation Chances\',
                            data: [' . $_SESSION['next7daysprecchance'] . ']
                        },{
                            name: \'Precipitation Amount\',
                            data: [' . $_SESSION['next7daysprecamount'] . ']
                        }],

                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: \'horizontal\',
                                        align: \'center\',
                                        verticalAlign: \'bottom\'
                                    }
                                }
                            }]
                        }

                    }); 

                    </script>

                    <script>        
                         $(document).ready(function(){
                                
                                 $("#district").change(function(){
                                var id = $(this).val();

                                        $.ajax({
                                            url: \'' . ROOT . '/?action=getWeatherSubcountyByDistrict\',
                                            type: \'post\',
                                            data: {id},
                                            dataType: \'json\',
                                            success:function(response){
                                
                                                var len = response.length;
                                
                                                $("#subcounty").empty();
                                                $("#parish").empty();
                                                    for( var i = 0; i<len; i++){
                                                    var id = response[i][\'id\'];
                                                    var name = response[i][\'name\'];
                                                    
                                                    $("#subcounty").append("<option value=\'"+name+"\'>"+name+"</option>");
                                
                                                }
                                            }
                                        });
                                    });
                               
                                  
                                 $("#subcounty").change(function(){
                                var subcounty = $(this).val();
                                var e = document.getElementById("district");
                                var district = e.value;
                                        
                                        $.ajax({
                                            url: \'' . ROOT . '/?action=getWeatherParishBySubcounty\',
                                            type: \'post\',
                                            data: {\'district\':district,\'subcounty\':subcounty},
                                            dataType: \'json\',
                                            success:function(response){
                                
                                                var len = response.length;
                                
                                                $("#parish").empty();
                                                for( var i = 0; i<len; i++){
                                                    var id = response[i][\'id\'];
                                                    var name = response[i][\'name\'];
                                                    
                                                    $("#parish").append("<option value=\'"+id+"\'>"+name+"</option>");
                                
                                                }
                                            },
                                            error: function(jqxhr, status, exception) {
                                                alert(\'Exception:\', exception);
                                            }
                                        });
                                    });
                                 
                                 
                             });
                         
                         </script>';

$content = '
                <div class="container py-4">

                    <div class="row mb-2">
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <p class="mb-4"><strong>Get by Location</strong></p>
                                            <!-- form -->
                                                <form action="#" method="post">

                                                <div class="row"> 
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">District/City</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" id="district" name="district" required>
                                                            <option value="0" selected="selected">Select District</option>
                                                            '.self::getAllWeatherDistrictsList().'
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">Subcounty/Division</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" id="subcounty" name="subcounty_id" required>

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Parish/Town</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" id="parish" name="parish_id" required>

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Forecast Range</label>
                                                        <select class="form-control form-select text-3 h-auto py-2"  name="forecast_type" required>
                                                            <option value="1">Last 7 Days</option>
                                                            <option value="2" selected="selected">Next 7 Days</option>
                                                            <option value="3">Next 14 Days</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <input type="hidden" name="action" value="getWeatherAdvisory">
                                                        <input type="submit" value="Get Advisory" class="btn btn-primary btn-modern" style="margin-top: 1.9rem !important" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                ';

$content .= '<div class="container py-2">';

if(isset($_REQUEST['parish_id'])  && isset($_REQUEST['subcounty_id'])){

    $parish_id = $_REQUEST['parish_id'];
    $forecast_type =    $_REQUEST['forecast_type'];
    $days_to_forecast = 14;

    if($forecast_type == 2){
        $date_today = makeMySQLDate();
        $date_last = date("Y-m-d",strtotime("+6 day", strtotime($date_today)));
        $days_to_forecast = 7;
    }
    else  if($forecast_type == 1){
        $date_today = makeMySQLDate();
        $date_last = date("Y-m-d",strtotime("-1 day", strtotime($date_today)));
        $date_today = date("Y-m-d",strtotime("-7 day", strtotime($date_today)));
        //TODO fix before production
        $days_to_forecast = -7;
    }
    else  if($forecast_type == 3){
        $date_today = makeMySQLDate();
        $date_last = date("Y-m-d",strtotime("+13 day", strtotime($date_today)));
        $days_to_forecast = 14;
    }


$content .='
<div class="row">
    <div class="col-12">
        <div class="card mb-2">
            <!--begin::Card body-->
            <div class="card-body p-10 p-lg-15">
                <!--begin::Title-->
                <h4 class="fw-bold text-dark mb-12 ps-0">Weather Forcast for '.ucwords(strtolower(self::getWeatherParishName($_REQUEST['parish_id']))).', '.ucwords(strtolower($_REQUEST['subcounty_id'])).' - '.ucwords(strtolower($_REQUEST['district'])).' District between '.$date_today.' and '.$date_last.'</h4>
                <!--end::Title-->';

                        $w_data = (WEATHER_OFFLINE) ? self::returnWeatherDataFromDatabase($parish_id,$days_to_forecast) : self::returnWeatherDataFromApi($parish_id,$days_to_forecast);
                        
                        if($w_data){

                                //Set weather graph variables here

                                $_SESSION['location_title'] = ucwords(strtolower(self::getWeatherParishName($_REQUEST['parish_id']))).', '.ucwords(strtolower($_REQUEST['subcounty_id'])).' - '.ucwords(strtolower($_REQUEST['district'])).' District between '.$date_today.' and '.$date_last;


                    $content .= '<!--begin::Row-->
                                <div class="row">';

                                $content .= $w_data;

                                

                                    $content .='                

                                        </div>
                                        <!--end::Row-->

                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                        </div> <!-- end row -->


                        <div class="row">
                            <div class="col-12">

                                <div class="card mb-2">
                                    <!--begin::Card body-->
                                    <div class="card-body p-10 p-lg-15">
                                        <!--begin::Title-->
                                        <h4 class="fw-bold text-dark mb-12 ps-0">Precipitation for '.ucwords(strtolower(self::getWeatherParishName($_REQUEST['parish_id']))).', '.ucwords(strtolower($_REQUEST['subcounty_id'])).' - '.ucwords(strtolower($_REQUEST['district'])).' between '.$date_today.' and '.$date_last.'</h4>
                                        <!--end::Title-->
                                        <!--begin::Row-->
                                        <div class="row">
                                            <div class="col-md-12 col-xxl-12">
                                                <div class="panel-body" id="nextsevenprec"></div>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">

                                <div class="card mb-2">
                                    <!--begin::Card body-->
                                    <div class="card-body p-10 p-lg-15">
                                        <!--begin::Title-->
                                        <h4 class="fw-bold text-dark mb-12 ps-0">Temperature Forcast for '.ucwords(strtolower(self::getWeatherParishName($_REQUEST['parish_id']))).', '.ucwords(strtolower($_REQUEST['subcounty_id'])).' - '.ucwords(strtolower($_REQUEST['district'])).' between '.$date_today.' and '.$date_last.'</h4>
                                        <!--end::Title-->
                                        <!--begin::Row-->
                                        <div class="row">
                                            <div class="col-md-12 col-xxl-12">
                                                <div class="panel-body" id="nextseventemp"></div>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                
                            </div>
                        </div>

                        ';



                    // end num_rows
                    }
                    else
                    {

                                $content .= '<p class="text-danger">No records found for this location for that period.</p>';
                                $_SESSION['location_title'] = '';
                                $_SESSION['next7daysprecamount'] = '';
                                $_SESSION['next7daysprecchance'] = '';
                                $_SESSION['next7daystempmin'] = '';
                                $_SESSION['next7daystempmax'] = '';
                                $_SESSION['next7daysdates'] = '';

                                $content .='
                                          </div>
                                        </div>
                                    </div>
                                </div> <!-- end row -->';
                    }

}

$content .= '</div>
    <!-- end container -->';

    return [
        'content' => $content,
        'styles' => $styles,
        'scripts' => $scripts
    ];
}




public  static function predictWinds($windspeed_average){

if($windspeed_average > 8){
return 'Heavy Wind/Calm';
}
else if ($windspeed_average <8 && $windspeed_average > 6){
return 'Moderate Wind/Calm';
}
else if ($windspeed_average <6 && $windspeed_average > 4.5){
return 'Light Wind/Calm';
}
else if ($windspeed_average < 4.5 && $windspeed_average > 3.0){
return 'Trace Amount of Wind';
}
else
{
return 'Wind/Calm';
}


}


public  static function predictClouds($chance){

if($chance > 80){
return 'Mostly Cloudy';
}
else if ($chance <80 && $chance > 60){
return 'Cloudy';
}
else if ($chance <60 && $chance > 45){
return 'Light Clouds';
}
else if ($chance < 45 && $chance > 30){
return 'Partly Cloudy';
}
else
{
return 'No Cloud Cover';
}

}


public  static function predictRainfall($chance){
if($chance > 80){
return 'Heavy Rains';
}
else if ($chance <80 && $chance > 60){
return 'Moderate Rains';
}
else if ($chance <60 && $chance > 45){
return 'Light Rains';
}
else if ($chance < 45 && $chance > 30){
return 'Trace Amount of Rains';
}
else
{
return 'No Rains';
}

}




public  static function predictIcon($cloudcover,$sunshine,$rainfall){
if($rainfall > 80 && $cloudcover > 80 ){
return 'mostlyrainy.png';
}
else if ($rainfall > 80 && $cloudcover > 60){
return 'averagerain.png';
}
else if ($sunshine > 80 && $rainfall > 50){
return '50_50.png';
}
else if ($cloudcover < 50 && $sunshine > 70){
return 'cloudy_sunshine.png';
}
else if ($cloudcover > 50 && $sunshine > 50 && $rainfall > 50){
return 'average.png';
}
else
{
return 'cloudy_sunshine.png';
}

}




public static function getWeatherParishName($id){

$sql= database::performQuery("SELECT * FROM weather_parish WHERE id=$id");
return $sql->fetch_assoc()['Parish'];
}

public static function getWeatherFromRapidApi($lat,$long,$days_to_fetch=null)
{
    //$bearer = "1f04cd1216mshb8991cccc546a27p13183djsneceddde8d899";
    $open = "986ab58fe8f1422e074806d333e5cda1";
    
    $no_of_days = $days_to_fetch ?? NO_OF_DAYS_TO_FETCH; 

    //$url = "https://community-open-weather-map.p.rapidapi.com/forecast/daily?lat=$lat&lon=$long&units=metric&cnt=$no_of_days";
    
    $url = "https://api.openweathermap.org/data/2.5/forecast/daily?lat=$lat&lon=$long&units=metric&cnt=$no_of_days&appid=$open";
    //$url = "https://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$long&units=metric&cnt=$no_of_days&appid=$open&exclude=current,minutely";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//    $headers = array(
//    "Accept: application/json",
//    "Content-Type:application/json",
//    "x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
//	"x-rapidapi-key: $bearer"
//    );

    $headers = array(
        "Accept: application/json",
        "Content-Type:application/json"

    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);



    // Attach encoded JSON string to the POST fields
    //curl_setopt($curl, CURLOPT_POSTFIELDS,'');

    

    
    $response = curl_exec($curl);        
    if($response === false){
        throw new Exception('cURL Transport Error (HTTP request failed): '.curl_error($curl));
        
    } else { 
        $info = curl_getinfo($curl);
        $result = json_decode($response,true); 
        //$result = $response;
        curl_close($curl);
        return $result;
        
    }   
    curl_close($curl);
}


}