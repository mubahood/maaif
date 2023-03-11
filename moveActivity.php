<?php
require_once './includes/mainRouter.php';
 

function getActivityLocation($district,$subcounty,$parish,$village){

    $sql = database::performQuery("SELECT village.id FROM district,county,subcounty,parish,village
                                        WHERE district.id = county.district_id AND 
                                              county.id =  subcounty.county_id AND 
                                              subcounty.id = parish.subcounty_id AND 
                                              parish.id = village.parish_id AND 
                                              district.name ='$district' AND 
                                              subcounty.name = '$subcounty' AND 
                                              parish.name = '$parish' AND  village.name='$village' ");

    return $sql->fetch_assoc()['id'];

}


function getUserLocation($id){
    $sql = database::performQuery("SELECT * FROM  user   WHERE id=$id ");
    return $sql->fetch_assoc()['district_id'];
}


function getTopicID($topic){

    $sql = database::performQuery("SELECT id FROM `ext_topics` WHERE name = '$topic' ");

        return $sql->fetch_assoc()['id'];

}
function getEntreprizeID($entreprize){

    $sql = database::performQuery("SELECT id FROM `km_category` WHERE name = '$entreprize' ");

        return $sql->fetch_assoc()['id'];

}
function getActivityID($activity){

    $sql = database::performQuery("SELECT id FROM ext_activitys WHERE name = '$activity' ");
       return $sql->fetch_assoc()['id'];

}


function moveToOrignal(){
    $sql = database::performQuery("SELECT * FROM mod_ediary WHERE a23 IS NULL LIMIT 50");
    while($data=$sql->fetch_assoc()){

        //getting details
        $created = $data['a17'];
        $topic = $data['a1'];
        $gps_latitude = $data['a15'];
        $gps_longitude = $data['a16'];
        $entreprise = $data['a3'];
        $subcounty = $data['a6'];
        $village = $data['a7'];
        $notes = $data['a13'];
        $num_ben_males = $data['a11'];
        $num_ben_females = $data['a12'];
        $ben_ref_name = $data['a9'];
        $ben_ref_phone = $data['a10'];
        $ben_group = $data['a8'];
        $user_id = $data['a14'];
        $activity_id = $data['a2'];
        $district = $data['a5'];
        $parish = $data['a4'];


        $sql = database::performQuery("INSERT INTO `activity_daily`(district,parish,`created`, `topic`, `gps_latitude`, `gps_longitude`, `entreprise`,
 	`subcounty`, `village`, `notes`, `num_ben_males`, `num_ben_females`, `ben_ref_name`, `ben_ref_phone`,
	`ben_group`, `user_id`, `activity_id`, `synced`) VALUES
    ('$district','$parish','$created','$topic','$gps_latitude','$gps_longitude','$entreprise','$subcounty','$village','$notes','$num_ben_males','$num_ben_females','$ben_ref_name',
	 '$ben_ref_phone','$ben_group','$user_id','$activity_id','0')
	");

        $sql = database::performQuery("UPDATE mod_ediary SET a23=1 WHERE id=$data[id]");

    }
}


moveToOrignal();

//$sql = database::performQuery("SELECT * FROM activity_daily WHERE synced=0 LIMIT 50");
//if($sql->num_rows>0){
//
//    while($data = $sql->fetch_assoc()){
//
//        $district_id = getUserLocation($data['user_id']);
//
//        $village_id = getActivityLocation(trim($data['district']),trim($data['subcounty']),trim($data['parish']),trim($data['village']));
////        $created = makeMySQLDateTimeTimestamp($data['created']);
//        $topic = getTopicID(trim($data['topic']));
//        $activity = getActivityID(trim($data['activity_id']));
//        $entreprize = getEntreprizeID(trim($data['entreprise']));
//        $num_ben_total =  $data['num_ben_males']+$data['num_ben_females'];
//
//
//
//
//
//
//        $sqlb = database::performQuery("INSERT INTO `ext_area_daily_activity`( `date`, `topic`, `gps_latitude`,
//                                      `gps_longitude`, `entreprise`,  `village_id`,
//                                      `notes`, `num_ben_males`, `num_ben_total`, `num_ben_females`,
//                                      `ben_ref_name`, `ben_ref_phone`, `ben_group`, `user_id`,
//                                      `quarterly_activity_id`, `activity_type`)
//                                      VALUES ('$data[created]','$topic','$data[gps_latitude]',
//                                              '$data[gps_longitude]','$entreprize','$village_id',
//                                              '$data[notes]',$data[num_ben_males],$num_ben_total,$data[num_ben_females],
//                                              '$data[ben_ref_name]','$data[ben_ref_phone]','$data[ben_group]','$data[user_id]',
//                                              '$activity',0)");
//
//
//        $sqlc = database::performQuery("UPDATE activity_daily SET synced=1 WHERE id=$data[id]");
//        echo "Successfully moved  Daily Activity with Reference $data[id]! <br />";
//
// }
//
//
//
//}
//else
//{
//    echo "No new Activities for now!  <br />";
//}
