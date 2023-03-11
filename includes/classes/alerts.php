
<?php 

class alerts 
{


    public static function getAlertsByUser(){

        $id = $_SESSION['user']['location_id'];




        $content = '';
        switch($_SESSION['user']['user_category_id']){

            //National
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:

            $content = "SELECT advisory_alerts.id,advisory_alerts.alert_type,advisory_alerts.alert_type_id,advisory_alerts.language_id,advisory_alerts.status,advisory_alerts.message,advisory_alerts.user_id,advisory_alerts.created_at, count(advisory_outbox.alert_id) as sent_sms
            FROM advisory_alerts left join advisory_outbox on advisory_alerts.id=advisory_outbox.alert_id
            GROUP by advisory_alerts.id                
                   ";

            break;

            //District
            case 2:
            case 3:
            case 4:
            case 10:
            case 11:
            case 12:
            case 14:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:

         $content = "SELECT advisory_alerts.id,advisory_alerts.alert_type,advisory_alerts.alert_type_id,advisory_alerts.language_id,advisory_alerts.status,advisory_alerts.message,advisory_alerts.user_id,advisory_alerts.created_at, count(advisory_outbox.alert_id) as sent_sms
                   FROM advisory_alerts left join advisory_outbox on advisory_alerts.id=advisory_outbox.alert_id
                   WHERE user_id =".$_SESSION['user']['id']."   
                    GROUP by advisory_alerts.id                     
                   ";

                break;


            //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

            $content = "SELECT advisory_alerts.id,advisory_alerts.alert_type,advisory_alerts.alert_type_id,advisory_alerts.language_id,advisory_alerts.status,advisory_alerts.message,advisory_alerts.user_id,advisory_alerts.created_at, count(advisory_outbox.alert_id) as sent_sms
                FROM advisory_alerts join advisory_outbox on advisory_alerts.id=advisory_outbox.alert_id
                   WHERE user_id =  ".$_SESSION['user']['id']."    
                   ORDER BY id DESC                    
                   ";

            break;

            default:
                $content ='';
                break;

        }


        return $content;
    }

    public static function getAlertCategories($type='enterprise',$district_id=0,$county_id=0)
    {
        $content = '';
        
       
        switch($_SESSION['user']['user_category_id']){

            //National ,show both districts and subcounty
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:
            if($type =='enterprise'){
                $content = "select id, name from entreprize_category order by name asc";
            }
            else if($type=='district'){
                $content = "select id,name from district order by name asc";
            }
            else if($type =='subcounty'){
                $content = "select id,name from subcounty where county_id =$county_id";
            } 
            break;

            //District
            case 2:
            case 3:
            case 4:
            case 10:
            case 11:
            case 12:
            case 14:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:
            
            if($type =='enterprise'){
                $content = "select id, name from entreprize_category order by name asc ";
            }
            else if($type=='district'){
                $content = "select id,name from district where id = ".$_SESSION['user']['district_id']."";
            }
            else if($type =='subcounty'){
                //get counties in district
                $county_ids_array = array();;
                $c = database::performQuery("select id from county where district_id=".$_SESSION['user']['district_id']."");
                while($dd = $c->fetch_assoc())
                {
                    $county_ids_array[] = $dd['id'];
                }
                $county_ids = implode(",",$county_ids_array);
                $content = "select id,name from subcounty where county_id in ($county_ids)";
            }  
            break;


            //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

            if($type =='enterprise'){
                $content = "select id, name from entreprize_category order by name asc";
            }
            else if($type=='district'){
                $content = "select id,name from district where id = ".$_SESSION['user']['district_id']."";
            }
            else if($type =='subcounty'){
                $content = "select id,name from subcounty where id =".$_SESSION['user']['location_id']."";
            }

            break;

            default:
                $content ='';
                break;

        }

        return $content;
    }


    public static function getAlerts(){



        $sql = database::performQuery(self::getAlertsByUser());
        
               $rt =  '';
        if($sql->num_rows > 0){

        while($data=$sql->fetch_assoc()){

           


            $rt .='<tr>
                                                <td><a href="">'.$data['id'].'</a></td>
                                                <td><a href="">'.$data['alert_type'].'</a> </td>
                                                <td>'.$data['message'].'</td>
                                                <td>'.$data['status'].' </td>
                                                <td>'.$data['sent_sms'].' </td>
                                                <td>'.$data['created_at'].'</td>
                                                <td><a href="#"></td>
                                            </tr>';
        }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>
                    <td>None.</td>
                    </tr>';
        }

        return $rt;
    }   
    
public static function showAvailableAlertTypes()
{
    $content = '';
    $type = $_GET['type'] ?? null;
    $e_selected =  ($type == 'enterprise')? 'selected' : '';
    $d_selected =  ($type == 'district')? 'selected' : '';
    $s_selected =  ($type == 'subcounty')? 'selected' : '';
        switch($_SESSION['user']['user_category_id']){

            //National
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:
             
            
            $content = ($type == 'subcounty') ? "<div class='col-md-3'>
            <div class='form-group'><label class='control-label'>Advisory For</label><select id='select-alert-type' class='form-control' name='type'>                           
                            <option ".$e_selected." value='enterprise'>Enterprise</option>
                            <option ".$d_selected." value='district'>District</option>
                            <option ".$s_selected." value='subcounty'>Subcounty</option>
                        </select></div></div>" : "<div class='col-md-3'>
                        <div class='form-group'><label class='control-label'>Advisory For</label><select id='select-alert-type' class='form-control' name='type'>                           
                        <option ".$e_selected." value='enterprise'>Enterprise</option>
                        <option ".$d_selected." value='district'>District</option>
                        <option ".$s_selected." value='subcounty'>Subcounty</option>
                    </select></div></div>";

            break;

            //District
            case 2:
            case 3:
            case 4:
            case 10:
            case 11:
            case 12:
            case 14:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:

                $content = "<div class='col-md-3'>
                <div class='form-group'><label class='control-label'>Advisory For</label><select id='select-alert-type' class='form-control' name='type'>                               
                                <option ".$e_selected." value='enterprise'>Enterprise</option>                
                                <option ".$s_selected." value='subcounty'>Subcounty</option>
                            </select></div></div>";

                break;


            //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

                $content = "<div class='col-md-3'>
                <div class='form-group'><label class='control-label'>Advisory For</label><select id='select-alert-type' class='form-control' name='type'>                                
                                <option ".$e_selected." value='enterprise'>Enterprise</option>                                
                                <option ".$s_selected." value='subcounty'>Subcounty</option>
                            </select></div></div>";

            break;

            default:
                $content ='';
                break;

        }


        return $content;
}  

public static function showAlertTypeData()
{
    $type = $_GET['type'] ?? 'enterprise';    

    $sql = database::performQuery(self::getAlertCategories($type));
    if($type == 'subcounty' && ($_SESSION['user']['user_category_id'] == 6 || $_SESSION['user']['user_category_id'] == 15 ||
                                $_SESSION['user']['user_category_id'] == 16 || $_SESSION['user']['user_category_id'] == 17 ||
                                $_SESSION['user']['user_category_id'] == 18 || $_SESSION['user']['user_category_id'] == 5))
                                {

              $s = database::performQuery("select * from district  order by name asc");
              $rt = '<div class="col-md-3">
              <div class="form-group"><label class="control-label"> District</label><select class="form-control" id="sel_district">';
              while($dd = $s->fetch_assoc()){
                  $rt.='<option value="'.$dd['id'].'">'.$dd['name'].'</option>';
              }   
              $rt .='</select></div></div><div class="col-md-3">
              <div class="form-group"><label class="control-label"> County</label><select class="form-control" id="sel_county"></select></div></div><div class="col-md-3">
              <div class="form-group"><label class="control-label"> Sub County</label><select class="form-control" name="type_id" id="sel_subcounty"></select></div></div>';  
              return $rt;                 
    }
    else {
        $rt =  '<div class="col-md-3">
        <div class="form-group"><label class="control-label">Select</label><select name="type_id" class="form-control">';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){      


                $rt .='<option value="'.$data['id'].'">'.$data['name'].'</option>';
            }
        }
        else
        {
            $rt .= '';
        }

        return $rt.'</select></div></div>';
    }
}

public static function showLanguageSelector()
{
    $sql = database::performQuery("select id,name from km_language");
    $rt =  '<div class="col-md-3">
        <div class="form-group"><label class="control-label">Language</label><select name="language" class="form-control"><option value="NULL">any</option>';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){      


                $rt .='<option value="'.$data['id'].'">'.$data['name'].'</option>';
            }
        }
        else
        {
            $rt .= '';
        }

        return $rt.'</select></div></div>';
}

public static function viewAlerts()
{
    $form_alert = '<div class="card">
    <div class="card-header bg-info">
        <h4 class="m-b-0 text-white">Send Advisory</h4>
    </div> 
    <div class="card-body"> ';
    if(isset($_SESSION['success_message']))
    {
        $success_message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        $form_alert .= '<div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>'.$success_message.'</strong> .
                        </div>
                        </div>';
    }
    $form_alert .= '<div class="col-lg-12">
   <form method="post" action="'. ROOT . '/?action=sendAlert">
      <div class="row p-t-20"> 
        '.self::showAvailableAlertTypes().'
        '.self::showAlertTypeData().'
        '.self::showLanguageSelector().'
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Advisory Message</label><textarea required name="message" class="form-control">This is my advisory message</textarea>
            </div>
        </div>
      </div>  
       <button class="btn btn-success" type="submit">Send</button>
   </form>
    </div>
    <script>    
    const selectElement = document.querySelector("#select-alert-type");

    selectElement.addEventListener("change", (event) => {
        const vs = event.target.value;
        const new_url = "'. ROOT . '/?action=viewAlerts&type="+vs
        window.location.href = new_url
    });

    </script>
    </div>
    </div>';

         $content = $form_alert.'<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                
                                                <th>Type</th>
                                                <th>Message</th>
                                                <th>Status</th> 
                                                <th>No of Farmers sent to</th>
                                                <th>Created</th>                                                
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAlerts().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Type</th>
                                                <th>Message</th>
                                                <th>Status</th> 
                                                <th>No of Farmers sent to</th>
                                                <th>Created</th>                                               
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;
    }

    public static function saveAlert()
    {
        $message = $_POST['message'];
        $alert_type = $_POST['type'];
        $alert_type_id = $_POST['type_id'];
        $user_id = $_SESSION['user']['id'];
        $created_at = date('Y-m-d H:i:s');
        $language_id = $_POST['language'] ?? 'NULL';

        
        $sql = database::performQuery("INSERT into `advisory_alerts`(`alert_type`,`alert_type_id`,`language_id`,`message`,`user_id`,`created_at`,`updated_at`) VALUES('$alert_type','$alert_type_id',$language_id,'$message','$user_id','$created_at','$created_at')");
       
        $_SESSION["success_message"] = "successfully saved alert, it will be sent out to the recipients";
        
         redirect_to(ROOT.'/?action=viewAlerts');


    }

    public static function saveUserAlert()
    {
        $message = $_POST['message'];
        $alert_type = $_POST['type'];
        $alert_type_id = $_SESSION['user']['id'];
        $custom_numbers = $_POST['custom_numbers'] ?? 'NULL';
        $user_id = $_SESSION['user']['id'];
        $created_at = date('Y-m-d H:i:s');
        $language_id = $_POST['language'] ?? 'NULL';

        
        $sql = database::performQuery("INSERT into `advisory_alerts`(`alert_type`,`alert_type_id`,`language_id`,`message`,`user_id`,`created_at`,`updated_at`,`custom_numbers`) VALUES('$alert_type','$alert_type_id',$language_id,'$message','$user_id','$created_at','$created_at','$custom_numbers')");
       
        $_SESSION["success_message"] = "successfully saved alert, it will be sent out to the recipients";
        
         redirect_to(ROOT.'/?action=manageUsers');


    }

    public static function processAlerts()
    {
        //get token
        $t = database::performQuery("select bearer from sms_api_keys where gateway='nita' limit 1");
        $tr = $t->fetch_assoc();
        $bearer = $tr['bearer'];
        $created_at = date('Y-m-d H:i:s');

        $pending_alerts = database::performQuery("SELECT * from advisory_alerts where status='pending' limit 10");

        while($pending_alert = $pending_alerts->fetch_assoc())
        {
            $alert_id = $pending_alert['id'];
            $alert_message = $pending_alert['message'];
            $language_id = $pending_alert['language_id'];
            switch($pending_alert['alert_type']){
                case 'enterprise' :
                    $ent_id = $pending_alert['alert_type_id'];
                    $sending_status = 'pending';
                    $sent_count = 0;
                   
                    //get farmers who have that enterprise // for now use groups
                    
                    $fs = (!$language_id)? database::performQuery("select distinct db_farmers.contact from db_farmer_groups join db_farmers on db_farmer_groups.id = db_farmers.parent_id join farmer_group_enterprises on db_farmer_groups.id=farmer_group_enterprises.farmer_group_id where farmer_group_enterprises.enterprise_id= $ent_id") : database::performQuery("select distinct db_farmers.contact from db_farmer_groups join db_farmers on db_farmer_groups.id = db_farmers.parent_id join farmer_group_enterprises on db_farmer_groups.id=farmer_group_enterprises.farmer_group_id where farmer_group_enterprises.enterprise_id= $ent_id and db_farmers.main_language=$language_id");
                    $num_farmers = $fs->num_rows;
                    while($farmer = $fs->fetch_assoc())
                    {
                        $farmer_telephone = $farmer['contact'];
                       
                        if(strlen($farmer_telephone) > 9)
                        {
                            //check if contact has already been sent number.
                            
                            
                            $as = database::performQuery("select id from advisory_outbox where telephone='$farmer_telephone' and alert_id=$alert_id");
                            if($as->num_rows < 1)
                            {
                                $sending_status = 'pending';
                                $ms_result = self::send_sms($farmer_telephone,$alert_message,$alert_id);
                                if($ms_result){
                                    $sent_count++;
                                    $sending_status = 'processed';
                                }
                                    
                            }
                        }
                        else{
                            
                            
                        }
                    }
                    if($sent_count >= $num_farmers || $sending_status == 'processed')
                    {
                        $l = database::performQuery("UPDATE `advisory_alerts` set status='processed' where id=$alert_id");
                    }
                    
                    break;


                    case 'subcounty' :
                        $ent_id = $pending_alert['alert_type_id'];
                        $sending_status = 'pending';
                        $sent_count = 0;
                       
                        //get farmers who belong to that subcounty 
                        $fs = (!$language_id) ? database::performQuery("select distinct db_farmers.contact from  db_farmers join parish on db_farmers.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id WHERE subcounty.id =  ".$ent_id. "") : database::performQuery("select distinct db_farmers.contact from  db_farmers join parish on db_farmers.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id WHERE subcounty.id =  ".$ent_id. " and db_farmers.main_language=$language_id");
                        $num_farmers = $fs->num_rows;
                        while($farmer = $fs->fetch_assoc())
                        {
                            $farmer_telephone = $farmer['contact'];
                           
                            if(strlen($farmer_telephone) > 9)
                            {
                                //check if contact has already been sent number.
                                
                                
                                $as = database::performQuery("select id from advisory_outbox where telephone='$farmer_telephone' and alert_id=$alert_id");
                                if($as->num_rows < 1)
                                {
                                    $sending_status = 'pending';
                                    $ms_result = self::send_sms($farmer_telephone,$alert_message,$alert_id);
                                            if($ms_result){
                                                $sent_count++;
                                                $sending_status = 'processed';
                                            }
                                        
                                }
                            }
                            else{
                                
                                
                            }
                        }
                        if($sent_count >= $num_farmers || $sending_status == 'processed')
                        {
                            $l = database::performQuery("UPDATE `advisory_alerts` set status='processed' where id=$alert_id");
                        }
                        
                        break;

                        case 'district' :
                            $ent_id = $pending_alert['alert_type_id'];
                            $sending_status = 'pending';
                            $sent_count = 0;
                           
                            //get farmers who belong to that subcounty 
                            $fs = (!$language_id) ? database::performQuery("select distinct db_farmers.contact from  db_farmers join parish on db_farmers.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id WHERE district.id =  ".$ent_id. "") : database::performQuery("select distinct db_farmers.contact from  db_farmers join parish on db_farmers.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id WHERE district.id =  ".$ent_id. " and db_farmers.main_language=$language_id");
                            $num_farmers = $fs->num_rows;
                            while($farmer = $fs->fetch_assoc())
                            {
                                $farmer_telephone = $farmer['contact'];
                               
                                if(strlen($farmer_telephone) > 9)
                                {
                                    //check if contact has already been sent number.
                                    
                                    
                                    $as = database::performQuery("select id from advisory_outbox where telephone='$farmer_telephone' and alert_id=$alert_id");
                                    if($as->num_rows < 1)
                                    {
                                        $sending_status = 'pending';
                                        $ms_result = self::send_sms($farmer_telephone,$alert_message,$alert_id);
                                            if($ms_result){
                                                $sent_count++;
                                                $sending_status = 'processed';
                                            }
                                            
                                    }
                                }
                                else{
                                    
                                    
                                }
                            }
                            if($sent_count >= $num_farmers || $sending_status == 'processed')
                            {
                                $l = database::performQuery("UPDATE `advisory_alerts` set status='processed' where id=$alert_id");
                            }
                            
                            break;


                            case 'user' :                                
                                $user_id = $pending_alert['alert_type_id'];
                                $content = '';
                                $sending_status = 'pending';
                                $sent_count = 0;

                                //get user details 
                                $usq = database::performQuery("select * from user where id = $user_id limit 1");
                                while($data = $usq->fetch_assoc()){
                                    $user_category_id = $data['user_category_id'];
                                    $subcounty_id = $data['location_id'];
                                    $district_id = $data['district_id'];
                                }

                                switch($user_category_id){


                                    case 1:
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,subcounty,county,user
                                           WHERE district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                           AND subcounty.id = user.location_id
                                           AND subcounty.id = $subcounty_id
                                           AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                                           ";
                                        break;
                        
                        
                                    case 11:
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,user,county,subcounty
                                           WHERE district.id = ".$district_id."
                                           AND district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                            AND subcounty.id = user.location_id                   
                                           AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9 OR user_category_id = 2 OR user_category_id = 3 OR user_category_id = 4  OR user_category_id = 10 )
                                      
                                           ";
                                        break;
                        
                        
                                    case 10:
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,user,county,subcounty
                                           WHERE district.id = ".$district_id."
                                           AND district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                            AND subcounty.id = user.location_id                   
                                           AND (user_category_id = 10  OR user_category_id = 2  OR user_category_id = 3  OR user_category_id = 4  OR user_category_id = 12  OR user_category_id = 7  OR user_category_id = 8 OR user_category_id = 24 OR user_category_id = 25 OR user_category_id = 9 OR user_category_id = 2 OR user_category_id = 3 OR user_category_id = 4  OR user_category_id = 11  OR user_category_id = 12 OR user_category_id = 13  OR user_category_id = 14  OR user_category_id = 12  OR user_category_id = 19  OR user_category_id = 20  OR user_category_id = 21  OR user_category_id = 22  OR user_category_id = 23 OR user_category_id = 1)
                                      
                                           ";
                                        break;
                        
                                    case 6:
                                    case 5:
                                    case 15:
                        
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,user,county,subcounty
                                           WHERE  district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                            AND subcounty.id = user.location_id                   
                                          
                                           ";
                        
                        
                                        break;
                        
                                    case 16:
                        
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,user,county,subcounty
                                           WHERE  district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                            AND subcounty.id = user.location_id                   
                                            AND (user_category_id = 9 OR user_category_id = 20 OR user_category_id = 3 OR user_category_id = 10 OR user_category_id = 23 )
                                           ";
                        
                        
                                        break;
                        
                        
                                    case 17:
                        
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,user,county,subcounty
                                           WHERE  district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                            AND subcounty.id = user.location_id                   
                                            AND  (user_category_id = 8 OR user_category_id = 19 OR user_category_id = 22 OR user_category_id = 2 OR user_category_id = 10)
                                           ";
                        
                        
                                        break;
                        
                                    case 18:
                        
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,user,county,subcounty
                                           WHERE  district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                            AND subcounty.id = user.location_id                   
                                            AND (user_category_id = 7 OR user_category_id = 21  OR user_category_id = 4  OR user_category_id = 10 )
                                           ";
                        
                        
                                        break;
                        
                                    case 2:
                                    case 3:
                                    case 4:
                                        $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category_id
                                           FROM district,subcounty,county,user
                                           WHERE district.id =county.district_id
                                           AND county.id = subcounty.county_id
                                           AND subcounty.id = user.location_id
                                           AND district.id =  ".$district_id."
                                           AND  (user_category_id = 7 OR user_category_id = 21)
                                           ";
                        
                                        break;
                        
                                    default:
                                        $content ='';
                                        break;
                        
                                }
                               
                                //get users who he supervises 
                                $fs =  database::performQuery($content);
                                $num_farmers = $fs->num_rows;
                                while($farmer = $fs->fetch_assoc())
                                {
                                    $farmer_telephone = $farmer['phone'];
                                   
                                    if(strlen($farmer_telephone) > 9 /* also check if valid */)
                                    {
                                        //check if contact has already been sent number.
                                        
                                        
                                        $as = database::performQuery("select id from advisory_outbox where telephone='$farmer_telephone' and alert_id=$alert_id");
                                        if($as->num_rows < 1)
                                        {
                                            $sending_status = 'pending';
                                            $ms_result = self::send_sms($farmer_telephone,$alert_message,$alert_id);
                                            if($ms_result){
                                                $sent_count++;
                                                $sending_status = 'processed';
                                            }
                                                
                                        }
                                    }
                                    else{
                                        
                                        
                                    }
                                }
                                if($sent_count >= $num_farmers || $sending_status == 'processed')
                                {
                                    $l = database::performQuery("UPDATE `advisory_alerts` set status='processed' where id=$alert_id");
                                }
                                
                                break;

                    case 'custom' :                                
                        $user_id = $pending_alert['alert_type_id'];
                        $number_string = $pending_alert['custom_numbers'];
                        $sending_status = 'pending';
                        $sent_count = 0; 
                        $numbers = explode(",",$number_string);
                        $num_farmers = count($numbers);
                        foreach($numbers as $number)
                        {
                            if(strlen($number) > 9 /* also check if valid */)
                            {
                                        //check if contact has already been sent number.                                        
                                        
                                    $as = database::performQuery("select id from advisory_outbox where telephone='$number' and alert_id=$alert_id");
                                    if($as->num_rows < 1)
                                    {
                                        $sending_status = 'pending';
                                        $ms_result = self::send_sms($number,$alert_message,$alert_id);
                                            if($ms_result){
                                                $sent_count++;
                                                $sending_status = 'processed';
                                            }
                                            
                                            
                                    }
                                }
                                else{
                                    
                                    
                                }
                        } 
                        if($sent_count >= $num_farmers || $sending_status == 'processed')
                        {
                                    $l = database::performQuery("UPDATE `advisory_alerts` set status='processed' where id=$alert_id");
                        }
                                
                        break;      
            }
        }
    }

    public static function send_sms($number,$alert_message,$alert_id=0)
    {
        $created_at = date('Y-m-d H:i:s');
        $result = self::send_sms_niita($number,$alert_message);
        if(!$result)
        {
            //get token
            echo "expired token";
           $token = self::get_sms_token();
           if($token)
           {
            $result = self::send_sms_niita($number,$alert_message);
           }
        }
        if($result)
        {
            $sql = database::performQuery("INSERT into `advisory_outbox`(`alert_id`,`telephone`,`gateway_reference`,`created_at`) VALUES('$alert_id','$number','$result','$created_at')");
            return true;
        }
        return false;
    }

    private static function get_sms_token()
    {
        $t = database::performQuery("select id,bearer,userid,password,email from sms_api_keys where gateway='nita' limit 1");
        $tr = $t->fetch_assoc();
        $bearer = $tr['bearer'];
        $nita_userid = $tr['userid'];
        $nita_password = $tr['password'];
        $nita_email = $tr['email'];
        $id = $tr['id'];
        //get token 
        $url_t = "https://msdg.uconnect.go.ug/api/v1/get-jwt-token/";        
        $curl_t = curl_init($url_t);
        curl_setopt($curl_t, CURLOPT_URL, $url_t);
        curl_setopt($curl_t, CURLOPT_RETURNTRANSFER, true);

        $headers_t = array(
        "Accept: application/json",
        "Content-Type:application/json",
        );
        curl_setopt($curl_t, CURLOPT_HTTPHEADER, $headers_t);
        //for debug only!
        curl_setopt($curl_t, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_t, CURLOPT_SSL_VERIFYPEER, false);

        // Setup request to send json via POST
        $data_t = array(
            'userid' => $nita_userid,
            'password' => $nita_password,
            'email' => $nita_email
        );
        $payload_t = json_encode($data_t);

        // Attach encoded JSON string to the POST fields
        curl_setopt($curl_t, CURLOPT_POSTFIELDS, $payload_t);

        

        $resp_t = curl_exec($curl_t);
        curl_close($curl_t);
        $r_object_t = json_decode($resp_t,true);
        $new_token = $r_object_t['token'] ?? 'none';
        if($new_token !== 'none')
        {
            $sql = "UPDATE `sms_api_keys` SET `bearer` = '$new_token' WHERE `sms_api_keys`.`id` = $id ";
            database::performQuery($sql);
            echo "saved new token";
            return true;
        }
        else{
            echo "failed to get token";
            return false;
        }
    }

    private static function send_sms_niita($number,$message)
    {
        //get token
        $t = database::performQuery("select bearer from sms_api_keys where gateway='nita' limit 1");
        $tr = $t->fetch_assoc();
        $bearer = $tr['bearer'];
        //try sending if failed,get token, save it and send again
        $url = "https://msdg.uconnect.go.ug/api/v1/sms/";
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Accept: application/json",
        "Content-Type:application/json",
        "Authorization: JWT {$bearer}",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // Setup request to send json via POST
        $data = array(
            'sender' => '6120',
            'receiver' => $number,
            'text' => $message
        );
        $payload = json_encode($data);

        // Attach encoded JSON string to the POST fields
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

        

        $resp = curl_exec($curl);
        curl_close($curl);
        $r_object = json_decode($resp,true);
        $reference = $r_object['uuid'] ?? 'none';
        if($reference == 'none')
        {
            
            return false;
        }
        return $reference;
    }


}
