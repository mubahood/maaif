<?php

class RESTAPI
{



public static function saveCrisisOutbreaks(){

    //making an array to store the response
        $response = array();

    //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_REQUEST = json_decode(file_get_contents('php://input'), true);

            $a1 = $_REQUEST['a1'];
            $a2 = $_REQUEST['a2'];
            $a3 = $_REQUEST['a3'];
            $a4 = $_REQUEST['a4'];
            $a5 = $_REQUEST['a5'];
            $a6 = $_REQUEST['a6'];
            $a7 = $_REQUEST['a7'];
            $a8 = $_REQUEST['a8'];
            $a9 = $_REQUEST['a9'];
            $a10 = $_REQUEST['a10'];
            $a11 = $_REQUEST['a11'];
            $a12 = $_REQUEST['a12'];
            $a13 = $_REQUEST['a13'];
            $a14 = $_REQUEST['a14'];
            $a15 = $_REQUEST['a15'];
            $a16 = $_REQUEST['a16'];
            $a17 = $_REQUEST['a17'];
            $a18 = $_REQUEST['a18'];
            $a19 = $_REQUEST['a19'];
            $a20 = $_REQUEST['a20'];
            $a21 = $_REQUEST['a21'];
            $a22 = $_REQUEST['a22'];
            $a23 = $_REQUEST['a23'];
            $a24 = $_REQUEST['a24'];
            $id = $_REQUEST['id'];


            $sql = database::performQuery("INSERT INTO `mod_crisis`(`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, a17, `a18`, `a19`, `a20`,`a21`,`a22`,`a23`,`a24`) 
                                                        VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17', '$a18', '$a19', '$a20','$a21','$a22','$a23','$a24')
                                          ");
            $a19 =  database::getLastInsertID();

            //making success response
            $response['error'] = false;
            $response['id'] =  $id;
            $response['a21'] =  $a19;


        }else{
            $response['error'] = true;
            $response['message'] = "Invalid request";
        }

    //displaying the data in json format
        echo json_encode($response);
    }

public static function saveEdiaryActivities(){

    //making an array to store the response
        $response = array();

    //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_REQUEST = json_decode(file_get_contents('php://input'), true);

            $a1 = $_REQUEST['a1'];
            $a2 = $_REQUEST['a2'];
            $a3 = $_REQUEST['a3'];
            $a4 = $_REQUEST['a4'];
            $a5 = $_REQUEST['a5'];
            $a6 = $_REQUEST['a6'];
            $a7 = $_REQUEST['a7'];
            $a8 = $_REQUEST['a8'];
            $a9 = $_REQUEST['a9'];
            $a10 = $_REQUEST['a10'];
            $a11 = $_REQUEST['a11'];
            $a12 = $_REQUEST['a12'];
            $a13 = $_REQUEST['a13'];
            $a14 = $_REQUEST['a14'];
            $a15 = $_REQUEST['a15'];
            $a16 = $_REQUEST['a16'];
            $a17 = $_REQUEST['a17'];
            $a18 = $_REQUEST['a18'];
            $a19 = "";
            $a20 = $_REQUEST['a20'];
            $a21 = $_REQUEST['a21'];
            $a22 = $_REQUEST['a22'];
            $a23 = $_REQUEST['a23'];
            $id = $_REQUEST['id'];



            $sql = database::performQuery("INSERT INTO `mod_ediary`(`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, a17, `a18`, `a19`, `a20`,`a21`,`a22`,`a23` ) 
                                                        VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17', '$a18', '$a19', '$a20','$a21','$a22', '$a23')
                                          ");

            $idx = database::getLastInsertID();

              $date =  $a17;

              $first_quarter = [7,8,9];
              $second_quarter = [10,11,12];
              $third_quarter = [1,2,3];
              $fourth_quarter =  [4,5,6];

              $month = (int)date("m",strtotime($date));

              if (in_array($month, $first_quarter)){

	         $quarter =  1;
              }

              else if(in_array($month, $second_quarter)){
	
                 $quarter =  2;
              }

              else if(in_array($month, $third_quarter)){

	         $quarter = 3;
              }

              else if(in_array($month, $third_quarter)){

	         $quarter = 4;
              }


              if($month > 6){
	         $ending_year =  (int)date("Y",strtotime($date)) + 1;
    
                 $financial_year = date("Y",strtotime($date)).'/'.$ending_year;
    
              }

              else{
	         $beginning_year = (int)date("Y",strtotime($date)) - 1;
                 $financial_year =  $beginning_year.'/'.date("Y",strtotime($date));
    
              }

            $topic_id = self::getTopicIDbyName($a1);
            $activity_id = self::getActivityIDbyName($a2);
            $ent_id = self::getEntIDbyName($a3);
            $village_id = self::getVillageIDbyName($a5,$a6,$a4,$a7);
            $tot = $a11+$a12;
            $sql2 = database::performQuery("INSERT INTO `ext_area_daily_activity`(`date`, `topic`, `gps_latitude`, `gps_longitude`, `entreprise`,  `village_id`, `notes`, `num_ben_males`, `num_ben_total`, `num_ben_females`, `ben_ref_name`, `ben_ref_phone`, `ben_group`, `user_id`, `quarterly_activity_id`, `activity_type`, `challenges`, `lessons`, `recommendations`, `financial_year`, `quarter`, `description`) 
                                                                                  VALUES ('$a17','$topic_id','$a15','$a16','$ent_id','$village_id','$a22','$a11','$tot','$a12','$a9','$a10','$a8','$a14','$activity_id','$a20', '$a13', '$a21', '$a22', '$financial_year', $quarter, '$a23')");


            $a19 =  database::getLastInsertID();

            //making success response
            $response['error'] = false;
            $response['id'] =  $id;
            $response['a19'] =  $a19;


            //Update orignal table
            $sql = database::performQuery("UPDATE mod_ediary SET a19=$a19 WHERE id=$idx");



        }else{
            $response['error'] = true;
            $response['message'] = "Invalid request";
        }

    //displaying the data in json format
        echo json_encode($response);
    }

public static function getTopicIDbyName($name){

    $sql = database::performQuery("SELECT * FROM `ext_topics` WHERE name LIKE '$name%'");
    if($sql->num_rows > 0)
    return $sql->fetch_assoc()['id'];
    else
        return 119;
}

public static function getActivityIDbyName($name){

    $sql = database::performQuery("SELECT * FROM `ext_activitys` WHERE name LIKE '$name%'");
    if($sql->num_rows > 0)
        return $sql->fetch_assoc()['id'];
    else
        return 52;
}

public static function getEntIDbyName($name){

    $sql = database::performQuery("SELECT * FROM `km_category` WHERE name LIKE '$name%'");
    if($sql->num_rows > 0)
        return $sql->fetch_assoc()['id'];
    else
        return 198;
}
public static function getVillageIDbyName($district,$subcounty,$parish,$village){

        $sql = database::performQuery("SELECT village.id  
                                             FROM district,county,subcounty,parish,village 
                                             WHERE 
                                                   district.id = county.district_id
                                                   AND county.id = subcounty.county_id
                                                   AND subcounty.id = parish.subcounty_id 
                                                   AND parish.id = village.parish_id
                                                   AND district.name = '$district'
                                                   AND subcounty.name = '$subcounty'
                                                   AND parish.name = '$parish'
                                                   AND village.name = '$village'");


    if($sql->num_rows > 0)
        return $sql->fetch_assoc()['id'];
    else
        return 1;
}


public static function saveMarkets(){

    //making an array to store the response
        $response = array();

    //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_REQUEST = json_decode(file_get_contents('php://input'), true);

            $a1 = $_REQUEST['a1'];
            $a2 = $_REQUEST['a2'];
            $a3 = $_REQUEST['a3'];
            $a4 = $_REQUEST['a4'];
            $a5 = $_REQUEST['a5'];
            $a6 = $_REQUEST['a6'];
            $a7 = $_REQUEST['a7'];
            $a8 = $_REQUEST['a8'];
            $a9 = $_REQUEST['a9'];
            $a10 = $_REQUEST['a10'];
            $a11 = $_REQUEST['a11'];
            $a12 = $_REQUEST['a12'];
            $a13 = $_REQUEST['a13'];
            $a14 = $_REQUEST['a14'];
            $a15 = $_REQUEST['a15'];
            $a16 = $_REQUEST['a16'];
            $a17 = $_REQUEST['a17'];
            $a18 = $_REQUEST['a18'];
            $a19 = $_REQUEST['a19'];
            $a20 = $_REQUEST['a20'];
            $id = $_REQUEST['id'];


            $sql = database::performQuery("INSERT INTO `mod_market`(`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, a17, `a18`, `a19`, `a20`) 
                                                        VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17', '$a18', '$a19', '$a20')
                                          ");
            $a19 =  database::getLastInsertID();

            //making success response
            $response['error'] = false;
            $response['id'] =  $id;
            $response['a19'] =  $a19;


        }else{
            $response['error'] = true;
            $response['message'] = "Invalid request";
        }

    //displaying the data in json format
        echo json_encode($response);
    }
    
    
    
public static function saveMarketPlayer(){

    //making an array to store the response
        $response = array();

    //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_REQUEST = json_decode(file_get_contents('php://input'), true);

            $a1 = $_REQUEST['a1'];
            $a2 = $_REQUEST['a2'];
            $a3 = $_REQUEST['a3'];
            $a4 = $_REQUEST['a4'];
            $a5 = $_REQUEST['a5'];
            $a6 = $_REQUEST['a6'];
            $a7 = $_REQUEST['a7'];
            $a8 = $_REQUEST['a8'];
            $a9 = $_REQUEST['a9'];
            $a10 = $_REQUEST['a10'];
            $a11 = $_REQUEST['a11'];
            $a12 = $_REQUEST['a12'];
            $a13 = $_REQUEST['a13'];
            $a14 = $_REQUEST['a14'];
            $a15 = $_REQUEST['a15'];
            $a16 = $_REQUEST['a16'];
            $a17 = $_REQUEST['a17'];
            $a18 = $_REQUEST['a18'];
            $a19 = $_REQUEST['a19'];
            $a20 = $_REQUEST['a20'];
            $id = $_REQUEST['id'];


            $sql = database::performQuery("INSERT INTO `mod_other_player`(`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, a17, `a18`, `a19`, `a20`) 
                                                        VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17', '$a18', '$a19', '$a20')
                                          ");
            $a19 =  database::getLastInsertID();

            //making success response
            $response['error'] = false;
            $response['id'] =  $id;
            $response['a19'] =  $a19;


        }else{
            $response['error'] = true;
            $response['message'] = "Invalid request";
        }

    //displaying the data in json format
        echo json_encode($response);
    }

    
public static function saveBuyerRequest(){

    //making an array to store the response
        $response = array();

    //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_REQUEST = json_decode(file_get_contents('php://input'), true);

            $a1 = $_REQUEST['a1'];
            $a2 = $_REQUEST['a2'];
            $a3 = $_REQUEST['a3'];
            $a4 = $_REQUEST['a4'];
            $a5 = $_REQUEST['a5'];
            $a6 = $_REQUEST['a6'];
            $a7 = $_REQUEST['a7'];
            $a8 = $_REQUEST['a8'];
            $a9 = $_REQUEST['a9'];
            $a10 = $_REQUEST['a10'];
            $a11 = $_REQUEST['a11'];
            $a12 = $_REQUEST['a12'];
            $a13 = $_REQUEST['a13'];
            $a14 = $_REQUEST['a14'];
            $a15 = $_REQUEST['a15'];
            $a16 = $_REQUEST['a16'];
            $a17 = $_REQUEST['a17'];
            $a18 = $_REQUEST['a18'];
            $a19 = $_REQUEST['a19'];
            $a20 = $_REQUEST['a20'];
            $a21 = $_REQUEST['a21'];
            $a22 = $_REQUEST['a22'];
            $id = $_REQUEST['id'];


            $sql = database::performQuery("INSERT INTO `mod_buyer_request`(`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, a17, `a18`, `a19`, `a20`, a21, a22) 
                                                        VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17', '$a18', '$a19', '$a20', '$a21', '$a22')
                                          ");
            $a19 =  database::getLastInsertID();

            //making success response
            $response['error'] = false;
            $response['id'] =  $id;
            $response['a19'] =  $a19;


        }else{
            $response['error'] = true;
            $response['message'] = "Invalid request";
        }

    //displaying the data in json format
        echo json_encode($response);
    }
    
    
        
public static function saveSellerRequest(){

    //making an array to store the response
        $response = array();

    //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_REQUEST = json_decode(file_get_contents('php://input'), true);

            $a1 = $_REQUEST['a1'];
            $a2 = $_REQUEST['a2'];
            $a3 = $_REQUEST['a3'];
            $a4 = $_REQUEST['a4'];
            $a5 = $_REQUEST['a5'];
            $a6 = $_REQUEST['a6'];
            $a7 = $_REQUEST['a7'];
            $a8 = $_REQUEST['a8'];
            $a9 = $_REQUEST['a9'];
            $a10 = $_REQUEST['a10'];
            $a11 = $_REQUEST['a11'];
            $a12 = $_REQUEST['a12'];
            $a13 = $_REQUEST['a13'];
            $a14 = $_REQUEST['a14'];
            $a15 = $_REQUEST['a15'];
            $a16 = $_REQUEST['a16'];
            $a17 = $_REQUEST['a17'];
            $a18 = $_REQUEST['a18'];
            $a19 = $_REQUEST['a19'];
            $a20 = $_REQUEST['a20'];
            $a21 = $_REQUEST['a21'];
            $a22 = $_REQUEST['a22'];
            $id = $_REQUEST['id'];


            $sql = database::performQuery("INSERT INTO `mod_seller_request`(`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, a17, `a18`, `a19`, `a20`, a21, a22) 
                                                        VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17', '$a18', '$a19', '$a20', '$a21', '$a22')
                                          ");
            $a19 =  database::getLastInsertID();

            //making success response
            $response['error'] = false;
            $response['id'] =  $id;
            $response['a19'] =  $a19;


        }else{
            $response['error'] = true;
            $response['message'] = "Invalid request";
        }

    //displaying the data in json format
        echo json_encode($response);
    }

public static function savePricesVolumes(){

        //making an array to store the response
        $response = array();

        //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_REQUEST = json_decode(file_get_contents('php://input'), true);

            $a1 = $_REQUEST['a1'];
            $a2 = $_REQUEST['a2'];
            $a3 = $_REQUEST['a3'];
            $a4 = $_REQUEST['a4'];
            $a5 = $_REQUEST['a5'];
            $a6 = $_REQUEST['a6'];
            $a7 = $_REQUEST['a7'];
            $a8 = $_REQUEST['a8'];
            $a9 = $_REQUEST['a9'];
            $a10 = $_REQUEST['a10'];
            $a11 = $_REQUEST['a11'];
            $a12 = $_REQUEST['a12'];
            $a13 = $_REQUEST['a13'];
            $a14 = $_REQUEST['a14'];
            $a15 = $_REQUEST['a15'];
            $a16 = $_REQUEST['a16'];
            $a17 = $_REQUEST['a17'];
            $a18 = $_REQUEST['a18'];
            $a19 = $_REQUEST['a19'];
            $a20 = $_REQUEST['a20'];
            $id = $_REQUEST['id'];


            $sql = database::performQuery("INSERT INTO `mod_market_price_volume`(`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, a17, `a18`, `a19`, `a20`) 
                                                        VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17', '$a18', '$a19', '$a20')
                                          ");
            $a19 =  database::getLastInsertID();

            //making success response
            $response['error'] = false;
            $response['id'] =  $id;
            $response['a12'] =  $a12;


        }else{
            $response['error'] = true;
            $response['message'] = "Invalid request";
        }

        //displaying the data in json format
        echo json_encode($response);
    }


public static  function syncUserFarmers(){

        if (isset($_REQUEST['a21'])) {

            // receiving the REQUEST params
            $id = database::prepData($_REQUEST['a21']);

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM farmer WHERE `a21` =$id ");
            $sqlb =  database::performQuery("SELECT * FROM awareness_rising WHERE user_id =$id ");
            $farmers = [];
            $events = [];

            if($sql->num_rows > 0){
                while($data=$sql->fetch_assoc()){
                    $farmers[]=$data;
                }
            }

            if($sqlb->num_rows > 0){
                while($datab=$sqlb->fetch_assoc()){
                    $events[]=$datab;
                }
            }



            // user farmers are known
            $response["error"] = FALSE;
            $response["farmers"] = $farmers;
            $response["events"] = $events;
            echo json_encode($response);

        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }

    }
    
    
    
    
public static  function getUserMarketsData(){

        if (isset($_REQUEST['uid'])) {

            // receiving the REQUEST params
            $id = database::prepData($_REQUEST['uid']);

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM mod_market WHERE `a14` =$id ");
            $sqlb =  database::performQuery("SELECT * FROM mod_buyer_request WHERE a19 =$id ");
            $sqlc =  database::performQuery("SELECT * FROM mod_seller_request WHERE a19 =$id ");
            $sqld =  database::performQuery("SELECT * FROM mod_other_player WHERE a14 =$id ");
            $sqle =  database::performQuery("SELECT * FROM mod_market_price_volume WHERE a7 =$id ");
            
            
            $markets = [];
            $buyer_req = [];
            $seller_req = [];
            $market_px = [];
            $market_players = [];

            if($sql->num_rows > 0){
                while($data=$sql->fetch_assoc()){
                    $markets[]=$data;
                }
            }

            if($sqlb->num_rows > 0){
                while($datab=$sqlb->fetch_assoc()){
                    $buyer_req[]=$datab;
                }
            }


            if($sqlc->num_rows > 0){
                while($datac=$sqlc->fetch_assoc()){
                    $seller_req[]=$datac;
                }
            }


            if($sqld->num_rows > 0){
                while($datad=$sqld->fetch_assoc()){
                    $market_players[]=$datad;
                }
            }


            if($sqle->num_rows > 0){
                while($datae=$sqle->fetch_assoc()){
                    $market_px[]=$datae;
                }
            }



            // user farmers are known
            $response["error"] = FALSE;
            $response["markets"] = $markets;
            $response["buyer_req"] = $buyer_req;
            $response["seller_req"] = $seller_req;
            $response["market_player"] = $market_players;
            $response["market_px"] = $market_px;
            echo json_encode($response);

        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }

    }


    /*
 *Upload Photos here
 */
    public static function uploadActivityPhoto(){
        $response = [];
        if ($_FILES['file_name']['error'] > 0) {
            $response['error']=true;
            $response['message']=$_FILES['image']['error'];
            echo json_encode($response);
        } else {

//            print_r($_FILES);
//
//            echo "<br />";
//
//            print_r($_REQUEST);
            // array of valid extensions
            $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
            // get extension of the uploaded file
            $fileExtension = strrchr($_FILES['image']['name'], ".");
            // check if file Extension is on the list of allowed ones
            if (in_array($fileExtension, $validExtensions)) {
                $newNamePrefix = time() . '_';
                $manipulator = new ImageManipulator($_FILES['image']['tmp_name']);
                // resizing to 750X400
                $newImage = $manipulator->resample(650, 350);

                $year = date("Y");
                $month = date("m");
                $path = '../images/field/'.$year.'/'.$month.'/' . $newNamePrefix . $_FILES['image']['name'];
                 // saving file to uploads folder
                $manipulator->save($path);
                //               $manipulator->save($path2);
//                echo 'Hooray ... Uploaded<br />';
//                echo'Path is '.$path;
                $id = $_REQUEST['id'];
                $path_use = 'images/field/'.$year.'/'.$month.'/' . $newNamePrefix . $_FILES['image']['name'];

                $sql = database::performQuery("INSERT INTO ext_area_daily_activity_image(url,activity_id)  VALUES('$path_use',$id)");

                //filling response array with values
                $response['error'] = false;
                $response['url'] = $path;
                $response['name'] = $_FILES['image']['name'];
                echo json_encode($response);

            } else {
                $response['error']=true;
                $response['message']='An error occurred! Please submit an image file.';
                echo json_encode($response);
            }
        }

    }


    public static function uploadOutbreaksPhoto(){
        $response = [];
        if ($_FILES['file_name']['error'] > 0) {
            $response['error']=true;
            $response['message']=$_FILES['image']['error'];
            echo json_encode($response);
        } else {

//            print_r($_FILES);
//
//            echo "<br />";
//
//            print_r($_REQUEST);
            // array of valid extensions
            $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
            // get extension of the uploaded file
            $fileExtension = strrchr($_FILES['image']['name'], ".");
            // check if file Extension is on the list of allowed ones
            if (in_array($fileExtension, $validExtensions)) {
                $newNamePrefix = time() . '_';
                $manipulator = new ImageManipulator($_FILES['image']['tmp_name']);
                // resizing to 750X400
                $newImage = $manipulator->resample(750, 400);

                $year = date("Y");
                $month = date("m");
                $path = '../images/outbreaks/'.$year.'/'.$month.'/' . $newNamePrefix . $_FILES['image']['name'];
                // saving file to uploads folder
                $manipulator->save($path);
                //               $manipulator->save($path2);
//                echo 'Hooray ... Uploaded<br />';
//                echo'Path is '.$path;
                $id = $_REQUEST['id'];
                $path_use = 'images/outbreaks/'.$year.'/'.$month.'/' . $newNamePrefix . $_FILES['image']['name'];

                $sql = database::performQuery("INSERT INTO mod_outbreaks_image(url,activity_id)  VALUES('$path_use',$id)");

                //filling response array with values
                $response['error'] = false;
                $response['url'] = $path;
                $response['name'] = $_FILES['image']['name'];
                echo json_encode($response);

            } else {
                $response['error']=true;
                $response['message']='An error occurred! Please submit an image file.';
                echo json_encode($response);
            }
        }

    }

    public function saveFarmerGroup(){

        header('Content-Type: application/json; charset=utf-8');

        $reponse =  array();

        //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            if( isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == "application/json"){

                $_REQUEST = json_decode(file_get_contents('php://input'), true);
            }

            // Validate and sanitize data
            $farmer_group =  $_REQUEST['farmer_group'] ?? null;
            $farmer_group = self::checkIfEmpty($farmer_group, 'farmer group');
            $farmer_group = self::sanitizeData($farmer_group);

           
  
            $group_leader = $_REQUEST['group_leader'] ?? null;
            $group_leader = self::checkIfEmpty($group_leader, 'group leader');
            $group_leader = self::sanitizeData($group_leader);

            $group_leader_contact = $_REQUEST['group_leader_contact'] ?? null;
            $group_leader_contact = self::checkIfEmpty($group_leader_contact, 'group leader contact');
            $group_leader_contact = self::sanitizeData($group_leader_contact);

            $establishment_year = $_REQUEST['establishment_year'] ?? null;
            $establishment_year = self::sanitizeData($establishment_year);

            $parish_id = $_REQUEST['parish_id'] ?? null;
            $parish = self::checkIfEmpty($parish_id, 'parish');
            $parish_id = self::sanitizeData($parish_id);

            $latitude = $_REQUEST['latitude'] ?? null;
            $latitude = self::sanitizeData($latitude);

            $longitude = $_REQUEST['longitude'] ?? null;
            $longitude = self::sanitizeData($longitude);

            $id_str = uniqid('MAAIF-', true);

            $sql = database::performQuery("INSERT INTO `db_farmer_groups`(`id_str`, `name` ,`lat`, `lng`, `parish_id`,
            `a1`, `a2`, `a3`) 
            VALUES ('$id_str', '$farmer_group', '$latitude', '$longitude', '$parish_id', '$group_leader', 
            '$group_leader_contact', '$establishment_year')");

            
             //making success response
             $response['error'] = false;
             $response['message'] =  "Data inserted successfully";
             http_response_code(201);
             echo json_encode($response);
        }
        else{

            $response['error']=true;
            $response['message']='This route does not support the supplied HTTP Method';
            http_response_code(400);
            echo json_encode($response);
            return;
        }

    }


    public function saveFarmer(){
        header('Content-Type: application/json; charset=utf-8');

        $reponse =  array();

        //if there is a post request move ahead
        if($_SERVER['REQUEST_METHOD']=='POST'){

            if( isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == "application/json"){

                $_REQUEST = json_decode(file_get_contents('php://input'), true);
            }

            // Validate and sanitize data
            $first_name =  $_REQUEST['first_name'] ?? null;
            $first_name = self::checkIfEmpty($first_name, 'first name');
            $first_name = self::sanitizeData($first_name);

            $last_name =  $_REQUEST['last_name'] ?? null;
            $last_name = self::checkIfEmpty($last_name, 'last name');
            $last_name = self::sanitizeData($last_name);

            $full_name =  $first_name. ' '.$last_name;

            $farmer_group_id =  $_REQUEST['farmer_group_id'] ?? null;
            $farmer_group_id = self::sanitizeData($farmer_group_id);

            $gender =  $_REQUEST['gender'] ?? null;
            $gender = self::checkIfEmpty($gender, 'gender');
            $gender = self::sanitizeData($gender);
            
            $contact =  $_REQUEST['contact'] ?? null;
            $contact = self::checkIfEmpty($contact, 'contact');
            $contact = self::sanitizeData($contact);

            $education_level =  $_REQUEST['education_level'] ?? null;
            $education_level = self::checkIfEmpty($education_level, 'education_level');
            $education_level = self::sanitizeData($education_level);

            $parish_id = $_REQUEST['parish'] ?? null;
            $parish = self::checkIfEmpty($parish_id, 'parish');
            $parish_id = self::sanitizeData($parish_id);

            $main_language = $_REQUEST['main_language'] ?? null;
            $main_language = self::checkIfEmpty($main_language, 'main language');
            $main_language = self::sanitizeData($main_language);

            $registered_by = $_REQUEST['registered_by'] ?? null;
            $registered_by = self::checkIfEmpty($registered_by, 'registered_by');
            $registered_by = self::sanitizeData($registered_by);
  
            $nin =  $_REQUEST['nin'] ?? null;
            $nin = self::sanitizeData($nin);
            
            $role =  $_REQUEST['role'] ?? null;
            $role = self::sanitizeData($role);

            $latitude = $_REQUEST['latitude'] ?? null;
            $latitude = self::sanitizeData($latitude);

            
            $secondary_language = $_REQUEST['secondary_language'] ?? null;
            $secondary_language = self::sanitizeData($secondary_language);

            $longitude = $_REQUEST['longitude'] ?? null;
            $longitude = self::sanitizeData($longitude);

            $id_str = uniqid('MAAIF-', true);

            $sql = database::performQuery("INSERT INTO `db_farmers`(`id_str`, `parent_id` ,`name`, `gender`, `parish_id`,
            `nin`, `contact`, `role_id`, `education_level_id`, `main_language`, `secondary_language`, `lat`, `lng`
            ) 
            VALUES ('$id_str', '$farmer_group_id', '$full_name', '$gender', '$parish_id', '$nin', 
            '$contact', '$role', '$education_level', '$main_language', 
            '$secondary_language', '$latitude', '$longitude')");

            
             //making success response
             $response['message'] =  "Data inserted successfully";
             http_response_code(201);
             echo json_encode($response);
        }
        else{

            $response['error']=true;
            $response['message']='This route does not support the supplied HTTP Method';
            http_response_code(400);
            echo json_encode($response);
            return;
        }
    }
























    public function sanitizeData($data){

        $data =  trim($data);
        $data = stripslashes($data);
        $data =  htmlspecialchars($data);

        return $data;
    }

    // Function to check if the field is empty. It takes two parameters, the data and the field name to display
    public function checkIfEmpty($data, $field){

        if(empty($data)){
            $response['error']=true;
            $response['message']='The '.$field.' field is required';
            http_response_code(400);
            echo json_encode($response);
            exit;
        }
        else{
            return $data;
        }
    }



    public static function updateVillageData(){

        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` WHERE village_id=1 LIMIT 1000");
        while($data=$sql->fetch_assoc()){

            $id = $data['id'];

            $sql2 = database::performQuery("SELECT * FROM mod_ediary WHERE a19='$id'");
            while($data2 = $sql2->fetch_assoc())
            {
                $village_id = self::getVillageIDbyName($data2['a5'],$data2['a6'],$data2['a4'],$data2['a7']);

                $sql3 = database::performQuery("UPDATE `ext_area_daily_activity` SET village_id=$village_id WHERE id=$id");
                echo "Fixed ID: $id <br />";
            }
        }



    }



}
