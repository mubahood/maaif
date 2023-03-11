<?php 

include("Awhere.php");
include("includes/classes/database.php");


function createField($access_token, $field_id, $field_name, $field_farm_id, $field_latitude, $field_longitude, $field_acres=0)
{
    $status = false;
    $result = null;
    $newFieldBody = array(  "id"        => $field_id,
                            "name"      => $field_name,
                            "farmId"    => $field_farm_id,
                            "centerPoint"   =>array("latitude"  => $field_latitude,
                                                    "longitude" => $field_longitude),
                            "acres"         => $field_acres);

    $awhere = new Awhere;
    $newFieldResponse = $awhere->makeAPICall(
        'POST','https://api.awhere.com/v2/fields',
        $access_token,
        $newFieldStatusCode,
        $newFieldResponseHeaders,
        json_encode($newFieldBody),
        array("Content-Type: application/json")
    ); 

    if($newFieldStatusCode==201){   // Code 201 means the Create was successful    
        // \Log::info('A new field was created');                      
        $result = $newFieldResponse;
        $message = 'success';  
        $status = true;                         
                                                    
    } else if($newFieldStatusCode==409){
        $message = "A field with ID $field_id already exists in your account, so it could not be created again.";

    } else { 
        $message = "ERROR: ".$newFieldStatusCode." - ".$newFieldResponse->simpleMessage.", ".$newFieldResponse->detailedMessage;
    } 

    return [
        'status' => $status,
        'result' => $result,
        'message'=> $message
    ];
}

 function doForecast($access_token, $field_id, $start_date, $end_date)
{  
    $status = false;
    $result = null;      
    //get precipitation and temperature
    $forecastURL = AWHERE_URL.'/v2/weather/fields/' . $field_id . '/forecasts/' . $start_date . ',' . $end_date . "?blockSize=24";

    $awhere = new Awhere;
    $forecastResponse = $awhere->makeAPICall(
        'GET',
        $forecastURL,
        $access_token,
        $forecastStatusCode,
        $forecastResponseHeaders
    );
    
    if ($forecastStatusCode == 200) { // Code 200 means the request was successful
        //return stripslashes(json_encode($forecastResponse,JSON_PRETTY_PRINT));
        $status = true;
        $result = $forecastResponse; 
        $message = 'success';                  
    } 
    else {
        $message = "ERROR: ".$forecastStatusCode." - ".$forecastResponse->simpleMessage.", ".$forecastResponse->detailedMessage;
    }

    return [
        'status' => $status,
        'result' => $result,
        'message'=> $message
    ];
}


 function doObservation($access_token, $field_id, $start_date, $end_date)
{
    $status = false;
    $result = null;
    //get precipitation and temperature
    $observationURL = AWHERE_URL.'/v2/weather/fields/' . $field_id . '/observations/' . $start_date . ',' . $end_date . "?blockSize=24";

    $awhere = new Awhere;
    $observationResponse = $awhere->makeAPICall(
        'GET', 
        $observationURL, 
        $access_token, 
        $observationStatusCode, 
        $observationResponseHeaders
    );
    
    if ($observationStatusCode == 200) { // Code 200 means the request was successful
        //return stripslashes(json_encode($observationResponse,JSON_PRETTY_PRINT));
        $status = true;
        $result = $observationResponse;
        $message = 'success'; 
    } 
    else {
        $message = "ERROR: ".$observationStatusCode." - ".$observationResponse->simpleMessage.", ".$observationResponse->detailedMessage;              
    }

    return [
        'status' => $status,
        'result' => $result,
        'message'=> $message
    ];
}

function getWeatherFromStormGlass($lat,$long)
{
    $bearer = STORMGLASS_API_KEY;    
    $start = date("Y-m-d");
    $end = date("Y-m-d", strtotime("+ ".NO_OF_DAYS_TO_FETCH." days"));   

    $url = "https://api.stormglass.io/v2/weather/point?lat=$lat&lng=$long&start=$start&end=$end&params=windSpeed,windDirection,cloudCover,precipitation,airTemperature,visibility";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
    "Accept: application/json",
    "Content-Type:application/json",
    "Authorization: {$bearer}",
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
        $result = json_decode($response); 
        curl_close($curl);
        return $result;
        
    }   
    curl_close($curl);
}

function getWeatherFromRapidApi($lat,$long,$days_to_fetch=null)
{
    $bearer = RAPID_API_OPEN_WEATHER;  
    $open = OPENWEATHER_API_KEY;
    
    $no_of_days = $days_to_fetch ?? NO_OF_DAYS_TO_FETCH; 

    $url = "https://community-open-weather-map.p.rapidapi.com/forecast/daily?lat=$lat&lon=$long&units=metric&cnt=$no_of_days";
    
    //$url = "https://api.openweathermap.org/data/2.5/forecast/daily?lat=$lat&lon=$long&units=metric&cnt=$no_of_days&appid=$open";
    //$url = "https://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$long&units=metric&cnt=$no_of_days&appid=$open&exclude=current,minutely";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
    "Accept: application/json",
    "Content-Type:application/json",
    "x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
	"x-rapidapi-key: $bearer"
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

function testStorm()
{
    $r = getWeatherFromRapidApi(0.353550,32.618591);
    print_r($r['list']);
}

 function getweatherdata()
{
    //get parishes 
    //$sql = "select id,longitude,latitude from weather_parish where district in('Amuru','Kalungu')";
    $today = date('Y-m-d').' 00:00:00';
    $date = date('Y-m-d');
    $today_later = date('Y-m-d').' 23:59:59';
    $after_date = date('Y-m-d', strtotime($date. ' + '.NO_OF_DAYS_TO_FETCH.' days'));

    
    $sql = "select id,longitude,latitude from weather_parish where id not in (select distinct parish_id from weather_infomation where forecast_date between '$date' and '$after_date') limit ".NO_OF_PARISHES_TO_FETCH."";
    $result = database::performQuery($sql);
    $parishes = $result->fetch_all(MYSQLI_ASSOC);
    
 //  echo $today;
//    var_dump($parishes);
    //die();

    
    foreach($parishes as $parish)
    {
        $parish_id = $parish['id'];
        $parish_latitude = $parish['latitude'];
        $parish_longitude = $parish['longitude'];
   //     echo $parish_id;
     
        try 
        {     
           

            $result = getWeatherFromRapidApi($parish_latitude,$parish_longitude);
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
                
                try
                {
                    $sql_add = "INSERT INTO `weather_infomation` (`parish_id`, `latitude`, `longitude`, `forecast_date`, `maximum_temperature`, `minimum_temperature`, `average_temperature`, `temperature_units`, `rainfall_chance`, `rainfall_amount`, `rainfall_units`, `windspeed_average`, `windspeed_units`, `wind_direction`, `windspeed_maximum`, `windspeed_minimum`, `cloudcover`, `sunshine_level`, `soil_temperature`, `created_at`, `updated_at`,`weather_description`,`weather_icon`) VALUES ($parish_id, $parish_latitude, $parish_longitude, '$forecast_date', $maximum_temperature, $minimum_temperature, $average_temperature, '$temperature_units', $rainfall_chance, $rainfall_amount,'$rainfall_units',$wind_average,'$wind_units','$wind_direction',$wind_max, $wind_min, $cloud_cover, $sunshine_level, $soil_temperature, '$created_at', '$created_at','$weather_description','$weather_icon') ";
                    
                    database::performQuery($sql_add);
                }
                catch(\Exception $e)
                {

                }
        
                
            }
            // $rout = print_r($result);
            // $txt = date('Y-m-d H:i:s').':'.$rout;
            // $myfile = file_put_contents('weather_rapid_api_logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

        }
        catch(\Exception $e)
        {
            $txt = date('Y-m-d H:i:s').':'.$e->getMessage();
            $myfile = file_put_contents('weather_cron_error_logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
            
        }
    }
    $ctxt = "weather cron run at:".date('Y-m-d H:i:s');
    $cmyfile = file_put_contents('weather_cron.txt', $ctxt.PHP_EOL , FILE_APPEND | LOCK_EX);

    
    
}



