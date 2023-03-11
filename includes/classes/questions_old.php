
<?php 

class questions 
{

    public static function conGRM(){

        //$con = new mysqli('localhost','root','','grm_db');
        $con = new mysqli('localhost','hosteern_user','Makaveli@123??','hosteern_grm');
        return $con;
    }

    public static function getGrievanceNature($id){
        $sql = self::conGRM()->query("SELECT name FROM grievance_nature WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getGrievanceType($id){
        $sql = self::conGRM()->query("SELECT name FROM grivance_type WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getGrievanceMOR($id){
        $sql = self::conGRM()->query("SELECT name FROM mode_of_receipt WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getGrievanceFB($id){
        $sql = self::conGRM()->query("SELECT name FROM feedback_mode WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getGrievanceStatus($id){
        $sql = self::conGRM()->query("SELECT * FROM `grivance_status` WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getGrievanceSettlementOtherwise($id){
        $sql = self::conGRM()->query("SELECT * FROM `grievance_settle_otherwise` WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getGrievanceSettlementHow($id){
        $sql = self::conGRM()->query("SELECT * FROM `grivance_settlement` WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getQuestionsByLocation(){

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

            $content = "SELECT *
                   FROM farmer_questions
                   ORDER BY id DESC                
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

         $content = 
                   $content = "SELECT farmer_questions.image_one,farmer_questions.image_two,farmer_questions.image_three,farmer_questions.id,farmer_questions.keyword,farmer_questions.farmer_id,farmer_questions.telephone,farmer_questions.body,farmer_questions.sender,farmer_questions.created_at
                   FROM farmer_questions left join parish on farmer_questions.parish_id=parish.id left join subcounty on parish.subcounty_id=subcounty.id left join county on subcounty.county_id = county.id left join district on county.district_id=district.id
                          WHERE farmer_questions.parish_id is null or district.id =  ".$_SESSION['user']['district_id']."    
                          ORDER BY farmer_questions.id DESC                    
                          ";

                break;


            //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

                    $content = "SELECT farmer_questions.image_one,farmer_questions.image_two,farmer_questions.image_three,farmer_questions.id,farmer_questions.keyword,farmer_questions.farmer_id,farmer_questions.telephone,farmer_questions.body,farmer_questions.sender,farmer_questions.created_at
                   FROM farmer_questions left join parish on farmer_questions.parish_id=parish.id left join subcounty on parish.subcounty_id=subcounty.id 
                          WHERE farmer_questions.parish_id is null or subcounty.id =  ".$_SESSION['user']['location_id']."    
                          ORDER BY farmer_questions.id DESC                    
                          ";       

            break;

            default:
                $content ='';
                break;

        }


        return $content;
    }

    public static function getResponsesPerUser($question_id = null)
    {
        $specific_question = (!is_null($question_id)) ? "and farmer_question_responses.farmer_question_id=$question_id" : "";
        //where user_id = ".$_SESSION['user']['id']."
        $content = '';
        switch($_SESSION['user']['user_category_id']){

            //National
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:

            $content = "SELECT farmer_question_responses.id,response,user_id,farmer_question_id,body,farmer_question_responses.created_at
                   FROM farmer_question_responses join farmer_questions on farmer_question_responses.farmer_question_id = farmer_questions.id where user_id is not null $specific_question";

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

         $content =  "SELECT farmer_question_responses.id,response,user_id,farmer_question_id,body,farmer_question_responses.created_at
                   FROM farmer_question_responses join farmer_questions on farmer_question_responses.farmer_question_id = farmer_questions.id where user_id is not null $specific_question";

                break;


            //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

                $content = "SELECT farmer_question_responses.id,response,user_id,farmer_question_id,body,farmer_question_responses.created_at
                FROM farmer_question_responses join farmer_questions on farmer_question_responses.farmer_question_id = farmer_questions.id where user_id is not null $specific_question";     

            break;

            default:
                $content ='';
                break;

        }


        return $content;
    }


    public static function getFarmerQuestions(){



        $sql = database::performQuery(self::getQuestionsByLocation());
               $rt =  '';
        if($sql->num_rows > 0){

        while($data=$sql->fetch_assoc()){
            $farmer = "UNPROFILED";
           if($data['farmer_id']){
               $fid = $data['id'];
               $sql_f = "select name from db_farmers where id=$fid limit 1";
               $r = database::performQuery($sql_f);
               $rf = $r->fetch_assoc();
               $farmer = $rf['name'];
           }

           $img = "<ul>";
           if($data['image_one'])
           {
               $img.="<li><img class='img img-thumbnail' src='".ROOT."/images/questions/".$data['image_one']."' /></li>";
           }
           if($data['image_two'])
           {
               $img.="<li><img class='img img-thumbnail' src='".ROOT."/images/questions/".$data['image_two']."' /></li>";
           }
           if($data['image_three'])
           {
               $img.="<li><img class='img img-thumbnail' src='".ROOT."/images/questions/".$data['image_three']."' /></li>";
           }
            $rt .='<tr>
                                                <td><a href="">'.$data['id'].'</a></td>
                                                <td><a href="">'.$farmer.'</a> </td>
                                                <td>'.$data['telephone'].'</td>
                                                <td>'.$data['body'].' </td>
                                                <td>'.$data['keyword'].'</td>
                                                <td>'.$data['sender'].'</td>
                                                <td>'.$img.'</td>
                                                <td>'.$data['created_at'].'</td>
                                                
                                                <td><a href="?action=viewResponses&question='.$data['id'].'">Reply</td>
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
                    <td>None.</td>
                    <td>None.</td>  
                    </tr>';
        }

        return $rt;
    }    

public static function viewQuestions()
{
              $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addQuestion">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Question</button>
                    </a>
                    <br />
                    <br />
                    </div>';

         $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                
                                                <th>Farmer</th>
                                                <th>Telephone</th>
                                                <th>Question</th>
                                                <th>Keyword</th>
                                                <th>Sent Via</th>
                                                <th>Images</th>
                                                <th>Created</th>                                                
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getFarmerQuestions().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Farmer</th>
                                                <th>Telephone</th>
                                                <th>Question</th>
                                                <th>Keyword</th>
                                                <th>Sent Via</th>
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

    public static function getQuestionResponses($question_id){



        $sql = database::performQuery(self::getResponsesPerUser($question_id));
               $rt =  '';
        if($sql->num_rows > 0){

        while($data=$sql->fetch_assoc()){
            $answered_by = "SYSTEM";
           if($data['user_id']){
               $fid = $data['user_id'];
               $sql_f = "select first_name,last_name from user where id=$fid limit 1";
               $r = database::performQuery($sql_f);
               $rf = $r->fetch_assoc();
               $answered_by = $rf['first_name']." ".$rf['last_name'];
           }


            $rt .='<tr>
                                                <td><a href="">ID-'.$data['id'].'</a></td>
                                                <td><a href="">'.$data['body'].'</a> </td>
                                                <td>'.$data['response'].'</td>
                                                <td>'.$answered_by.' </td>
                                                <td>'.$data['created_at'].'</td>
                                                <td><a href=""></td>
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
                    </tr>';
        }

        return $rt;
    } 

    public static function viewResponses($question_id)
{
              $form_response = '<div class="col-lg-12">
                    <h5>Type your response to question below and send</h5>
                   <form method="post" action="'. ROOT . '/?action=replyQuestion&id='.$question_id.'">
                        <input type="hidden" name="question_id" value="'.$question_id.'" />
                        <textarea required name="response" class="form-control">This is my reply</textarea>
                        <button class="btn btn-success" type="submit">Send</button>
                   </form>
                    </div>';

         $content = '<div class="row">'.$form_response.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                
                                                <th>Question</th>
                                                <th>Response</th>
                                                <th>Answered By</th>
                                                <th>Time</th>                                                
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getQuestionResponses($question_id).'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Question</th>
                                                <th>Response</th>
                                                <th>Answered By</th>
                                                <th>Time</th>                                                
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

    public static function sendQuestionResponse($id)
    {
        $message = $_POST['response'];
        $question_id = $_POST['question_id'];
        $user_id = $_SESSION['user']['id'];
        $created_at = date('Y-m-d H:i:s');

        //get phone number.
        $p = database::performQuery("select telephone from farmer_questions where id=$question_id limit 1");
        $r = $p->fetch_assoc();
        $farmer_telephone = $r['telephone'];

        $sql = database::performQuery("INSERT into `farmer_question_responses`(`farmer_question_id`,`response`,`user_id`,`created_at`,`updated_at`) VALUES('$question_id','$message','$user_id','$created_at','$created_at')");

        //send sms via api

        
        

        alerts::send_sms($farmer_telephone,$message);

        


         redirect_to(ROOT.'/?action=viewResponses&question='.$question_id.'');


    }


    public static function apiGetQuestions()
    {
        

        if (isset($_REQUEST['uid']) && is_numeric($_REQUEST['uid'])) {

            // receiving the REQUEST params
            $id = database::prepData($_REQUEST['uid']);
            $user = [];            
            $sql_user_details = database::performQuery("select location_id,district_id,user_category_id from user where id =$id limit 1");
            if($sql_user_details->num_rows > 0)
            {
                $response = [];
                $questions = [];
                while($data=$sql_user_details->fetch_assoc()){
                        $user['id'] = $id;
                        $user['location_id'] = $data['location_id'];
                        $user['user_category_id'] = $data['user_category_id'];
                        $user['district_id'] = $data['district_id'];
                }
                
                switch($user['user_category_id']){

                    //National
                    case 6:
                    case 15:
                    case 16:
                    case 17:
                    case 18:
                    case 5:                        
        
                    $content = database::performQuery("SELECT farmer_questions.image_one,farmer_questions.image_two,farmer_questions.image_three,farmer_questions.id, farmer_questions.keyword,farmer_questions.farmer_id,farmer_questions.parish_id,farmer_questions.telephone,farmer_questions.body,farmer_questions.sender,farmer_questions.other,farmer_questions.has_media,farmer_questions.enterprise_id,farmer_questions.inquiry_source,farmer_questions.created_at,farmer_questions.user_id,db_farmers.name, count(farmer_question_responses.id) as responses FROM farmer_questions left join db_farmers on farmer_questions.farmer_id=db_farmers.id left join farmer_question_responses on farmer_questions.id=farmer_question_responses.farmer_question_id GROUP BY farmer_questions.id ORDER BY farmer_questions.id DESC ");
                    
                    while($data=$content->fetch_assoc()){
                        array_push($questions,[
                            'id' => $data['id'],
                            'farmer_id' => $data['farmer_id'],
                            'keyword' => $data['keyword'],
                            'parish_id' => $data['parish_id'],
                            'telephone' => $data['telephone'],
                            'body' => $data['body'],
                            'sender' => $data['sender'],
                            'other' => $data['other'],
                            'has_media' => $data['has_media'],
                            'media_url' => $data['image_one'] ? ROOT."/images/questions/".$data['image_one']: '',
                            'media_url2' => $data['image_two'] ? ROOT."/images/questions/".$data['image_two']: '',
                            'media_url3' => $data['image_three'] ? ROOT."/images/questions/".$data['image_three']: '',
                            'enterprise_id' => $data['enterprise_id'],
                            'inquiry_source' => $data['inquiry_source'],
                            'farmer' => (!$data['name']) ? 'UNREGISTERED' : $data['name'],
                            'responses' => $data['responses'] ?? 0,
                            'created_at' => $data['created_at'],
                            'updated_at' => $data['created_at'],
                            'user_id' => $data['user_id'],
                        ]);

                      
                    }
                    $response['questions'] = $questions;
        
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
        
                 $content = database::performQuery("SELECT farmer_questions.image_one,farmer_questions.image_two,farmer_questions.image_three,farmer_questions.id, farmer_questions.keyword,farmer_questions.farmer_id,farmer_questions.parish_id,farmer_questions.telephone,farmer_questions.body,farmer_questions.sender,farmer_questions.other,farmer_questions.has_media,farmer_questions.enterprise_id,farmer_questions.inquiry_source,farmer_questions.created_at,farmer_questions.user_id,db_farmers.name, count(farmer_question_responses.id) as responses FROM farmer_questions left join db_farmers on farmer_questions.farmer_id=db_farmers.id left join farmer_question_responses on farmer_questions.id=farmer_question_responses.farmer_question_id left join parish on farmer_questions.parish_id=parish.id left join subcounty on parish.subcounty_id=subcounty.id left join county on subcounty.county_id = county.id left join district on county.district_id=district.id
                                  WHERE farmer_questions.parish_id is null or district.id =  ".$user['district_id']."    
                                  GROUP BY farmer_questions.id ORDER BY farmer_questions.id DESC                    
                                  ");
                
                while($data=$content->fetch_assoc()){
                    array_push($questions,[
                        'id' => $data['id'],
                        'farmer_id' => $data['farmer_id'],
                        'keyword' => $data['keyword'],
                        'parish_id' => $data['parish_id'],
                        'telephone' => $data['telephone'],
                        'body' => $data['body'],
                        'sender' => $data['sender'],
                        'other' => $data['other'],
                        'has_media' => $data['has_media'],
                        'media_url' => $data['image_one'] ? ROOT."/images/questions/".$data['image_one']: '',
                        'media_url2' => $data['image_two'] ? ROOT."/images/questions/".$data['image_two']: '',
                        'media_url3' => $data['image_three'] ? ROOT."/images/questions/".$data['image_three']: '',
                        'enterprise_id' => $data['enterprise_id'],
                        'inquiry_source' => $data['inquiry_source'],
                        'farmer' => (!$data['name']) ? 'UNREGISTERED' : $data['name'],
                        'responses' => $data['responses'],
                        'created_at' => $data['created_at'],
                        'updated_at' => $data['created_at'],
                        'user_id' => $data['user_id'],
                    ]);
                }
                $response['questions'] = $questions;
                        break;
        
        
                    //Subcounty
                    case 1:
                    case 7:
                    case 8:
                    case 9:
                    case 25:
        
                    $content = database::performQuery("SELECT farmer_questions.image_one,farmer_questions.image_two,farmer_questions.image_three,farmer_questions.id, farmer_questions.keyword,farmer_questions.farmer_id,farmer_questions.parish_id,farmer_questions.telephone,farmer_questions.body,farmer_questions.sender,farmer_questions.other,farmer_questions.has_media,farmer_questions.enterprise_id,farmer_questions.inquiry_source,farmer_questions.created_at,farmer_questions.user_id,db_farmers.name, count(farmer_question_responses.id) as responses FROM farmer_questions left join db_farmers on farmer_questions.farmer_id=db_farmers.id left join farmer_question_responses on farmer_questions.id=farmer_question_responses.farmer_question_id left join parish on farmer_questions.parish_id=parish.id left join subcounty on parish.subcounty_id=subcounty.id 
                            WHERE farmer_questions.parish_id is null or subcounty.id =  ".$user['location_id']."    
                            GROUP BY farmer_questions.id ORDER BY farmer_questions.id DESC                    
                            ");       
                    
                    while($data=$content->fetch_assoc()){
                        array_push($questions,[
                            'id' => $data['id'],
                            'farmer_id' => $data['farmer_id'],
                            'keyword' => $data['keyword'],
                            'parish_id' => $data['parish_id'],
                            'telephone' => $data['telephone'],
                            'body' => $data['body'],
                            'sender' => $data['sender'],
                            'other' => $data['other'],
                            'has_media' => $data['has_media'],
                            'media_url' => $data['image_one'] ? ROOT."/images/questions/".$data['image_one']: '',
                            'media_url2' => $data['image_two'] ? ROOT."/images/questions/".$data['image_two']: '',
                            'media_url3' => $data['image_three'] ? ROOT."/images/questions/".$data['image_three']: '',
                            'enterprise_id' => $data['enterprise_id'],
                            'inquiry_source' => $data['inquiry_source'],
                            'farmer' => (!$data['name']) ? 'UNREGISTERED' : $data['name'],
                            'responses' => $data['responses'],
                            'created_at' => $data['created_at'],
                            'updated_at' => $data['created_at'],
                            'user_id' => $data['user_id'],
                        ]);
                    }
                    $response['questions'] = $questions;
                    break;

                     //farmer
                     case 50:
            
                        $content = database::performQuery("SELECT farmer_questions.image_one,farmer_questions.image_two,farmer_questions.image_three,farmer_questions.id, farmer_questions.keyword,farmer_questions.farmer_id,farmer_questions.parish_id,farmer_questions.telephone,farmer_questions.body,farmer_questions.sender,farmer_questions.other,farmer_questions.has_media,farmer_questions.enterprise_id,farmer_questions.inquiry_source,farmer_questions.created_at,farmer_questions.user_id,db_farmers.name, count(farmer_question_responses.id) as responses FROM farmer_questions left join db_farmers on farmer_questions.farmer_id=db_farmers.id left join farmer_question_responses on farmer_questions.id=farmer_question_responses.farmer_question_id left join parish on farmer_questions.parish_id=parish.id left join subcounty on parish.subcounty_id=subcounty.id 
                                WHERE farmer_questions.user_id =  ".$user['id']."    
                                GROUP BY farmer_questions.id ORDER BY farmer_questions.id DESC                    
                                ");       
                        
                        while($data=$content->fetch_assoc()){
                            array_push($questions,[
                                'id' => $data['id'],
                                'farmer_id' => $data['farmer_id'],
                                'keyword' => $data['keyword'],
                                'parish_id' => $data['parish_id'],
                                'telephone' => $data['telephone'],
                                'body' => $data['body'],
                                'sender' => $data['sender'],
                                'other' => $data['other'],
                                'has_media' => $data['has_media'],
                                'media_url' => $data['image_one'] ? ROOT."/images/questions/".$data['image_one']: '',
                                'media_url2' => $data['image_two'] ? ROOT."/images/questions/".$data['image_two']: '',
                                'media_url3' => $data['image_three'] ? ROOT."/images/questions/".$data['image_three']: '',
                                'enterprise_id' => $data['enterprise_id'],
                                'inquiry_source' => $data['inquiry_source'],
                                'farmer' => (!$data['name']) ? 'UNREGISTERED' : $data['name'],
                                'responses' => $data['responses'],
                                'created_at' => $data['created_at'],
                                'updated_at' => $data['created_at'],
                                'user_id' => $data['user_id'],
                            ]);
                        }
                        $response['questions'] = $questions;
                        break;
        
                    default:
                        $response['questions'] = [];
                        break;
        
                }
                $response["error"] = FALSE;
                $response["questions"] = $questions;
                echo json_encode($response);

            }
            else{
                $response["error"] = TRUE;
                $response["error_msg"] = "User not Found!";
                echo json_encode($response);
            }

            


                // user acctivities is found
                

        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }


    }

    public static function apiGetQuestion()    {
        

        if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
            $id = database::prepData($_REQUEST['id']);
            $content = database::performQuery("SELECT farmer_questions.image_one,farmer_questions.image_two,farmer_questions.image_three,farmer_questions.id, farmer_questions.keyword,farmer_questions.farmer_id,farmer_questions.parish_id,farmer_questions.telephone,farmer_questions.body,farmer_questions.sender,farmer_questions.other,farmer_questions.has_media,farmer_questions.enterprise_id,farmer_questions.inquiry_source,farmer_questions.created_at,farmer_questions.user_id,db_farmers.name, count(farmer_question_responses.id) as responses FROM farmer_questions left join db_farmers on farmer_questions.farmer_id=db_farmers.id left join farmer_question_responses on farmer_questions.id=farmer_question_responses.farmer_question_id WHERE farmer_questions.id=$id limit 1");
            if($content->num_rows > 0){
                $question = null;
                while($data=$content->fetch_assoc()){
                    $question =[
                        'id' => $data['id'],
                        'farmer_id' => $data['farmer_id'],
                        'keyword' => $data['keyword'],
                        'parish_id' => $data['parish_id'],
                        'telephone' => $data['telephone'],
                        'body' => $data['body'],
                        'sender' => $data['sender'],
                        'other' => $data['other'],
                        'has_media' => $data['has_media'],
                        'media_url' => $data['image_one'] ? ROOT."/images/questions/".$data['image_one']: '',
                        'media_url2' => $data['image_two'] ? ROOT."/images/questions/".$data['image_two']: '',
                        'media_url3' => $data['image_three'] ? ROOT."/images/questions/".$data['image_three']: '',
                        'enterprise_id' => $data['enterprise_id'],
                        'inquiry_source' => $data['inquiry_source'],
                        'farmer' => (!$data['name']) ? 'UNREGISTERED' : $data['name'],   
                        'responses' => $data['responses'] ?? 0,                     
                        'created_at' => $data['created_at'],
                        'updated_at' => $data['created_at'],
                        'user_id' => $data['user_id'],
                    ];
                }
                $response["error"] = FALSE;
                $response["question"] = $question;
                echo json_encode($response);
            }
            else {
                $response["error"] = TRUE;
                $response["error_msg"] = "User not Found!";
                echo json_encode($response); 
            }
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }

    }

    public static function apiGetResponses()
    {
        if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
            $id = database::prepData($_REQUEST['id']);
            $question_responses = [];
            $content = database::performQuery("SELECT farmer_question_responses.id,farmer_question_responses.farmer_question_id,farmer_question_responses.response,farmer_question_responses.created_at,user.first_name,user.last_name,user.id as userid,user_category.name from farmer_question_responses join user on farmer_question_responses.user_id=user.id join user_category on user.user_category_id=user_category.id where farmer_question_responses.farmer_question_id=$id");
            while($data=$content->fetch_assoc()){
                array_push($question_responses,[
                    'id' => $data['id'],
                    'user_id' => $data['userid'],
                    'user_role' => $data['name'],
                    'user_name' => $data['first_name']." ".$data['last_name'],
                    'response' => $data['response'],
                    'question_id' => $data['farmer_question_id'],
                    'created_at' => $data['created_at'],
                ]);
            }
            $response["error"] = FALSE;
            $response['question_responses'] = $question_responses;
            echo json_encode($response); 
        }
        else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }

    public static function apiSendResponse()
    {
        if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
            $id = database::prepData($_REQUEST['id']);
            try {
                $message =database::prepData($_POST['response']);
                $question_id = $_POST['farmer_question_id'];
                $user_id = $_POST['user_id'];
                $created_at = date('Y-m-d H:i:s');

                //get phone number.
                $p = database::performQuery("select telephone from farmer_questions where id=$question_id limit 1");
                $r = $p->fetch_assoc();
                $farmer_telephone = $r['telephone'];
                $sql = database::performQuery("INSERT into `farmer_question_responses`(`farmer_question_id`,`response`,`user_id`,`created_at`,`updated_at`) VALUES('$question_id','$message','$user_id','$created_at','$created_at')");

                $response_id = database::getLastInsertID();
                //send sms via api

                alerts::send_sms($farmer_telephone,$message);

                //get response 
                $content = database::performQuery("SELECT farmer_question_responses.id,farmer_question_responses.farmer_question_id,farmer_question_responses.response,farmer_question_responses.created_at,user.first_name,user.last_name,user.id as userid,user_category.name from farmer_question_responses join user on farmer_question_responses.user_id=user.id join user_category on user.user_category_id=user_category.id where farmer_question_responses.id=$response_id limit 1");
                while($data=$content->fetch_assoc()){
                    $question_response =[
                        'id' => $data['id'],
                        'user_id' => $data['userid'],
                        'user_role' => $data['name'],
                        'user_name' => $data['first_name']." ".$data['last_name'],
                        'response' => $data['response'],
                        'question_id' => $data['farmer_question_id'],
                        'created_at' => $data['created_at'],
                    ];
                }
                $response["error"] = FALSE;
                $response["question_response"] = $question_response;
                echo json_encode($response);

            }catch(\Exception $e){
                $error =$e->getMessage();
                $response["error"] = TRUE;
                $response["error_msg"] = " $error";
                echo json_encode($response);
            }

            

            
        }else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }

    public static function apiSaveFarmerQuestion()    {
        

        if (isset($_REQUEST['user_id']) && isset($_REQUEST['question'])) {
            
            $user_id = $_POST['user_id'];
            //get farner details
            $user = [];     
            $telephone = '';       
            $sql_user_details = database::performQuery("select location_id,district_id,user_category_id,phone from user where id =$user_id limit 1");
            if($sql_user_details->num_rows > 0)
            {
                
                while($data=$sql_user_details->fetch_assoc()){                        
                        $user['location_id'] = $data['location_id'];
                        $user['user_category_id'] = $data['user_category_id'];
                        $user['district_id'] = $data['district_id'];
                        $user['telephone'] = $data['phone'];
                        $telephone = $data['phone'];
                }
            }
    
            $message = $_POST['question'];
            $created_at = date('Y-m-d H:i:s');
            $image_one_path = NULL;
            $image_two_path = NULL;
            $image_three_path = NULL;
            if(isset($_FILES['image_post']))
            {
                $temp = explode(".", $_FILES["image_post"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
               
                if (move_uploaded_file($_FILES['image_post']['tmp_name'], "images/questions/" . $newfilename)) {
                    $image_one_path = $newfilename;
                } else {
                    
                }
            }
            if(isset($_FILES['image_post1']))
            {
                $temp = explode(".", $_FILES["image_post1"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                if (move_uploaded_file($_FILES['image_post1']['tmp_name'], "images/questions/" . $newfilename)) {
                    $image_two_path = $newfilename;
                } else {
                    
                }
            }
            if(isset($_FILES['image_post2']))
            {
                $temp = explode(".", $_FILES["image_post2"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                if (move_uploaded_file($_FILES['image_post2']['tmp_name'], "images/questions/" . $newfilename)) {
                    $image_three_path = $newfilename;
                } else {
                    
                }
            }
            $ins = "INSERT INTO `farmer_questions` (`telephone`, `body`, `sender`, `created_at`, `updated_at`,`user_id`,`image_one`,`image_two`,`image_three`) VALUES ( '$telephone', '$message', 'app', '$created_at', '$created_at','$user_id','$image_one_path','$image_two_path','$image_three_path') ";
            // check if farmer exists 
            $check_farmer_exists = "select id,parish_id from db_farmers where contact='$telephone' limit 1";
            $r = database::performQuery($check_farmer_exists);
            if($r->num_rows > 0){
                $found_farmer = $r->fetch_assoc(); 
                $farmer_parish = $found_farmer['parish_id'];
                $farmer_id = $found_farmer['id'];
                $ins = "INSERT INTO `farmer_questions` (`farmer_id`,`parish_id`,`telephone`, `body`, `sender`, `created_at`, `updated_at`,`user_id`,`image_one`,`image_two`,`image_three`) VALUES ($farmer_id,$farmer_parish, '$telephone', '$message', 'app', '$created_at', '$created_at','$user_id','$image_one_path','$image_two_path','$image_three_path') ";
            }   

            $result = database::performQuery($ins);
            if($result){                
                $response["error"] = FALSE;
                $response["message"] = "success";
                echo json_encode($response);
            }
            else {
                $response["error"] = TRUE;
                $response["error_msg"] = "User not Found!";
                echo json_encode($response); 
            }
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["message"] = "Required parameters are missing!";
            echo json_encode($response);
        }

    }

}