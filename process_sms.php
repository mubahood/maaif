<?php
include("includes/classes/database.php");

$sql = "select * from incoming_sms where has_error=0 and is_transferred=0 limit 100";
$result = database::performQuery($sql);
$smses = $result->fetch_all(MYSQLI_ASSOC);

foreach($smses as $sms)
{
    
    $id = $sms['id'];
    $telephone = $sms['mobile'];
    $message = $sms['message'];
    $created_at = date('Y-m-d H:i:s');
    $ins = "INSERT INTO `farmer_questions` (`telephone`, `body`, `sender`, `created_at`, `updated_at`) VALUES ( '$telephone', '$message', 'sms', '$created_at', '$created_at') ";
    // check if farmer exists 
    $check_farmer_exists = "select id,parish_id from db_farmers where contact='$telephone' limit 1";
    $r = database::performQuery($check_farmer_exists);
    if($r->num_rows > 0){
        $found_farmer = $r->fetch_assoc(); 
        $farmer_parish = $found_farmer['parish_id'];
        $farmer_id = $found_farmer['id'];
        $ins = "INSERT INTO `farmer_questions` (`farmer_id`,`parish_id`,`telephone`, `body`, `sender`, `created_at`, `updated_at`) VALUES ($farmer_id,$farmer_parish, '$telephone', '$message', 'sms', '$created_at', '$created_at') ";
    }   

    $result = database::performQuery($ins);

    //update 
    $update_string = "UPDATE `incoming_sms` SET `is_transferred` = '1' where `id` = $id ";
    database::performQuery($update_string);
}