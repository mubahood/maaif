<?php



use PHPMailer\PHPMailer\PHPMailer;

require  'vendor/autoload.php';

class user
{

    /*
     * User Profile Content
     *
     */

    public static function getConnection()
    {
        $dbConfig = database::getDBConfigs();
        $servername = $dbConfig['host'];
        $username = $dbConfig['user'];
        //$password = "";
        $password = $dbConfig['password'];
        $dbname = $dbConfig['database'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public static function getUserCategory($id)
    {

        $sql = database::performQuery("SELECT name FROM user_category WHERE id=$id");
        $content = '';
        while ($data = $sql->fetch_assoc()) {

            $content .= $data['name'];
        }

        return $content;
    }


    public static function getUserDetails($id)
    {

        $sql = database::performQuery("SELECT * FROM user WHERE id=$id");
        return $sql->fetch_assoc();
    }

    private static function send_sms_niita($number, $message)
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
        $r_object = json_decode($resp, true);
        $reference = $r_object['uuid'] ?? 'none';
        if ($reference == 'none') {

            return false;
        }
        return $reference;
    }

    public static function profile()
    {

        $content = '
        
            <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN PROFILE SIDEBAR -->
                                                <div class="profile-sidebar">
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light profile-sidebar-portlet ">
                                                        <!-- SIDEBAR USERPIC -->
                                                        <div class="profile-userpic">
                                                            <img src="' . ROOT . '/images/user.png" class="img-responsive" alt=""> </div>
                                                        <!-- END SIDEBAR USERPIC -->
                                                        <!-- SIDEBAR USER TITLE -->
                                                        <div class="profile-usertitle">
                                                            <div class="profile-usertitle-name"> ' . $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] . '</div>
                                                            <div class="profile-usertitle-job"> ' . self::getUserCategory($_SESSION['user']['user_category_id']) . ' </div>
                                                        </div>
                                                        <!-- END SIDEBAR USER TITLE -->
                                                        <!-- SIDEBAR BUTTONS -->
                                                       
                                                        <!-- END SIDEBAR BUTTONS -->
                                                        <!-- SIDEBAR MENU -->
                                                        <div class="profile-usermenu">
                                                            <ul class="nav">
                                                                <li class="active">
                                                                    <a href="' . ROOT . '/my-profile">
                                                                        <i class="icon-home"></i> Overview </a>
                                                                </li>
                                                                <li>
                                                                    <a href="' . ROOT . '/my-profile/settings">
                                                                        <i class="icon-settings"></i> Account Settings </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- END MENU -->
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light ">
                                                        <!-- STAT -->
                                                       
                                                        <!-- END STAT -->
                                                        <div>
                                                            <h4 class="profile-desc-title">About </h4>
                                                          
                                                           
                                                           <div class="margin-top-20 profile-desc-link">
                                                              <b> Email</b><br />
                                                                <a href="#">' . $_SESSION['user']['email'] . '</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                             <b>   Experience in MAAIF:</b><br />
                                                                <a href="#">12</a>
                                                            </div>
                                                             <div class="margin-top-20 profile-desc-link">
                                                               <b> Experience in Extension:</b><br />
                                                                <a href="#">7</a>
                                                            </div>
                                                             <div class="margin-top-20 profile-desc-link">
                                                               <b> Education Level:</b><br />
                                                                <a href="#">Secondary School / O\' Level</a>
                                                            </div>
                                                             <div class="margin-top-20 profile-desc-link">
                                                              <b>Phone</b><br />
                                                                <a href="#">' . $_SESSION['user']['phone'] . '</a>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                </div>
                                                <!-- END BEGIN PROFILE SIDEBAR -->
                                                <!-- BEGIN PROFILE CONTENT -->
                                                <div class="profile-content">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">My Extension Areas</small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                         <table class="table table-hover table-stripped table-condensed table-light">
                                                                         
                                                                         <tr><td><strong>Caledar Year :</strong> <small>2018</small></td></tr>
                                                                         <tr><td><strong>District :</strong>  <small>Gulu</small></td></tr>
                                                                         <tr><td><strong>Sub-County :</strong> <small>Madi-Okollo</small></td></tr>
                                                                         <tr><td><strong>No. Parishes :</strong> <small>7</small></td></tr>
                                                                         <tr><td><strong>No. Villages :</strong> <small>30</small></td></tr>
                                                                         <tr><td><strong>No. Beneficiary Groups :</strong> <small>20</small></td></tr>
                                                                         <tr><td><strong>No. Males :</strong> <small>450</small></td></tr>
                                                                         <tr><td><strong>No. Females :</strong> <small>567</small></td></tr>
                                                                         <tr><td><strong>No. Parishes Reached:</strong> <small>5</small></td></tr>
                                                                         <tr><td><strong>No. Villages Reached:</strong> <small>20</small></td></tr>
                                                                         <tr><td><strong>No. Served Groups :</strong> <small>16</small></td></tr>
                                                                         <tr><td><strong>No. Served Males :</strong> <small>200</small></td></tr>
                                                                         <tr><td><strong>No. Served Females :</strong> <small>367</small></td></tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                            
                                                             <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Annual Objectives</small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                        
                                                                        <ol>
                                                                        <li>Reach about 80%(16) Beneficiary Groups in Madi-Okollo</li>
                                                                        <li>Equip Farmers with different agricutural technologies</li>
                                                                        <li>Train Farmer Groups in modern Farming Methods</li>
                                                                        
                                                                        </ol>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                            
                                                            
                                                              <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Monthly Objectives - January</small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                        
                                                                        <ol>
                                                                        <li>Reach about 50%(10) Beneficiary Groups in Madi-Okollo</li>
                                                                        <li>Equip Farmers with Vegetable Growing Skills</li>
                                                                        <li>Train Farmer Groups in modern Farming Methods</li>
                                                                        <li>Recruit youth into farming for better prosperity of the nation</li>
                                                                        <li>Introduce Potential Crops to Farmers in the Area</li>
                                                                        
                                                                        </ol>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                            
                                                            <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase"> Monthly Statistics</small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                         <table class="table table-hover table-stripped table-condensed table-light">
                                                                         
                                                                         <tr><td><strong>Caledar Year :</strong> <small>2018</small></td></tr>
                                                                         <tr><td><strong>Caledar Month :</strong> <small>2018</small></td></tr>
                                                                         <tr><td><strong>District :</strong>  <small>Gulu</small></td></tr>
                                                                         <tr><td><strong>Sub-County :</strong> <small>Madi-Okollo</small></td></tr>
                                                                         <tr><td><strong>Total Activities :</strong> <small>27</small></td></tr>
                                                                         <tr><td><strong>Total Males :</strong> <small>345</small></td></tr>
                                                                         <tr><td><strong>Total Females :</strong> <small>500</small></td></tr>
                                                                         <tr><td><strong>Total Groups :</strong> <small>40</small></td></tr>
                                                                            </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                        </div>
                                                   <div class="col-md-8">
                                                   
                                                   <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Popular Commodities - Madi-Okkollo </small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Crops </th>
                                                                                    <th>Livestock</th>
                                                                                    <th>Fish</th>
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:10px">
                                                                            <tr>
                                                                                <td> 1 </td>
                                                                                <td><a href=""> Beans </a></td>
                                                                                <td> Cattle </td>
                                                                                <td>Nile Perch</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 2 </td>
                                                                                <td> <a href=""> Ground Nuts </a> </td>
                                                                                   <td> Local Chicken </td>
                                                                                   <td>Tilapia</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 3 </td>
                                                                                <td> <a href=""> SimSim </a></td>
                                                                                   <td> Broilers </td>
                                                                                   <td>-</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 4 </td>
                                                                                <td> <a href=""> Cassava </a> </td>
                                                                                   <td> - </td>
                                                                                   <td>-</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 5 </td>
                                                                                <td> <a href=""> Maize </a> </td>
                                                                                   <td> - </td>
                                                                                   <td>-</td>
                                                                            </tr>
                                                                              </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                            
                                                            <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Potential Commodities - Madi-Okkollo </small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Crops </th>
                                                                                    <th>Livestock</th>
                                                                                    <th>Fish</th>
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:10px">
                                                                            <tr>
                                                                                <td> 1 </td>
                                                                                <td><a href=""> Cabbages </a></td>
                                                                                <td> Goats </td>
                                                                                <td>Cat Fish</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 2 </td>
                                                                                <td> <a href=""> Sorghum </a> </td>
                                                                                   <td> Layer Chicken </td>
                                                                                   <td>-</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 3 </td>
                                                                                <td> <a href=""> Cashew Nuts</a></td>
                                                                                   <td> Rabbits </td>
                                                                                   <td>-</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 4 </td>
                                                                                <td> <a href=""> Wheat</a> </td>
                                                                                   <td> - </td>
                                                                                   <td>-</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 5 </td>
                                                                                <td> <a href="">Barley </a> </td>
                                                                                   <td> - </td>
                                                                                   <td>-</td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <td> 5 </td>
                                                                                <td> <a href="">Millet </a> </td>
                                                                                   <td> - </td>
                                                                                   <td>-</td>
                                                                            </tr>
                                                                              </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                   
                                                   
                                                    
                                                            <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Area Outputs - Madi-Okkollo </small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th>Quater </th>
                                                                                    <th>Key OutPuts </th>
                                                                                    <th>Key Indicators</th>
                                                                                    <th>Targets</th>
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:10px">
                                                                            <tr>
                                                                                <td> 1 </td>
                                                                            <td><a href=""> Q1 </a></td>
                                                                                <td><ul>
                                                                                <li>Farmers attained skills in modern farming</li>
                                                                                </ul> </td>
                                                                                <td> <ul>
                                                                                <li>25 Farmer group reached</li>
                                                                                </ul> </td>
                                                                                <td><ul>
                                                                                <li>20 Farmer Groups</li>
                                                                                </ul></td>
                                                                            </tr>
                                                                          <tr>
                                                                                <td> 1 </td>
                                                                            <td><a href=""> Q1 </a></td>
                                                                                <td><ul>
                                                                                <li>Farmers attained skills in land preparation</li>
                                                                                </ul> </td>
                                                                                <td> <ul>
                                                                                <li>15 Farmer group reached</li>
                                                                                </ul> </td>
                                                                                <td><ul>
                                                                                <li>12 Farmer Groups</li>
                                                                                </ul></td>
                                                                            </tr>
                                                                              </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                   
                                                   
                                                   
                                                   
                                                   
                                                   
                                                            <!-- BEGIN PORTLET -->
                                                            <div class="portlet light ">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Daily Activity Tracker - January 2018 </small></span>
                                                                      
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="portlet-body">
                                                                    
                                                                    <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Activity </th>
                                                                                    <th>People</th>
                                                                                    <th>Date</th>
                                                                                    <th> Action </th>
                                                                                   </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:10px">
                                                                            <tr>
                                                                                <td> 1 </td>
                                                                                <td><a href=""> Planting Maize in Karamoja </a></td>
                                                                                <td> 10 </td>
                                                                                <td>2018/01/07</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 2 </td>
                                                                                <td> <a href=""> Spraying Maize in Karamoja </a> </td>
                                                                                   <td> 6 </td>
                                                                                   <td>2018/01/06</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 3 </td>
                                                                                <td> <a href=""> Controlling Army worm in  Maize </a></td>
                                                                                   <td> 8 </td>
                                                                                   <td>2018/01/06</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 4 </td>
                                                                                <td> <a href=""> Growing Eggplants in a wetland </a> </td>
                                                                                   <td> 12 </td>
                                                                                   <td>2018/01/05</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 5 </td>
                                                                                <td> <a href=""> Proper use of pesticides with vegetables </a> </td>
                                                                                   <td> 12 </td>
                                                                                   <td>2018/01/05</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 6 </td>
                                                                                <td> <a href=""> Preparing your land for planting</a> </td>
                                                                                   <td> 12 </td>
                                                                                   <td>2018/01/04</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 7 </td>
                                                                                <td> <a href=""> Controlling Pests in Maize</a> </td>
                                                                                   <td> 25 </td>
                                                                                   <td>2018/01/04</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                                <td> 8 </td>
                                                                                <td> <a href=""> Business skills for Small Scale Farmers</a> </td>
                                                                                   <td> 10 </td>
                                                                                   <td>2018/01/03</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                                <td> 9 </td>
                                                                                <td> <a href=""> Land preparation for Mixed farming</a> </td>
                                                                                   <td>14</td>
                                                                                   <td>2018/01/02</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 10 </td>
                                                                                <td> <a href=""> Growing wheat on a large scale</a> </td>
                                                                                   <td> 8 </td>
                                                                                   <td>2018/01/01</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> 11 </td>
                                                                                <td> <a href=""> Importance of Cooperatives to farmers</a> </td>
                                                                                   <td> 20 </td>
                                                                                   <td>2018/01/01</td>
                                                                                <td>  <button type="button" class="btn btn-circle red btn-sm"><i class="fa fa-remove"></i></button></td>
                                                                            </tr>
                                                                           <tr><td colspan="5"><button class="btn btn-block btn-sm green-jungle"> View all my Activities</button></td></tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PORTLET -->
                                                        </div>
                                                   
                                                   
                                                   
                                                    </div>
                                                 </div>
                                                <!-- END PROFILE CONTENT -->
                                            </div>
                                        </div>
                                    
        
        ';

        return $content;
    }



    /*
     * User Profile Settings
     *
     */
    public static function profileSettings()
    {

        $content = '
        
             <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN PROFILE SIDEBAR -->
                                                <div class="profile-sidebar">
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light profile-sidebar-portlet ">
                                                        <!-- SIDEBAR USERPIC -->
                                                        <div class="profile-userpic">
                                                            <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""> </div>
                                                        <!-- END SIDEBAR USERPIC -->
                                                        <!-- SIDEBAR USER TITLE -->
                                                        <div class="profile-usertitle">
                                                            <div class="profile-usertitle-name"> Marcus Doe </div>
                                                            <div class="profile-usertitle-job"> Developer </div>
                                                        </div>
                                                        <!-- END SIDEBAR USER TITLE -->
                                                        <!-- SIDEBAR BUTTONS -->
                                                        <div class="profile-userbuttons">
                                                            <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                                                            <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                                        </div>
                                                        <!-- END SIDEBAR BUTTONS -->
                                                        <!-- SIDEBAR MENU -->
                                                        <div class="profile-usermenu">
                                                            <ul class="nav">
                                                                <li>
                                                                    <a href="page_user_profile_1.html">
                                                                        <i class="icon-home"></i> Overview </a>
                                                                </li>
                                                                <li class="active">
                                                                    <a href="page_user_profile_1_account.html">
                                                                        <i class="icon-settings"></i> Account Settings </a>
                                                                </li>
                                                                <li>
                                                                    <a href="page_user_profile_1_help.html">
                                                                        <i class="icon-info"></i> Help </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- END MENU -->
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light ">
                                                        <!-- STAT -->
                                                        <div class="row list-separated profile-stat">
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 37 </div>
                                                                <div class="uppercase profile-stat-text"> Projects </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 51 </div>
                                                                <div class="uppercase profile-stat-text"> Tasks </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 61 </div>
                                                                <div class="uppercase profile-stat-text"> Uploads </div>
                                                            </div>
                                                        </div>
                                                        <!-- END STAT -->
                                                        <div>
                                                            <h4 class="profile-desc-title">About Marcus Doe</h4>
                                                            <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-globe"></i>
                                                                <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-twitter"></i>
                                                                <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-facebook"></i>
                                                                <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                </div>
                                                <!-- END BEGIN PROFILE SIDEBAR -->
                                                <!-- BEGIN PROFILE CONTENT -->
                                                <div class="profile-content">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="portlet light ">
                                                                <div class="portlet-title tabbable-line">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-globe theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                                    </div>
                                                                    <ul class="nav nav-tabs">
                                                                        <li class="active">
                                                                            <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="portlet-body">
                                                                    <div class="tab-content">
                                                                        <!-- PERSONAL INFO TAB -->
                                                                        <div class="tab-pane active" id="tab_1_1">
                                                                            <form role="form" action="#">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">First Name</label>
                                                                                    <input type="text" placeholder="John" class="form-control" /> </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Last Name</label>
                                                                                    <input type="text" placeholder="Doe" class="form-control" /> </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Mobile Number</label>
                                                                                    <input type="text" placeholder="+1 646 580 DEMO (6284)" class="form-control" /> </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Interests</label>
                                                                                    <input type="text" placeholder="Design, Web etc." class="form-control" /> </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Occupation</label>
                                                                                    <input type="text" placeholder="Web Developer" class="form-control" /> </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">About</label>
                                                                                    <textarea class="form-control" rows="3" placeholder="We are KeenThemes!!!"></textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Website Url</label>
                                                                                    <input type="text" placeholder="http://www.mywebsite.com" class="form-control" /> </div>
                                                                                <div class="margiv-top-10">
                                                                                    <a href="javascript:;" class="btn green"> Save Changes </a>
                                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- END PERSONAL INFO TAB -->
                                                                        <!-- CHANGE AVATAR TAB -->
                                                                        <div class="tab-pane" id="tab_1_2">
                                                                            <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                                                                nesciunt laborum eiusmod. </p>
                                                                            <form action="#" role="form">
                                                                                <div class="form-group">
                                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                                        <div>
                                                                                            <span class="btn default btn-file">
                                                                                                <span class="fileinput-new"> Select image </span>
                                                                                                <span class="fileinput-exists"> Change </span>
                                                                                                <input type="file" name="..."> </span>
                                                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="clearfix margin-top-10">
                                                                                        <span class="label label-danger">NOTE! </span>
                                                                                        <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="margin-top-10">
                                                                                    <a href="javascript:;" class="btn green"> Submit </a>
                                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- END CHANGE AVATAR TAB -->
                                                                        <!-- CHANGE PASSWORD TAB -->
                                                                        <div class="tab-pane" id="tab_1_3">
                                                                            <form action="#">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Current Password</label>
                                                                                    <input type="password" class="form-control" /> </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">New Password</label>
                                                                                    <input type="password" class="form-control" /> </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Re-type New Password</label>
                                                                                    <input type="password" class="form-control" /> </div>
                                                                                <div class="margin-top-10">
                                                                                    <a href="javascript:;" class="btn green"> Change Password </a>
                                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- END CHANGE PASSWORD TAB -->
                                                                        <!-- PRIVACY SETTINGS TAB -->
                                                                        <div class="tab-pane" id="tab_1_4">
                                                                            <form action="#">
                                                                                <table class="table table-light table-hover">
                                                                                    <tr>
                                                                                        <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                                                        <td>
                                                                                            <div class="mt-radio-inline">
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios1" value="option1" /> Yes
                                                                                                    <span></span>
                                                                                                </label>
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios1" value="option2" checked/> No
                                                                                                    <span></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                                        <td>
                                                                                            <div class="mt-radio-inline">
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios11" value="option1" /> Yes
                                                                                                    <span></span>
                                                                                                </label>
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios11" value="option2" checked/> No
                                                                                                    <span></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                                        <td>
                                                                                            <div class="mt-radio-inline">
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios21" value="option1" /> Yes
                                                                                                    <span></span>
                                                                                                </label>
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios21" value="option2" checked/> No
                                                                                                    <span></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                                        <td>
                                                                                            <div class="mt-radio-inline">
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios31" value="option1" /> Yes
                                                                                                    <span></span>
                                                                                                </label>
                                                                                                <label class="mt-radio">
                                                                                                    <input type="radio" name="optionsRadios31" value="option2" checked/> No
                                                                                                    <span></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <!--end profile-settings-->
                                                                                <div class="margin-top-10">
                                                                                    <a href="javascript:;" class="btn red"> Save Changes </a>
                                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- END PRIVACY SETTINGS TAB -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END PROFILE CONTENT -->
                                            </div>
                                        </div>
                                   
        
        ';

        return $content;
    }



    /*
    * User Profile Help
    *
    */
    public static function profileHelp()
    {

        $content = '
     
         <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN PROFILE SIDEBAR -->
                                                <div class="profile-sidebar">
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light profile-sidebar-portlet ">
                                                        <!-- SIDEBAR USERPIC -->
                                                        <div class="profile-userpic">
                                                            <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""> </div>
                                                        <!-- END SIDEBAR USERPIC -->
                                                        <!-- SIDEBAR USER TITLE -->
                                                        <div class="profile-usertitle">
                                                            <div class="profile-usertitle-name"> Marcus Doe </div>
                                                            <div class="profile-usertitle-job"> Developer </div>
                                                        </div>
                                                        <!-- END SIDEBAR USER TITLE -->
                                                        <!-- SIDEBAR BUTTONS -->
                                                        <div class="profile-userbuttons">
                                                            <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                                                            <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                                        </div>
                                                        <!-- END SIDEBAR BUTTONS -->
                                                        <!-- SIDEBAR MENU -->
                                                        <div class="profile-usermenu">
                                                            <ul class="nav">
                                                                <li>
                                                                    <a href="page_user_profile_1.html">
                                                                        <i class="icon-home"></i> Overview </a>
                                                                </li>
                                                                <li>
                                                                    <a href="page_user_profile_1_account.html">
                                                                        <i class="icon-settings"></i> Account Settings </a>
                                                                </li>
                                                                <li class="active">
                                                                    <a href="page_user_profile_1_help.html">
                                                                        <i class="icon-info"></i> Help </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- END MENU -->
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light ">
                                                        <!-- STAT -->
                                                        <div class="row list-separated profile-stat">
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 37 </div>
                                                                <div class="uppercase profile-stat-text"> Projects </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 51 </div>
                                                                <div class="uppercase profile-stat-text"> Tasks </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 61 </div>
                                                                <div class="uppercase profile-stat-text"> Uploads </div>
                                                            </div>
                                                        </div>
                                                        <!-- END STAT -->
                                                        <div>
                                                            <h4 class="profile-desc-title">About Marcus Doe</h4>
                                                            <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-globe"></i>
                                                                <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-twitter"></i>
                                                                <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-facebook"></i>
                                                                <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                </div>
                                                <!-- END BEGIN PROFILE SIDEBAR -->
                                                <!-- BEGIN PROFILE CONTENT -->
                                                <div class="profile-content">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="portlet light ">
                                                                <div class="portlet-title tabbable-line">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-globe theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Help</span>
                                                                    </div>
                                                                    <ul class="nav nav-tabs">
                                                                        <li class="active">
                                                                            <a href="#tab_1_1" data-toggle="tab">General Question</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#tab_1_2" data-toggle="tab">Membership</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#tab_1_3" data-toggle="tab">Terms Of Use</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="portlet-body">
                                                                    <div class="tab-content">
                                                                        <!-- GENERAL QUESTION TAB -->
                                                                        <div class="tab-pane active" id="tab_1_1">
                                                                            <div id="accordion1" class="panel-group">
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1"> 1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion1_1" class="panel-collapse collapse in">
                                                                                        <div class="panel-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food
                                                                                            truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                            anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_2"> 2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion1_2" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim
                                                                                            pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food
                                                                                            truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                            anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-success">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_3"> 3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion1_3" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim
                                                                                            pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food
                                                                                            truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                            anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-warning">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_4"> 4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion1_4" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-danger">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_5"> 5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion1_5" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_6"> 6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion1_6" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_7"> 7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion1_7" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- END GENERAL QUESTION TAB -->
                                                                        <!-- MEMBERSHIP TAB -->
                                                                        <div class="tab-pane" id="tab_1_2">
                                                                            <div id="accordion2" class="panel-group">
                                                                                <div class="panel panel-warning">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_1"> 1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion2_1" class="panel-collapse collapse in">
                                                                                        <div class="panel-body">
                                                                                            <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                                                                                                Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                                                                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                                                                beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </p>
                                                                                            <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                                                                                                Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                                                                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                                                                beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-danger">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_2"> 2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion2_2" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim
                                                                                            pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food
                                                                                            truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                            anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-success">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_3"> 3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion2_3" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim
                                                                                            pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food
                                                                                            truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                            anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_4"> 4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion2_4" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_5"> 5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion2_5" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_6"> 6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion2_6" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_7"> 7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion2_7" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- END MEMBERSHIP TAB -->
                                                                        <!-- TERMS OF USE TAB -->
                                                                        <div class="tab-pane" id="tab_1_3">
                                                                            <div id="accordion3" class="panel-group">
                                                                                <div class="panel panel-danger">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_1"> 1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion3_1" class="panel-collapse collapse in">
                                                                                        <div class="panel-body">
                                                                                            <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                                                                                                Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                                                                                </p>
                                                                                            <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                                                                                                Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                                                                                </p>
                                                                                            <p> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                                anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                                farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-success">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_2"> 2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion3_2" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim
                                                                                            pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food
                                                                                            truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                            anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_3"> 3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion3_3" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim
                                                                                            pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food
                                                                                            truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil
                                                                                            anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_4"> 4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion3_4" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_5"> 5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion3_5" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_6"> 6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion3_6" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_7"> 7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="accordion3_7" class="panel-collapse collapse">
                                                                                        <div class="panel-body"> 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                                                                            squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                                                                            vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus
                                                                                            labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                                                                            shoreditch et </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- END TERMS OF USE TAB -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END PROFILE CONTENT -->
                                            </div>
                                        </div>
                                    
     
     ';


        return $content;
    }


    public static function addNewUsers()
    {

        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Users</h4>
                            </div>
                            <div class="alert alert-danger" style="display:none", id="Validation-Div">
                                <ul id ="Validation">
                        
                                </ul>
                            </div>

                            <div class="alert alert-success" style="display:none", id="Success-Div">
                                <ul id ="Success">
                        
                                </ul>
                            </div>

                            <form action="" method="POST" id="add-user-form">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" id="firstName" class="form-control" placeholder="firstname" name="firstname" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-4">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" id="lastName" class="form-control form-control-danger" placeholder="lastname" name="lastname" required>
                                                     </div>
                                            </div>
                                            
                                             <div class="col-md-4">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Username</label>
                                                    <input type="text" id="lastName" class="form-control form-control-danger" placeholder="username" name="username" required>
                                                     </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" id="firstName" name="email" class="form-control" placeholder="john@gmai.com" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Password</label>
                                                    <input type="password" id="lastName" name="password" class="form-control form-control-danger" placeholder="xxx" required>
                                                     </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Gender</label>
                                                    <select class="form-control custom-select" name="gender">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                    <small class="form-control-feedback"> Select your gender </small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Phone</label>
                                                    <input type="text" class="form-control" name="phone" placeholder="0701 234567" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">User Category</label>
                                                    ' . self::switchUserCat() . '
                                                </div>
                                            </div>
                                            <!--/span-->
                                           
                                        </div>
                                        <div id="select_area_subcounty">
                                        ' . self::switchUserLocation() . '
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                        
                                        
                                           
                                             <!-- For municipal head.. -->
                                            <div class="col-md-6" style="display:none;" id="municipality_box">
                                                <div class="form-group">
                                                <label class="municipal">Select Municipality</label>
                                                <select class="form-control custom-select" name="municipality_id" id="select_municipality">                                                    
                                                   ' . self::getAreaCounties($_REQUEST['district_id']) . '
                                                   </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-6" style="display:none;"  id="parish_box">
                                                <div class="form-group">
                                                <label class="control-label">Select Parish/Ward</label>
                                                <select class="form-control custom-select" name="parish_id" id="select_parish">
                                                      <option value="">--Select parish/ward--</option> 
                                                   </select>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-6" style="display:none;" id="maaif_directorate">
                                                <div class="form-group">
                                                    <label class="control-label">Select Directorate</label>
                                                    <select class="form-control custom-select" name="directorate_id" id="select_directorate">
                                                        <option value="">--Select directorate--</option> 
                                                        ' . self::getDirectorates() . '
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6" style="display:none;" id="maaif_department">
                                                <div class="form-group">
                                                    <label class="control-label">Select Department</label>
                                                    <select class="form-control custom-select" name="department_id" id="select_department">
                                                    <option value="">--Select department--</option> 
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6" style="display:none;" id="maaif_division">
                                            <div class="form-group">
                                                <label class="control-label">Select Division</label>
                                                <select class="form-control custom-select" name="division_id" id="select_division">
                                                <option value="">--Select division--</option> 
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="action" value="processNewUser"/>
                                            <button type="submit" class="btn btn-success button-prevent-multiple-submits" id="confirmButton"> <i class="fa fa-check"></i> Add New</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function prepGRMReport()
    {

        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Prep New GRM Report</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label">Grievance  Redress Committee level</label>
                                                     <select  class="select2 form-control" multiple="multiple"   name="grc_level[]"  style="height: 36px;width: 100%;">
                                                        <option value="0">All Grievance  Redress Committees</option>
                                                        <option value="3">Sub-county Grievance  Redress Committee</option>
                                                        <option value="4">District Grievance  Redress Committee </option>
                                                        <option value="5">National Grievance  Redress Committee</option>
                                                    </select> </div>
                                            </div>
                                         <div class="col-md-8">
                                                <div class="form-group">
                                                    ' . self::switchUserLocation() . '
                                                </div>
                                            </div>   <!--/span-->
                                          <div class="col-md-8">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Grievance Nature</label>
                                                    <select  class="select2 form-control" multiple="multiple"  name="grc_nature[]"  style="height: 36px;width: 100%;">
                                                        <option value="0">All Grievance Natures</option>
                                                        <option value="1">Fraud</option>
                                                        <option value="2">Land Dispute </option>
                                                        <option value="3">Compensation</option>
                                                        <option value="4">Environmental</option>
                                                        <option value="5">Social Issues</option>
                                                        <option value="6">Management</option>
                                                        <option value="7">E-Voucher System</option>
                                                        <option value="9">Input Dealers</option>
                                                        <option value="10">Others</option>
                                                    </select> 
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label">Date From</label>
                                                   <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <span class="ti-calendar"></span>
                                            </span>
                                        </div>
                                        <input id="picker_from" class="form-control datepicker" name="picker_from" type="date">
                                    </div>
                                     <label class="control-label">Date To</label> <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <span class="ti-calendar"></span>
                                            </span>
                                        </div>
                                        <input id="picker_to" class="form-control datepicker"  name="picker_to" type="date">
                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="action" value="processNewGRMReport"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-newspaper"></i> Generate Report</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function processNewGRMReport()
    {

        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">GRM Report for all ACDP Districts between December 2019 and March 2020 </h4>
                            </div>
                             <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            
                                            
                                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                       <!-- <tr>
                                            <th colspan="4">GRM Report for Date 1 and Date 2 in District #1</th>
                                         </tr>
                                         <tr>
                                            <th>Actions</th>
                                            <th>Print Report</th>
                                            <th>Export Report to Excel </th>
                                            <th>Export Report to Word</th>
                                         </tr>-->
                                    </thead>
                                    <tbody>
                                      <tr>
                                            <td colspan="2"><h3>Grievances By District</h3>
                                               ' . self::getLocationDetailsDistrict() . '
                                              </td>
                                            </tr><tr>
                                            <td colspan="4"><h3>Grievances By Subcounty</h3>
                                            ' . self::getLocationDetailsDistrictIDs() . '</td>
                                         
                                            </tr>  <tr>
                                            <th colspan="4"><h3>Grievances By  Redress Committee level</h3>
                                           ' . self::getRedressCommittee() . '</th>
                                            </tr>
                                       <tr>
                                            <th colspan="4"><h3>Grievance By Nature </h3>
                                            ' . self::getNature() . '</th>
                                             </tr>
                                         <tr>
                                            <th colspan="4"><h3>Grievance By Settlement</h3>
                                             ' . self::getSettlement() . '
                                           </th>
                                            
                                            </tr>
                                        
                                        <!-- <tr>
                                            <th>Grievances</th>
                                            <th>Subcounty GRC</th>
                                            <th>District GRC</th>
                                            <th>National GRC</th>
                                        </tr>-->
                                    </tbody>
                                </table>
                            </div>  
                                            
                                            
                                        
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }


    public static function addNewMeeting()
    {

        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Meetings</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Theme</label>
                                                    <input type="text" id="firstName" class="form-control" placeholder="What was the theme of the meeting?" name="theme">
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Attendees of the meeting</label>
                                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Attendee Name..." name="attendees"></textarea>
                                        <small id="textHelp" class="form-text text-muted">Add one person per line.</small>
                                    </div>
                                                     </div>
                                            </div>
                                            
                                          <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Proceedings of the meeting</label>
                                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Add proceedings here..." name="proceedings"></textarea>
                                        
                                    </div>
                                                     </div>
                                            </div>
                                            
                                          <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Discussions of the meeting</label>
                                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Discussions of the meeting..." name="discussions"></textarea>
                              
                                    </div>
                                                     </div>
                                            </div>
                                            
                                          <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Recommendations of the meeting</label>
                                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Recommendations..." name="recommendations"></textarea>
                                        
                                    </div>
                                                     </div>
                                            </div>
                                            
                                            
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewMeeting"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add New Meeting</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }


    public static function addNewWorkplan()
    {


        $user = user::getUserDetails($_REQUEST['id']);

        $year = get_finacial_year_range()['year_range'];

        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add Annual Workplan for ' . $user['first_name'] . ' ' . $user['last_name'] . ' for ' . $year . '</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                            
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Extension Officer</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" name="eo" value="' . $user['first_name'] . ' ' . $user['last_name'] . '"   placeholder="" disabled>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                            
                                                <div class="form-group">
                                                    <label class="control-label">Financial Year</label>
                                                    
                                                    <select class="form-control custom-select" name="year" required>
                                                        <option value="2018/2019">2018/2019</option>
                                                        <option value="2019/2020">2019/2020</option>
                                                        <option value="2020/2021">2020/2021</option>
                                                        <option value="2021/2022">2021/2022</option>
                                                        <option value="2022/2023" SELECTED>2022/2023</option>
                                                        <option value="2023/2024">2023/2024</option>
                                                        <option value="2024/2025">2024/2025</option>
                                                        <option value="2025/2026">2025/2026</option>
                                                        <option value="2026/2027">2026/2027</option>
                                                        <option value="2027/2028">2027/2028</option>
                                                        <option value="2028/2029">2028/2029</option>
                                                        <option value="2029/2030">2029/2030</option>
                                                        <option value="2030/2031">2030/2031</option>
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Key Output</label>
                                                    <textarea class="form-control" placeholder="Key Output here" rows="3" name="output" required></textarea>
                                                     </div>
                                            </div>
                                            <!--/span-->
                                           
                                            
                                              <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Planned Activities</label>
                                                    
                                                    
                                                    <select class="select2 form-control" name="activities[]" multiple="multiple" style="height: 36px;width: 100%;" required>
                                                        ' . self::getListofActivities() . '
                                                    </select>
                                                    
                                                      </div>
                                            </div>
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row p-t-20">
                                       
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Key Indicators</label>
                                                  <textarea class="form-control" placeholder="Enter All Key Indicators here for the key output"  rows="5" name="indicator" required></textarea>
                                                       </div>
                                            </div>
                                            
                                            
                                           <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Key Targets</label>
                                                  <textarea class="form-control" rows="5" placeholder="Enter All Key Targets here for the key output"  name="target" required></textarea>
                                                  
                                                  
                                                       </div>
                                            </div>
                                            
                                            
                                               
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Total Budget</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" name="budget"   placeholder="" required>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                            
                                            
                                            
                                            <!--/span-->
                                        </div>
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="action" value="processNewAnnualKO"/>
                                            <input type="hidden" name="id" value="' . $_REQUEST['id'] . '"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Annual Key Outputs</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }


    public static function getListofUsers()
    {

        $id = $_SESSION['user']['location_id'];


        $user_cat = 1;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
                $user_cat = 8;
                break;

            case 3:
                $user_cat = 9;
                break;

            case 4:
                $user_cat = 7;
                break;

            default:
                break;
        }

        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND district.id = $id
                   AND user_category_id = $user_cat
                   ";
                break;

            case 6:
                $content = '';
                break;

            default:
                $content = '';
                break;
        }


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {

            $rt .= '<option value="' . $data['id'] . '"> ' . $data['first_name'] . ' ' . $data['last_name'] . '</option>';
        }

        return $rt;
    }


    public static function getListofUserTopics($id)
    {
        $content = '';
        $sql = database::performQuery("SELECT topic FROM ext_area_quaterly_activity WHERE user_id=$id");
        $ids = [];
        while ($data = $sql->fetch_assoc()) {

            $ids[] = $data['topic'];
        }
        $ids = implode(',', $ids);



        $sqlz = database::performQuery("SELECT * FROM ext_topics WHERE id IN($ids) ORDER BY name ASC");
        if ($sqlz->num_rows > 0) {
            while ($dataz = $sqlz->fetch_assoc()) {

                $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
            }

            return $content;
        } else
            redirect_to(ROOT . '/?action=NoActivityYet');
    }



    public static function getListofUserEntts($id)
    {
        $content = '';
        $sql = database::performQuery("SELECT entreprizes FROM ext_area_quaterly_activity WHERE user_id=$id");
        $ids = [];
        while ($data = $sql->fetch_assoc()) {

            $ids[] = $data['entreprizes'];
        }
        $ids = implode(',', $ids);



        $sqlz = database::performQuery("SELECT * FROM km_category WHERE id IN($ids) ORDER BY name ASC");
        while ($dataz = $sqlz->fetch_assoc()) {

            $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
        }

        return $content;
    }


    public static function getListofTopics()
    {



        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
            case 10:
            case 12:
                $sql = database::performQuery("SELECT * FROM ext_topic_category WHERE  1");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_topics WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;
            case 8:
            case 19:
            case 22:
                $sql = database::performQuery("SELECT * FROM ext_topic_category WHERE id LIKE 2 OR id LIKE 1");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_topics WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;

            case 9:
            case 20:
            case 23:

                $sql = database::performQuery("SELECT * FROM ext_topic_category WHERE id LIKE 3 OR id LIKE 1 OR id LIKE 5");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_topics WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }

                break;

            case 7:
            case 21:


                $sql = database::performQuery("SELECT * FROM ext_topic_category WHERE id LIKE 4 OR id LIKE 1");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_topics WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;



            default:
                $content = '';
                break;
        }



        return $content;
    }


    public static function getListofOutputs($id)
    {
        $content = '';
        $sql = database::performQuery("SELECT * FROM `ext_area_annual_outputs` WHERE `user_id`= $id");
        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {
                $content .= "<option value='$data[id]'>$data[key_output]</option>";
            }
        }
        return $content;
    }



    public static function getListofEnterprizes()
    {



        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
            case 12:
            case 10:

                $sql = database::performQuery("SELECT * FROM km_category WHERE (id LIKE 4 OR id LIKE 5 OR id LIKE 3 OR id LIKE 6 OR id LIKE 7 OR id LIKE 8 OR id LIKE 9 OR id LIKE 11 OR id LIKE 2 OR id LIKE 78 OR id LIKE 149 OR id LIKE 161 OR id LIKE 162)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM km_category WHERE parent_id LIKE $data[id] ORDER BY name ASC");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;
            case 8:
            case 19:
            case 22:
                $sql = database::performQuery("SELECT * FROM km_category WHERE (id LIKE 4 OR id LIKE 5 OR id LIKE 6 OR id LIKE 7 OR id LIKE 8 OR id LIKE 9 OR id LIKE 11)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM km_category WHERE parent_id LIKE $data[id] ORDER BY name ASC");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;

            case 9:
            case 23:
            case 20:

                $sql = database::performQuery("SELECT * FROM km_category WHERE (id LIKE 2 OR id LIKE 78 OR id LIKE 149 OR id LIKE 161 OR id LIKE 162) ");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM km_category WHERE parent_id LIKE $data[id]  ORDER BY name ASC");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        if ($dataz['id'] != 78 &&  $dataz['id'] != 149 && $dataz['id'] != 161 && $dataz['id'] != 162)
                            $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }

                break;

            case 7:
            case 21:


                $sql = database::performQuery("SELECT * FROM km_category WHERE id LIKE 3 ");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM km_category WHERE parent_id LIKE $data[id]  ORDER BY name ASC");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;



            default:
                $content = '';
                break;
        }



        return $content;
    }


    public static function getListofAllEnterprizes()
    {



        $content = '';

        $sql = database::performQuery("SELECT * FROM km_category WHERE (id LIKE 4 OR id LIKE 5 OR id LIKE 6 OR id LIKE 7 OR id LIKE 8 OR id LIKE 9 OR id LIKE 11)");
        while ($data = $sql->fetch_assoc()) {

            $content .= "<optgroup label=\"   $data[name] \">   ";

            $sqlz = database::performQuery("SELECT * FROM km_category WHERE parent_id LIKE $data[id] ORDER BY name ASC");
            while ($dataz = $sqlz->fetch_assoc()) {

                $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
            }

            $content .= "</optgroup>   ";
        }



        $sql = database::performQuery("SELECT * FROM km_category WHERE (id LIKE 2 OR id LIKE 78 OR id LIKE 149 OR id LIKE 161 OR id LIKE 162) ");
        while ($data = $sql->fetch_assoc()) {

            $content .= "<optgroup label=\"   $data[name] \">   ";

            $sqlz = database::performQuery("SELECT * FROM km_category WHERE parent_id LIKE $data[id]  ORDER BY name ASC");
            while ($dataz = $sqlz->fetch_assoc()) {

                if ($dataz['id'] != 78 &&  $dataz['id'] != 149 && $dataz['id'] != 161 && $dataz['id'] != 162)
                    $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
            }

            $content .= "</optgroup>   ";
        }


        $sql = database::performQuery("SELECT * FROM km_category WHERE id LIKE 3 ");
        while ($data = $sql->fetch_assoc()) {

            $content .= "<optgroup label=\"   $data[name] \">   ";

            $sqlz = database::performQuery("SELECT * FROM km_category WHERE parent_id LIKE $data[id]  ORDER BY name ASC");
            while ($dataz = $sqlz->fetch_assoc()) {

                $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
            }

            $content .= "</optgroup>   ";
        }




        return $content;
    }


    public static function getListofActivities()
    {

        $id = $_SESSION['user']['location_id'];



        $content = '';
        switch ($_SESSION['user']['user_category_id']) {
                //Subject Matter Specialists
            case 10:
                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,7,8)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                } 


                break;
                //Entomology
            case 12:

                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,5,7)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;

                //Agricultural Officers
            case 2:

                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,2,7,9)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;


            case 8:
            case 19:
            case 22:
                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,2,7)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;
                //Vet Officers
            case 3:
                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,3,7,10)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }

                break;
            case 9:
            case 20:
            case 23:

                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,3,7)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }

                break;
                //Fisheries Officers
            case 4:

                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,4,7,11)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;
            case 7:
            case 21:


                $sql = database::performQuery("SELECT * FROM ext_activity_category WHERE id IN (1,4,7)");
                while ($data = $sql->fetch_assoc()) {

                    $content .= "<optgroup label=\"   $data[name] \">   ";

                    $sqlz = database::performQuery("SELECT * FROM ext_activitys WHERE category LIKE $data[id]");
                    while ($dataz = $sqlz->fetch_assoc()) {

                        $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
                    }

                    $content .= "</optgroup>   ";
                }


                break;



            default:
                $content = '';
                break;
        }



        return $content;
    }


    public static function addAnnualObjectives()
    {

        $user = user::getUserDetails($_REQUEST['id']);


        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Annual Output</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Extension Officer</label>
                                                    
                                                    <select class="form-control custom-select" name="user_id" disabled>
                                                     <option value="' . $user['id'] . ' "> ' . $user['first_name'] . ' ' . $user['last_name'] . '</option>
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Year</label>
                                                    
                                                    <div class="form-group">
                                                       <select class="form-control custom-select" name="year">
                                                       <option value="2019">2019</option>
                                                       <option value="2020">2020</option>
                                                       
                                                       </select>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Output 1</label>
                                                    
                                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nametext1" name="objective[]"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Output 2</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="objective[]"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Output 3</label>
                                                    
                                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nametext1" name="objective[]"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Output 4</label>
                                                    
                                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nametext1" name="objective[]"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Output 5</label>
                                                    
                                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nametext1" name="objective[]"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Output 6</label>
                                                    
                                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nametext1" name="objective[]"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="user_id" value="' . $user['id'] . '"/>
                                            <input type="hidden" name="action" value="processAnnualObjectives"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Annual Output</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }



    public static function addAnnualActivities()
    {


        $user = user::getUserDetails($_REQUEST['id']);

        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Annual Activities</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                        <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Year</label>
                                                    
                                                    <div class="form-group">
                                                       <select class="form-control custom-select" name="year">
                                                        <option value="2019">2021</option>
                                                        <option value="2019">2022</option>
                                                        <option value="2019">2023</option>
                                                        <option value="2019">2024</option>
                                                       
                                                       </select>
                                                        </div> 
                                                      </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Officer</label>
                                                    
                                                    <select class="form-control custom-select" name="user_id" disabled>
                                                     <option value="' . $user['id'] . ' "> ' . $user['first_name'] . ' ' . $user['last_name'] . '</option>
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Activity</label>
                                                    
                                                    <select class="form-control custom-select" name="activity_id">
                                                      <option>Select Activity</option>
                                                      ' . self::getListofActivities() . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            
                                            
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Planned Number of Times for the year</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="planned_num"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Number of Target Beneficiaries for the year</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="target"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                            
                                             
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="user_id" value="' . $user['id'] . '"/>
                                            
                                            <input type="hidden" name="action" value="processAnnualActivities"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Annual Activities</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }


    public static function getUserAnnualActivities2($user_id)
    {


        $ids =  self::getUserAnnualActivities($user_id);

        //print_r($ids);
        $content = '';
        foreach ($ids as $id) {

            $content .= "<option value='$id'>" . self::getActivityName($id) . "</option>";
        }

        return $content;
    }


    public static function getActivityName($id = 52)
    {

        $sql = database::performQuery("SELECT name FROM ext_activitys WHERE id = $id");
        if ($sql->num_rows > 0)
            return $sql->fetch_assoc()['name'];
        else
            return 'Not Available';
    }

    public static function getUserAnnualActivities($user_id)
    {

        $sql = database::performQuery(" SELECT activities FROM `ext_area_annual_outputs` WHERE user_id=$user_id");

        $ids = array();
        $counts = 0;
        while ($data = $sql->fetch_assoc()) {
            $ids[] = $data['activities'];

            $counts++;
        }
        $ids = implode(',', $ids);

        return explode(',', $ids);
    }


    public static function getActivity($id)
    {
        $sql = database::performQuery("SELECT * FROM ext_activitys WHERE id=$id");

        return $sql->fetch_assoc();
    }

    public static function getActivities($ids)
    {

        $sql = database::performQuery("SELECT * FROM ext_activitys WHERE id IN (" . implode(',', $ids) . ")");
        $content = '';
        while ($data = $sql->fetch_assoc()) {

            $content .= "<option value='$data[id]'>$data[name]</option>";
        }

        return $content;
    }


    public static function getUserObjectivesList($id)
    {

        $sql = database::performQuery("SELECT * FROM ext_objectives_annual WHERE user_id = $id");
        $content = '';
        while ($data = $sql->fetch_assoc()) {

            $content .= "<option value='$data[id]'>$data[objective]</option>";
        }

        return $content;
    }



    public static function getListVillages()
    {

        //        $sql = database::performQuery("SELECT village.id,village.name
        //                       FROM village,subcounty,parish
        //                        WHERE
        //                        subcounty.id = parish.subcounty_id
        //                        AND parish.id = village.parish_id
        //                        AND subcounty_id LIKE ".$_SESSION['user']['location_id']);
        //        $content ='';
        //        while($data=$sql->fetch_assoc()){
        //
        //            $content .="<option value='$data[id]'>$data[name]</option>";
        //
        //        }


        $loc = $_SESSION['user']['location_id'];
        $content = '';
        $sql = database::performQuery("SELECT * FROM parish WHERE subcounty_id LIKE  $loc");
        while ($data = $sql->fetch_assoc()) {

            $content .= "<optgroup label=\"   $data[name]  Parish\">   ";

            $sqlz = database::performQuery("SELECT * FROM village WHERE parish_id LIKE $data[id]");
            while ($dataz = $sqlz->fetch_assoc()) {

                $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
            }

            $content .= "</optgroup>   ";
        }

        return $content;
    }



    public static function getListSubcounties()
    {
        $loc = $_SESSION['user']['district_id'];
        $content = '';
        $sql = database::performQuery("SELECT * FROM county WHERE district_id LIKE  $loc");
        while ($data = $sql->fetch_assoc()) {

            $content .= "<optgroup label=\"   $data[name]  County\">   ";

            $sqlz = database::performQuery("SELECT * FROM subcounty WHERE county_id LIKE $data[id]");
            while ($dataz = $sqlz->fetch_assoc()) {

                $content .= "<option value='$dataz[id]'>$dataz[name]</option>";
            }

            $content .= "</optgroup>   ";
        }

        return $content;
    }


    public static function processAddNewDailyActivity()
    {

        $ref = database::prepData($_REQUEST['ref']);
        $ref_contact = database::prepData($_REQUEST['ref_contact']);
        $group = database::prepData($_REQUEST['group']);
        $notes = database::prepData($_REQUEST['notes']);
        $user_id = $_SESSION['user']['id'];
        $women = database::prepData($_REQUEST['women']);
        $men = database::prepData($_REQUEST['men']);
        $activity = database::prepData($_REQUEST['activity_id']);
        $topic = database::prepData($_REQUEST['topic_id']);
        $ent = database::prepData($_REQUEST['entreprize_id']);
        $village = database::prepData($_REQUEST['village_id']);
        $date = makeMySQLDateTime();
        $tot = $men + $women;
        $type = database::prepData($_REQUEST['type']);
        $latitude = $_REQUEST['lat'];
        $longitude = $_REQUEST['lng'];


        $dd = "
      INSERT INTO `ext_area_daily_activity`(`date`,  `topic`, `entreprise`, `village_id`, `notes`, `num_ben_males`, `num_ben_total`, `num_ben_females`, `ben_ref_name`, `ben_ref_phone`, `ben_group`, `user_id`,  `quarterly_activity_id`,gps_latitude,gps_longitude,activity_type) 
      VALUES('$date','$topic','$ent','$village','$notes','$men','$tot','$women','$ref','$ref_contact','$group','$user_id','$activity','$latitude','$longitude','$type')";


        $sql = database::performQuery($dd);
        redirect_to(ROOT . '/?action=viewaDailyActivities');
    }


    //Handle Login of Users
    public static function syncQuarterlyActivitiesAPI()
    {


        if (isset($_REQUEST['uid'])) {

            // receiving the REQUEST params
            $id = database::prepData($_REQUEST['uid']);

            $activities = self::getUserQuartelyActivities($id);
            $topics = self::getUserQuartelyTopics($id);
            $entreprizes = self::getUserQuartelyEntreprizes($id);


            // user acctivities is found
            $response["error"] = FALSE;
            $response["user"]["activities"] = $activities;
            $response["user"]["topics"] = $topics;
            $response["user"]["entreprizes"] = $entreprizes;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }

    public static function syncDailyActivitiesAPI()
    {


        if (isset($_REQUEST['uid'])) {

            // receiving the REQUEST params//odl
            $id = database::prepData($_REQUEST['uid']);

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT ext_topics.name as a1,ext_activitys.name as a2,km_category.name as a3,parish.name as a4,district.name as a5,subcounty.name as a6,village.name as a7, `ben_group` as a8, `ben_ref_name` as a9, `ben_ref_phone` as a10, `num_ben_males` as a11, `num_ben_females` as a12, `num_ben_total` as a13, ext_area_daily_activity.user_id as a14,  `gps_latitude` as a15, `gps_longitude` as a16,  `date` as a17, village_id as a18,  ext_area_daily_activity.id as a19,   `activity_type` as a20, village_id as a21, `notes` as a22, 
       1 as a23, 1 as a24, 1 as a25, 1 as a26, 1 as a27, 1 as a28, 1 as a29, 1 as a30,  
       1 as a31,  1 as a32,  1 as a33,  1 as a34, 1 as a35, 1 as a36, 1 as a37, 1 as a38, 1 as a39, 1 as a40,  
       1 as a41,  1 as a42,  1 as a43,  1 as a44, 1 as a45, 1 as a46, 1 as a47, 1 as a48, 1 as a49, 1 as a50 
       FROM `ext_area_daily_activity`,ext_topics,km_category,ext_activitys,district,county,subcounty,parish,village WHERE  ext_topics.id = ext_area_daily_activity.topic 
AND ext_activitys.id = ext_area_daily_activity.quarterly_activity_id
AND km_category.id = ext_area_daily_activity.entreprise
AND district.id = county.district_id
AND county.id =subcounty.county_id
AND subcounty.id = parish.subcounty_id
AND parish.id = village.parish_id
AND village.id = ext_area_daily_activity.village_id
AND ext_area_daily_activity.user_id =$id");
            $activities = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $activities[] = $data;
                }
            }

            // user farmers are known
            $response["error"] = FALSE;
            $response["activities"] = $activities;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }


    public static function syncOutbreaksAPI()
    {


        if (isset($_REQUEST['uid'])) {

            // receiving the REQUEST params
            $id = database::prepData($_REQUEST['uid']);

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT `id`, `a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, 
                                                    `a12`, `a13`, `a14`, `a15`, `a16`, `a17`, `a18`, `a19`, `a20`, id as a21, `a22`, 
                                                    `a23`, `a24`, `a25`, `a26`, `a27`, `a28`, `a29`, `a30`, `a31`, `a32`, `a33`, `a34`, 
                                                    `a35`, `a36`, `a37`, `a38`, `a39`, `a40`, `a41`, `a42`, `a43`, `a44`, `a45`, `a46`, 
                                                    `a47`, `a48`, `a49`, `a50`, `synced`, `syncedDateTime` FROM `mod_crisis`  WHERE a19='$id'");
            $outbreaks = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $outbreaks[] = $data;
                }
            }

            // user farmers are known
            $response["error"] = FALSE;
            $response["outbreaks"] = $outbreaks;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }


    public static function syncWeatherInfo()
    {


        if (isset($_REQUEST['district'])) {

            // receiving the REQUEST params
            $id = database::prepData($_REQUEST['district']);

            $parishList = self::getParishInDistrict($id);

            $weather_info = self::getWeatherByIDs($parishList);


            // user acctivities is found
            $response["error"] = FALSE;
            $response["weather_info"] = $weather_info;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }
    public static function getUserQuartelyActivities($id)
    {

        //First Get the Quaterly Actvities & Annual Ids
        $sql =  database::performQuery("SELECT annual_id FROM `ext_area_quaterly_activity` WHERE `user_id` =$id ");
        $ids = [];
        $ids[] =  52;
        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {
                $ids[] = $data['annual_id'];
            }
            $ids = array_unique($ids);
            return implode(',', $ids);
        } else
            return 52;
    }



    public static  function syncUserActivities()
    {

        if (isset($_REQUEST['uid'])) {

            // receiving the REQUEST params
            $id = database::prepData($_REQUEST['uid']);

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM mod_ediary WHERE `a14` =$id ");
            $activities = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $activities[] = $data;
                }
            }


            // user farmers are known
            $response["error"] = FALSE;
            $response["activities"] = $activities;

            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }





    public static function getParishInDistrict($id)
    {

        //First Get Weather PArish IDs for given District
        $sql =  database::performQuery("SELECT id FROM weather_parish WHERE `District` LIKE '%$id%' ");
        $ids = [];
        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {
                $ids[] = $data['id'];
            }
            $ids = array_unique($ids);
            return implode(',', $ids);
        }
    }



    public static function getUserQuartelyTopics($id)
    {

        //First Get the Quaterly Actvities & Annual Ids
        $sql =  database::performQuery("SELECT topic FROM `ext_area_quaterly_activity` WHERE `user_id` =$id ");
        $ids = [];
        $ids[] =  119;
        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {
                $ids[] = $data['topic'];
            }
            $ids = array_unique($ids);
            return implode(',', $ids);
        } else
            return 119;
    }



    public static function getUserQuartelyEntreprizes($id)
    {

        //First Get the Quaterly Actvities & Annual Ids
        $sql =  database::performQuery("SELECT entreprizes FROM `ext_area_quaterly_activity` WHERE `user_id` =$id ");
        $ids = [];
        $ids[] =  198;
        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {
                $ids[] = $data['entreprizes'];
            }
            $ids = array_unique($ids);
            return implode(',', $ids);
        } else
            return 198;
    }


    public static function syncAllTopics()
    {
        $sql =  database::performQuery("SELECT * FROM `ext_topics` ORDER BY id ASC");
        $topics = [];
        while ($data = $sql->fetch_assoc()) {
            $topics[] = $data;
        }
        $response["error"] = FALSE;
        $response["topics"] = $topics;
        echo json_encode($response);
    }



    public static function syncSeedDataAPI()
    {
        $response = [];

        if (1) {

            //First Get the Topics
            $sql =  database::performQuery("SELECT * FROM `ext_topics`");
            $topics = [];
            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $topics[] = $data;
                }
            }


            //First Get the Activities
            $sql2 =  database::performQuery("SELECT * FROM `ext_activitys`");
            $activities = [];
            if ($sql2->num_rows > 0) {
                while ($data2 = $sql2->fetch_assoc()) {
                    $activities[] = $data2;
                }
            }

            //First Get the Entreprizes
            $sql2 =  database::performQuery("SELECT * FROM `km_category`");
            $entreprizes = [];
            if ($sql2->num_rows > 0) {
                while ($data2 = $sql2->fetch_assoc()) {
                    $entreprizes[] = $data2;
                }
            }

            //First Get the Districts
            $sql4 =  database::performQuery("SELECT * FROM `district` ");
            $districts = [];
            if ($sql4->num_rows > 0) {
                while ($data4 = $sql4->fetch_assoc()) {
                    $districts[] = $data4;
                }
            }


            //First Get the Counties
            $sql5 =  database::performQuery("SELECT * FROM `county`");
            $counties = [];
            if ($sql5->num_rows > 0) {
                while ($data5 = $sql5->fetch_assoc()) {
                    $counties[] = $data5;
                }
            }


            //First Get the SubCounties
            $sql5 =  database::performQuery("SELECT * FROM `subcounty`");
            $subcounties = [];
            if ($sql5->num_rows > 0) {
                while ($data5 = $sql5->fetch_assoc()) {
                    $subcounties[] = $data5;
                }
            }



            //GRM Data
            $sql5 =  database::performQuery("SELECT * FROM `grievance_feedback_mode`");
            $grievance_feedback_mode = [];
            if ($sql5->num_rows > 0) {
                while ($data5 = $sql5->fetch_assoc()) {
                    $grievance_feedback_mode[] = $data5;
                }
            }

            $sql5 =  database::performQuery("SELECT * FROM `grievance_mode_of_receipt`");
            $grievance_mode_of_receipt = [];
            if ($sql5->num_rows > 0) {
                while ($data5 = $sql5->fetch_assoc()) {
                    $grievance_mode_of_receipt[] = $data5;
                }
            }

            $sql5 =  database::performQuery("SELECT * FROM `grievance_nature`");
            $grievance_nature = [];
            if ($sql5->num_rows > 0) {
                while ($data5 = $sql5->fetch_assoc()) {
                    $grievance_nature[] = $data5;
                }
            }

            $sql5 =  database::performQuery("SELECT * FROM grivance_type");
            $grivance_type = [];
            if ($sql5->num_rows > 0) {
                while ($data5 = $sql5->fetch_assoc()) {
                    $grivance_type[] = $data5;
                }
            }

            $sql5 =  database::performQuery("SELECT * FROM `grivance_settlement`");
            $grivance_settlement = [];
            if ($sql5->num_rows > 0) {
                while ($data5 = $sql5->fetch_assoc()) {
                    $grivance_settlement[] = $data5;
                }
            }








            //Data found
            $response["error"] = FALSE;
            // $response["topics"] = $topics;
            $response["activities"] = $activities;
            $response["entreprizes"] = $entreprizes;
            $response["districts"] = $districts;
            $response["counties"] = $counties;
            $response["subcounties"] = $subcounties;
            $response["grievance_feedback_mode"] = $grievance_feedback_mode;
            $response["grievance_mode_of_receipt"] = $grievance_mode_of_receipt;
            $response["grievance_nature"] = $grievance_nature;
            $response["grivance_type"] = $grivance_type;
            $response["grivance_settlement"] = $grivance_settlement;


            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
            echo "<pre>";
            print_r($topics);
        }
    }

    public static function syncActivitiesAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `ext_activitys`");
            $activities = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $activities[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["activities"] = $activities;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }

    public static function syncTopicsNewAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `ext_topics`");
            $activities = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $activities[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["topics"] = $activities;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }
    public static function syncEntreprisesAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `km_category`");
            $entreprises = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $entreprises[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["entreprises"] = $entreprises;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }
    public static function syncGRMNatureAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `grievance_nature`");
            $entreprises = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $entreprises[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["grmNature"] = $entreprises;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }
    public static function syncGRMTypesAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `grivance_type`");
            $entreprises = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $entreprises[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["grmType"] = $entreprises;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }
    public static function syncGRMSettlementAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `grivance_settlement`");
            $entreprises = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $entreprises[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["grmSettlement"] = $entreprises;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }
    public static function syncGRMFeedbackModeAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `grievance_feedback_mode`");
            $entreprises = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $entreprises[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["grmFeedbackMode"] = $entreprises;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }
    public static function syncGRMModeOfReceiptAPI()
    {
        $response = [];

        if (1) {

            //First Get the Quaterly Actvities & Annual Ids
            $sql =  database::performQuery("SELECT * FROM `grievance_mode_of_receipt`");
            $entreprises = [];


            if ($sql->num_rows > 0) {
                while ($data = $sql->fetch_assoc()) {
                    $entreprises[] = $data;
                }
            }

            // topics found
            $response["error"] = FALSE;
            $response["grmModeOfReceipt"] = $entreprises;
            echo json_encode($response);
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters are missing!";
            echo json_encode($response);
        }
    }




    public static function getWeatherByIDs($ids)
    {



        $date_today = makeMySQLDate();
        $date_last = date("Y-m-d", strtotime("-7 day", strtotime($date_today)));
        $date_today = date("Y-m-d", strtotime("+7 day", strtotime($date_today)));


        //First Get the Quaterly Actvities & Annual Ids
        $sql =  database::performQuery("SELECT * FROM `weather_infomation` WHERE parish_id IN ($ids) AND forecast_date BETWEEN '$date_last' AND '$date_today'");
        $ids = [];

        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {
                $ids[] = $data;
            }

            return $ids;
        } else
            return [];
    }



    public static function addNewDailyActivity()
    {

        $user = $_SESSION['user']['id'];
        //Get Quarterly activity IDS not Annual IDs for daily activities and report making

        //First Get the Quaterly Actvities & Annual Ids
        $sql =  database::performQuery("SELECT id,annual_id FROM `ext_area_quaterly_activity` WHERE `user_id` =$user ");
        $ids = [];
        $counter = 0;
        while ($data = $sql->fetch_assoc()) {
            $ids[$counter]['id'] = $data['id'];
            $ids[$counter]['activity'] = $data['annual_id'];
            $counter++;
        }

        //         echo'<pre>';
        //         print_r($ids);
        //         echo '</pre>';

        $cont = '';
        //Seperate both and pull annual activity using the annual id
        foreach ($ids as $id) {

            //TODO this is pointless now
            //             $sqlz = database::performQuery(" SELECT activity FROM `ext_area_annual_activity` WHERE id=$id[annual_id]");
            //             $dataz = $sqlz->fetch_assoc();
            $name =  self::getActivityName($id['activity']);
            $cont .= "<option value='$id[id]'>" . $name . "</option>";
        }







        $activities = $cont;


        $topics = self::getListofUserTopics($user);
        $entt = self::getListofUserEntts($user);
        $villages = self::getListVillages();
        $subcounty = self::getListSubcounties();
        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">

                 
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Daily Activity</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                        
                                        <input type="hidden" name="type" value="0">
                                         
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Activity From Quarterly Activities</label>
                                                    
                                                    <select class="form-control custom-select" name="activity_id">
                                                      <option>Select Activity</option>
                                                      ' . $activities . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                     
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Topic Covered</label>
                                                    
                                                    <select class="form-control custom-select" name="topic_id">
                                                      <option value="119">Not Applicable</option>
                                                      ' . $topics . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                     
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Entreprize Covered</label>
                                                    
                                                    <select class="form-control custom-select" name="entreprize_id">
                                                      <option value="198">Not Applicable</option>
                                                      ' . $entt . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>';


        //For Senior officers, show all locations in district
        //                                          if($_SESSION['user']['user_category_id'] > 18)
        //                                          {


        $content .= ' <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Subcounty</label>
                                                        
                                                        
                                                         <select class="form-control custom-select" id="sel_subcounty">
                                                           <option  value="0">Select Sub-County /  Division</option>   
                                                            ' . $subcounty . '   
                                                        </select>
                                                        
                                                        
                                                      
                                                         </div>
                                                </div>
                                                
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Parish</label>
                                                        
                                                       <select class="form-control" id="sel_parish" name="parish" required>
                                                            <option  value="0">Select Parish / Town</option>      
                                                        </select>
                                                        
                                                         </div>
                                                </div>
                                                
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Village</label>
                                                        
                                                        <select class="form-control" id="sel_village" name="village_id">
                                                            <option  value="0">Select Village / Ward</option>      
                                                        </select>
                                                        
                                                         </div>
                                                </div>
                                                
                                                ';

        //                                         }

        //                                          else{
        //
        //                                             //For normal officers show villages attached to them
        //                                                $content .=' <div class="col-md-12">
        //                                                    <div class="form-group">
        //                                                        <label class="control-label">Select Village</label>
        //
        //                                                        <select class="form-control custom-select" name="village_id">
        //                                                          <option>Select Village</option>
        //                                                          '.$villages.'
        //
        //                                                        </select>
        //
        //                                                         </div>
        //                                                </div>';
        //
        //
        //                                          }



        $content .= '
                                            
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Male Benefirciaries Reached</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" name="men"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                       
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Female Benefirciaries Reached</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" name="women"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                                   
                                                                          
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Beneficiary Group</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" name="group"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Beneficiary Referance Name</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="ref"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Beneficiary Reference Contact</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="ref_contact"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Latitude</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="Latitude" name="lat"   placeholder="" readonly>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Longitude</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="Longitude" name="lng"   placeholder="" readonly>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Notes</label>
                                                    
                                                    <div class="form-group">
                                                    <textarea  class="form-control" name="notes"    > </textarea>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                             
                                            
                                              <!--
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Photo</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="file" class="form-control" id="nametext1" name="filetoUpload"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>-->
                                            
                                             
                                             
                                            
                                            
                                             
                                            
                                             
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            
                                            <input type="hidden" name="action" value="processAddNewDailyActivity"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Daily Activitiy</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }
    public static function addUnplannedActivity()
    {

        $user = $_SESSION['user']['id'];
        //Get Quarterly activity IDS not Annual IDs for daily activities and report making





        $villages = self::getListVillages();
        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">

                 
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Unplanned Activity</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                        
                                            <input type="hidden" name="type" value="1">
                                         
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Activity </label>
                                                    
                                                    <select class="form-control custom-select" name="activity_id">
                                                      <option>Select Activity</option>
                                                      ' . self::getListofActivities() . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                     
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Topic </label>
                                                    
                                                    <select class="form-control custom-select" name="topic_id">
                                                      <option>Select Topic</option>
                                                      ' . self::getListofTopics() . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                     
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Entreprize Covered</label>
                                                    
                                                    <select class="form-control custom-select" name="entreprize_id">
                                                      <option>Select Entreprize</option>
                                                      ' . self::getListofEnterprizes() . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                     
                                             
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Village</label>
                                                    
                                                    <select class="form-control custom-select" name="village_id">
                                                      <option>Select Village</option>
                                                      ' . $villages . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                     
                                            
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Male Benefirciaries Reached</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" name="men"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                       
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Female Benefirciaries Reached</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" name="women"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                                   
                                                                          
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Beneficiary Group</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" name="group"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Beneficiary Referance Name</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="ref"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Beneficiary Reference Contact</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="ref_contact"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Latitude</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="Latitude" name="lat"   placeholder="" readonly>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Longitude</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="Longitude" name="lng"   placeholder="" readonly>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Notes</label>
                                                    
                                                    <div class="form-group">
                                                    <textarea  class="form-control" name="notes"    > </textarea>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                             
                                            
                                              <!--
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Photo</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="file" class="form-control" id="nametext1" name="filetoUpload"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>-->
                                            
                                             
                                             
                                            
                                            
                                             
                                            
                                             
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            
                                            <input type="hidden" name="action" value="processAddNewDailyActivity"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Daily Activitiy</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }


    public static function checkForAnnualWorkplan($user_id)
    {

        $financial_year = get_finacial_year_range()['year_range'];

        $sql = database::performQuery("SELECT * FROM `ext_area_annual_outputs` WHERE year='$financial_year' AND user_id='$user_id'");


        if ($sql->num_rows > 0)
            return 1;
        else
            return 0;
    }

    public static function processEditQuarterlyActivities()
    {


        if (self::checkForAnnualWorkplan($_REQUEST['user_id']) == 1) {
            //Keep Silent...Continue
        } else {
            redirect_to(ROOT . "/?action=addNewWorkplan&id=" . $_REQUEST['user_id']);
        }


        $user = user::getUserDetails($_REQUEST['user_id']);
        $activities = self::getUserAnnualActivities2($_REQUEST['user_id']);
        $topics = self::getListofTopics();
        $outputs = self::getListofOutputs($_REQUEST['user_id']);  
        $entt = self::getListofEnterprizes();

        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Quarterly Activities for ' . $user['first_name'] . ' ' . $user['last_name'] . '</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body"> 
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                        <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Extension Officer</label>
                                                    
                                                     <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="officer"   placeholder="' . $user['first_name'] . ' ' . $user['last_name'] . '" disabled >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Outputs to Fullfill</label>
                                                    
                                                  
                                                      </div> 
                                                      
                                                      
                                                          <select class="select2 form-control" name="outputs[]" multiple="multiple" style="height: 36px;width: 100%;" required>
                                    ' . $outputs . '
                                </select>
                                            <br />          
                                            <br />   <br />          
                                            <br />             
                                                  
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Quarter</label>
                                                    
                                                    <select class="form-control custom-select" name="quarter" required>
                                                      <option value="1" SELECTED>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Activity From Annual Activities for this Quarter</label>
                                                    
                                                    <select class="form-control custom-select" name="activity_id" required>
                                                      <option>Select Activity</option>
                                                      ' . $activities . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Topics</label>
                                                    
                                                      </div>
                                                      
                                               
                                                      
                                                      
                                <select class="select2 form-control" name="topics[]" multiple="multiple" style="height: 36px;width: 100%;" required>
                                    ' . $topics . '
                                </select>
                                
                                            <br />          
                                            <br />   <br />          
                                            <br />             
                                                      
                                            </div>
                                      <br />          
                                            <br />   
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Entreprizes</label>
                                                    
                                                  
                                                      </div>
                                                      
                                                      
                                                          <select class="select2 form-control" name="entt[]" multiple="multiple" style="height: 36px;width: 100%;" required>
                                    ' . $entt . '
                                </select>
                                            <br />          
                                            <br />   <br />          
                                            <br />             
                                                  
                                            </div>
                                      
                                      
                                      
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Planned Number of Times this Quarter</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="planned_num"   placeholder="" required>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Number of Target Beneficiaries this Quarter</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="target"   placeholder="" required>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                              <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Budget this Quarter</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="budget"   placeholder="" required>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                             
                                            
                                            
                                             
                                            
                                             
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="id" value="' . $_REQUEST['user_id'] . '"/>
                                            <input type="hidden" name="action" value="processQuarterlyActivities"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Quarterly Activitiy</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>';

        return $content;
    }


    public static function addKMU()
    {



        $entt = self::getListofAllEnterprizes();

        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New KMU Content</h4>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                        
                                          
                                            <div class="col-md-12">
                                               
                                                
                                                <select id="content-categories" class="select2 form-control col-md-6" name="type" style="width:30%;"required>
                                                    <option> select a category of content </option>
                                                    <option value="1">Video</option>
                                                    <option value="2">Manuals</option>
                                                    <option value="3">Briefing Papers</option>
                                                    <option value="4">Reports</option>
                                                </select>

                                            </div>
                                        <br />
                                        <br />
                                        <div class="col-md-12" style="margin-top: 20px;">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Title of Content</label>
                                                    
                                                     <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="title"    required>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label" style="margin-bottom: 20px;">Language of Content</label>
                                                    
                                                     <div class="form-group">
                                                  <select class="select2 form-control form-check-lg " name="language" required>
                                    ' . user::getLanguages() . '
                                </select>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                                 
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Entreprizes Covered by this content <sup>*</sup> type to search</label>
                                                    
                                                  
                                                      </div>
                                                      
                                                      
                                                          <select class="select2 form-control" name="entt[]" multiple="multiple" style="height: 36px;width: 100%;" required>
                                    ' . $entt . '
                                </select>
                                            <br />          
                                              
                                            <br />             
                                                  
                                            </div>
                                      
                                      
                                      
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Content produced for which organization</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="produced_for"   placeholder="" required>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                      
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Content produced by which organization</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="produced_by"   placeholder="" required>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Brief Description of this content.</label>
                                                    
                                                    <div class="form-group">
                                                    <textarea class="form-control" name="description" rows="5" required></textarea>
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                              <!--/span-->
                                            <div class="col-md-12" id="file-content-one" style="display:none;">
                                                <div class="form-group has-danger" >
                                                    <label class="control-label">Youtube Video URL</label>
                                                    
                                                    <div class="form-group">
                                                            <input type="text" class="form-control" id="nametext1" name="url"   placeholder="https://www.youtube.com/watch?v=Ert-7FuR40E" >
                                                    </div> 
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12" id="file-content-two" style="display:none;">
                                                <div>
                                                    <label for="formFile" class="form-label">File Content</label>
                                                    <input class="form-control" type="file" name="file_content" id="formFile">
                                                </div>
                                            </div>
                                             
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="id" value="' . $_SESSION['user']['id'] . '"/>
                                            <input type="hidden" name="action" value="processAddKMU"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add KMU Content</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function processAddKMU()
    {

        $user_id = $_REQUEST['id'];
        $type = database::prepData($_REQUEST['type']);
        $title = database::prepData($_REQUEST['title']);
        $description = database::prepData($_REQUEST['description']);
        $language = database::prepData($_REQUEST['language']);
        $produced_for = database::prepData($_REQUEST['produced_for']);
        $produced_by = database::prepData($_REQUEST['produced_by']);
        $url = database::prepData($_REQUEST['url']);

        if (!empty($_FILES['file_content']["name"])) {
            $fileName = $_FILES["file_content"]["name"];

            $isValidFile = true;

            if (file_exists($fileName)) {
                echo "<span>File already exists.</span>";
                $isValidFile = false;
            }

            if ($isValidFile) {
                move_uploaded_file($_FILES["file_content"]["tmp_name"], 'kmu_content/' . $fileName);
            }

            $sql = database::performQuery("INSERT INTO `kmu`(`title`, `km_content_category_id`, `km_language_id`, `produced_for`, `produced_by`, `description`,  `file_name`)
                        VALUES ('$title',$type,$language,'$produced_for','$produced_by','$description','$fileName')");


            $last_id = database::getLastInsertID();



            redirect_to(ROOT . '/?action=manageKMU');
        } else {

            $sql = database::performQuery("INSERT INTO `kmu`(`title`, `km_content_category_id`, `km_language_id`, `produced_for`, `produced_by`, `description`,  `video`)
                    VALUES ('$title',$type,$language,'$produced_for','$produced_by','$description','$url')");


            print_r($sql);
            $last_id = database::getLastInsertID();


            //Handle Categories here
            foreach ($_REQUEST['entt'] as $ent) {
                $idx = $ent;

                $sqlx = database::performQuery("INSERT INTO `kmu_has_km_category`(`kmu_id`, `km_category_id`) 
                                                                            VALUES($last_id,$idx)");
            }
            redirect_to(ROOT . '/?action=manageKMU');
        }
    }

    public static function manageQuaterlyActivities()
    {



        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Quarterly Activitiy</h4>
                            </div>
                            <form action="" method="GET" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Officer</label>
                                                    
                                                    <select class="form-control custom-select" name="user_id">
                                                      ' . self::getListofUsers() . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                           
                                            
                                            
                                             
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="action" value="processEditQuarterlyActivities"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Go to Step 2</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }


    public static function switchUserManageListSMS()
    {

        $id = $_SESSION['user']['location_id'];



        $content = '';
        switch ($_SESSION['user']['user_category_id']) {



                //District heads
            case 10:
            case 11:
            case 84:
            case 55:
                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,location_id
                   FROM user
                   WHERE district_id = " . $_SESSION['user']['district_id'] . "
                    AND user_category_id IN (" . userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs() . ")
              
                   ";
                break;
                //National level Managers
            case 5:
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 31:
            case 32:
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            case 41:
            case 42:
            case 43:
            case 44:
            case 45:
            case 46:
            case 47:
            case 48:
            case 52:
            case 53:
            case 54:
                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,location_id
                   FROM user
                   WHERE   user_category_id IN (" . userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs() . ")
                    AND district_id = " . $_REQUEST['district_id'] . " ";


                break;


            default:
                $content = '';
                break;
        }


        return $content;
    }

    public static function switchUserManageList()
    {

        $id = $_SESSION['user']['location_id'];



        $user_cat = 0;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyCropExtensionStaffUserIDs() . ')';
                break;

            case 3:
                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyVetExtensionStaffUserIDs() . ')';
                break;

            case 4:
                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyFishExtensionStaffUserIDs() . ')';
                break;

            case 12:
                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyEntomologyExtensionStaffUserIDs() . ')';
                break;

            default:
                break;
        }

        $content = '';
        switch ($_SESSION['user']['user_category_id']) {


            case 1:
                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE location_id = $id
                   AND user_category_id IN (" . userMgmt::getSubcountyExtensionStaffUserIDs() . ")
                   ";
                break;


            case 10:
            case 11:
            case 84:
            case 55:
                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id  as location,user_category_id
                   FROM user
                   WHERE district_id = " . $_SESSION['user']['district_id'] . "
                
                     ";

                //AND user_category_id NOT IN (".userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs().")

                break;

            case 5:
            case 54:
                //Switch to Manage National level, district heads and zonal heads

                if ($_REQUEST['district_id'] == 0) {
                    //Case WHere District ID is 0
                    $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,user_category_id,directorate_id,department_id,division_id,zone_id
                   FROM user,user_category,user_group
                   WHERE  user.user_category_id = user_category.id
                   AND user_category.user_group_id = user_group.id
                    AND user_group_id IN (1,2,3)";
                } else {
                    $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE district_id = " . $_REQUEST['district_id'] . "
                     
                   ";

                    //AND user_category_id NOT IN (".userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs().")

                }



                break;

            case 16:

                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE                  
                  user_category_id = 9 OR user_category_id = 20 OR user_category_id = 3 OR user_category_id = 10 OR user_category_id = 23 
                   ";


                break;


            case 17:

                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE  user_category_id = 8 OR user_category_id = 19 OR user_category_id = 22 OR user_category_id = 2 OR user_category_id = 10
                   ";


                break;

            case 18:

                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user WHERE user_category_id = 7 OR user_category_id = 21  OR user_category_id = 4  OR user_category_id = 10 
                   ";


                break;
                //Subject matter Specialists
            case 2:
            case 3:
            case 4:
            case 12:
                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE district_id =  " . $_SESSION['user']['district_id'] . "
                   AND  $user_cat
                   ";

                break;

            default:
                $content = '';
                break;
        }


        return $content;
    }

    public static function switchUserMeetings()
    {

        $id = $_SESSION['user']['location_id'];




        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

                //National
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:

                $content = "SELECT meeting.id,district.name as district,subcounty.name as subcounty, theme,meeting.created,attendees,meeting.status_id,meeting.location_id
                   FROM district,subcounty,county,meeting
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id =  meeting.location_id
                   ORDER BY meeting.id DESC                
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

                $content = "SELECT meeting.id,district.name as district,subcounty.name as subcounty, theme,meeting.created,attendees,meeting.status_id,meeting.location_id
                   FROM district,subcounty,county,meeting
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id =  meeting.location_id
                   AND district.id =  " . $_SESSION['user']['district_id'] . "  
                    ORDER BY meeting.id DESC                      
                   ";

                break;


                //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

                $content = "SELECT meeting.id,district.name as district,subcounty.name as subcounty, theme,meeting.created,attendees,meeting.status_id,meeting.location_id
                   FROM district,subcounty,county,meeting
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id =  meeting.location_id
                   AND subcounty.id =  " . $_SESSION['user']['location_id'] . "    
                   ORDER BY meeting.id DESC                    
                   ";

                break;

            default:
                $content = '';
                break;
        }


        return $content;
    }

    public static function switchUserIdsList()
    {

        $id = $_SESSION['user']['district_id'];


        switch ($_SESSION['user']['user_category_id']) {
                //Subcounty Chief/ Town Clerk
            case 1:
                $user_cat = ' AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)';
                break;
                //DAO
            case 2:
                $user_cat = ' AND (user_category_id = 2 OR user_category_id = 8 OR user_category_id = 19 OR user_category_id = 22)';
                break;
                //DVO
            case 3:
                $user_cat = ' AND (user_category_id = 3 OR user_category_id = 9 OR user_category_id = 20 OR user_category_id = 23)';
                break;
                //DFO
            case 4:
                $user_cat = ' AND (user_category_id = 4 OR user_category_id = 7 OR user_category_id = 21)';
                break;
                //DPMO
            case 10:
            case 11:
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 31:
            case 32:
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            case 41:
            case 42:
            case 43:
            case 44:
            case 45:
            case 46:
            case 47:
            case 48:
                $user_cat = ' AND (user_category_id = 7 OR user_category_id = 8 OR 
                             user_category_id = 9 OR user_category_id = 2 OR 
                             user_category_id = 3 OR user_category_id = 4 OR 
                             user_category_id = 11  OR user_category_id = 12 OR 
                             user_category_id = 14  OR  user_category_id = 19  OR 
                             user_category_id = 20  OR user_category_id = 21  OR 
                             user_category_id = 22  OR user_category_id = 23 OR 
                             user_category_id = 1)';
                break;

            default:
                $user_cat = ' AND user.id = ' . $_SESSION['user']['id'];
                break;
        }

        $content = "SELECT user.id
                   FROM user
                   WHERE district_id =$id
                    $user_cat
                   ";

        //echo $content;

        return $content;
    }


    public static function countAllMyOfficers()
    {
        $sql = database::performQuery(self::switchUserIdsList());

        return $sql->num_rows;
    }


    public static function countAllMyOfficersNational()
    {
        $sql = database::performQuery("SELECT * FROM user");

        return $sql->num_rows;
    }


    public static function returnMyUserIDs()
    {
        $sql = database::performQuery(self::switchUserIdsList());

        $ids = [$_SESSION['user']['id']];
        while ($data = $sql->fetch_assoc()) {

            $ids[] = $data['id'];
        }
        if (empty($ids)) {
            return null;
        } else {
            return implode(',', $ids);
        }
    }


    public static function countAllWomenDistrict()
    {
        $id = $_SESSION['user']['id'];

        $user_ids = self::returnMyUserIDs();


        if (!(empty($user_ids))) {
            $sql = database::performQuery("SELECT SUM(num_ben_females) as women FROM `ext_area_daily_activity` where user_id IN (" . self::returnMyUserIDs() . ") ");
            if ($sql->num_rows > 0) {
                return $sql->fetch_assoc()['women'];
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public static function countAllWomenNational()
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_females) as women FROM `ext_area_daily_activity` where 1 ");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMenDistrict()
    {
        $id = $_SESSION['user']['id'];
        $user_ids = self::returnMyUserIDs();


        if (!(empty($user_ids))) {

            $sql = database::performQuery("SELECT SUM(num_ben_males) as women FROM `ext_area_daily_activity` where user_id IN (" . self::returnMyUserIDs() . ")");
            if ($sql->num_rows > 0) {
                return $sql->fetch_assoc()['women'];
            } else {
                return 0;
            }
        } else {

            return 0;
        }
    }
    public static function countAllMenNational()
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_males) as women FROM `ext_area_daily_activity` where 1 ");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMenWomenDistrict()
    {
        $id = $_SESSION['user']['id'];
        $user_ids = self::returnMyUserIDs();
        if (!(empty($user_ids))) {

            $sql = database::performQuery("SELECT SUM(num_ben_total) as women FROM `ext_area_daily_activity` where user_id IN (" . self::returnMyUserIDs() . ")");
            if ($sql->num_rows > 0) {
                return $sql->fetch_assoc()['women'];
            } else {
                return 0;
            }
        } else {

            return 0;
        }
    }

    public static function countAllMenWomenNational()
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_total) as women FROM `ext_area_daily_activity` where 1 ");
        return $sql->fetch_assoc()['women'];
    }





    public static function beneficiariesByMonth()
    {


        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $data = '';
        for ($x = 0; $x < 12; $x++) {

            $p = $x + 1;
            $data .= '<tr>
                     <td>' . $p . '</td>
                     <td>' . $month[$x] . '</td>
                     <td>' . number_format(self::countAllUserActtivitiesMonth($p)) . '</td>
                     <td>' . number_format(self::countAllWomenDistrictMonth($p)) . '</td>
                     <td>' . number_format(self::countAllMenDistrictMonth($p)) . '</td>
                     <td>' . number_format(self::countAllMenWomenDistrictMonth($p)) . '</td>
                    
                       </tr>';
        }




        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                
                                                <th>Month</th>
                                                <th>Activities</th>
                                                <th>Women Reached</th>
                                                <th>Men Reached</th>
                                                <th>Total Beneficiaries</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $data . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Month</th>
                                                <th>Activities</th>
                                                <th>Women Reached</th>
                                                <th>Men Reached</th>
                                                <th>Total Beneficiaries</th>
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



    public static function beneficiariesNational()
    {


        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $data = '';
        for ($x = 0; $x < 12; $x++) {

            $p = $x + 1;
            $data .= '<tr>
                     <td>' . $p . '</td>
                     <td>' . $month[$x] . '</td>
                     <td>' . number_format(self::countAllUserActtivitiesNational($p)) . '</td>
                     <td>' . number_format(self::countAllWomenDistrictNational($p)) . '</td>
                     <td>' . number_format(self::countAllMenDistrictNational($p)) . '</td>
                     <td>' . number_format(self::countAllMenWomenDistrictNational($p)) . '</td>
                    
                       </tr>';
        }




        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                
                                                <th>Month</th>
                                                <th>Activities</th>
                                                <th>Women Reached</th>
                                                <th>Men Reached</th>
                                                <th>Total Beneficiaries</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $data . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Month</th>
                                                <th>Activities</th>
                                                <th>Women Reached</th>
                                                <th>Men Reached</th>
                                                <th>Total Beneficiaries</th>
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


    public static function countAllUserActtivitiesMonth($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` where  user_id IN (" . self::returnMyUserIDs() . ") AND MONTH(date) = $month");
        if ($sql->num_rows > 0) {
            return $sql->num_rows;
        } else
            return 0;
    }

    public static function countAllUserActtivitiesNational($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` where  MONTH(date) = $month");
        return $sql->num_rows;
    }



    public static function countAllWomenDistrictMonth($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_females) as women FROM `ext_area_daily_activity` where user_id IN (" . self::returnMyUserIDs() . ") AND MONTH(date) = $month");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllWomenDistrictNational($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_females) as women FROM `ext_area_daily_activity` where  MONTH(date) = $month");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMenDistrictMonth($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_males) as women FROM `ext_area_daily_activity` where user_id IN (" . self::returnMyUserIDs() . ") AND MONTH(date) = $month");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMenDistrictNational($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_males) as women FROM `ext_area_daily_activity` where MONTH(date) = $month");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMenWomenDistrictMonth($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_total) as women FROM `ext_area_daily_activity` where user_id IN (" . self::returnMyUserIDs() . ") AND MONTH(date) = $month");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMenWomenDistrictNational($month = 1)
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_total) as women FROM `ext_area_daily_activity` where  MONTH(date) = $month");
        return $sql->fetch_assoc()['women'];
    }


    public static function getTitleLocation($directorate, $department, $division, $zone)
    {
        $content = '';

        //Check for Directorate
        if (!empty($directorate)) {
            $sql = database::performQuery("SELECT * FROM directorates WHERE id=$directorate");
            while ($data = $sql->fetch_assoc()) {
                $content .= '<b>Directorate :</b> ' . $data['directorate'] . '<br /><br />';
            }
        } else {
            //Keep Silent
            $content .= '';
        }


        //Check for Department
        if (!empty($department)) {
            $sql = database::performQuery("SELECT * FROM departments WHERE id=$department");
            while ($data = $sql->fetch_assoc()) {
                $content .= '<b>Department :</b> ' . $data['department'] . '<br /><br />';
            }
        } else {
            //Keep Silent
            $content .= '';
        }



        //Check for Division
        if (!empty($division)) {
            $sql = database::performQuery("SELECT * FROM divisions WHERE id=$division");
            while ($data = $sql->fetch_assoc()) {
                $content .= '<b>Division : </b>' . $data['division'] . '<br /><br />';
            }
        } else {
            //Keep Silent
            $content .= '';
        }


        //Check for Zone
        if (!empty($zone)) {
            $sql = database::performQuery("SELECT * FROM zone WHERE id=$zone");
            while ($data = $sql->fetch_assoc()) {
                $content .= '<b>Zone : </b>' . $data['name'] . '<br /><br />';
            }
        } else {
            //Keep Silent
            $content .= '';
        }





        return $content;
    }


    public static function getUserLocation($subcounty)
    {
        if ($subcounty == 0)
            return "DISTRICT/CITY HEADQUARTERS";
        else {
            $sql = database::performQuery("SELECT name FROM subcounty 
                                             WHERE id=$subcounty");
            while ($data = $sql->fetch_assoc()) {
                $content = $data['name'];
            }
            return $content;
        }
    }

    public static function getUserDistrict($district)
    {
        if ($district == 0)
            return " ";
        else {
            $sql = database::performQuery("SELECT name FROM district 
                                             WHERE id=$district");
            while ($data = $sql->fetch_assoc()) {
                $content = $data['name'];
            }
            return $content . ' /<br />';
        }
    }


    public static function checkCityDistrictStatus($district_id)
    {
        $sql = database::performQuery("SELECT * FROM district WHERE id=$district_id LIMIT 1");
        $result = $sql->fetch_assoc()['district_status'];
        if ($result == 1)
            return 'District';
        else
            return 'City';
    }

    public static function checkCityDistrictAlogDistrict($district_id)
    {
        $sql = database::performQuery("SELECT * FROM district WHERE id=$district_id LIMIT 1");
        return $sql->fetch_assoc()['district_status'];
    }

    public static function checkCityDistrictAlogSubcounty($subcounty_id)
    {
        $sql = database::performQuery("SELECT * FROM district,county,subcounty WHERE subcounty.id=$subcounty_id
                                             AND district.id = county.district_id 
                                             AND county.id = subcounty.county_id LIMIT 1");
        return $sql->fetch_assoc()['district_status'];
    }

    public static function getUserManageList()
    {



        $sql = database::performQuery(self::switchUserManageList());

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];


            $addd_btn2  = '';
            if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4 || $_SESSION['user']['user_category_id'] == 12 || $_SESSION['user']['user_category_id'] == 5 || $_SESSION['user']['user_category_id'] == 54 || $_SESSION['user']['user_category_id'] == 10 || $_SESSION['user']['user_category_id'] == 84) {

                $addd_btn2 = '
              
        
                <div class = "col-md-4">                    
                <a href="' . ROOT . '/?action=editUserDetails&id=' . $data['id'] . '">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-dark"><i class="fas fa-pencil-alt"></i> Edit</button></a>
                </div>
                
                  <div class = "col-md-4">
                   <a href="' . ROOT . '/?action=deleteUser&id=' . $data['id'] . '">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"><i class="fas fa-times"></i> Delete</button></a> 
                </div>
                ';
            }



            $addd_btn3  = '';

            //            if ($data['user_category_id'] == 2 || $data['user_category_id'] == 3 || $data['user_category_id'] == 4 || $data['user_category_id'] == 1) {
            //
            //                $addd_btn3 = '   <a href="'.ROOT.'/?action=deleteUser&id='.$data['id'].'">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"><i class="fas fa-times"></i> Delete</button></a>
            //                                &nbsp;
            //                                <a href="'.ROOT.'/?action=editUserDetails&id='.$data['id'].'">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-dark"><i class="fas fa-pencil-alt"></i> Edit</button></a>
            //                ';
            //
            //            }

            $add_phone_button = (isset($_GET['type']) && $_GET['type'] == 'custom') ? '<button onclick="addNumberToAlert(this)" type="button" class="add-phone-alert btn waves-effect waves-light btn-rounded btn-sm btn-warning"><i class="fas fa-sms"></i> Send SMS</button>
            
            ' : '';




            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>';

            //Get Location
            if ($_REQUEST['district_id'] != 0 || !isset($_REQUEST['district_id'])) {
                $rt .= '<td>' . self::getUserDistrict(($data['district_id'])) . self::getUserLocation(($data['location'])) . '</td>';
            } else {
                $rt .= '<td>' . self::getTitleLocation($data['directorate_id'], $data['department_id'], $data['division_id'], $data['zone_id']) . '</td>';
            }

            $rt .= '<td data-phone="' . $data['phone'] . '">
                                                <div class = "row">
                                                <div class = "col-md-4">
                                                <a href="' . ROOT . '/?action=viewUserProfile&id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View</button></a>
                                                </div>';


            if ($data['id'] != $_SESSION['user']['id']) {
                $rt .= $addd_btn2 . '
                                                 ' . $addd_btn3;
            }


            $rt .= $add_phone_button . '
                                                 </div>
                                                
                                                </td>
                                            </tr>';
        }

        return $rt;
    }

    public static function getLocationDetailsDistrict()
    {

        $sql = self::conGRM()->query("SELECT district.name as district, COUNT(*) as tot
                                             FROM district,county,subcounty,parish,grivance
                                              WHERE district.id = county.district_id
                                              AND county.id = subcounty.county_id
                                              AND subcounty.id = parish.subcounty_id
                                              AND parish.id = grivance.parish_id
                                              GROUP BY district.id
                                              ");

        $conn = '<div class="row">';
        while ($data = $sql->fetch_assoc()) {

            $conn .= "<div class='col-md-3'><h5><b>$data[district] </b>  ($data[tot])</h5></div> ";
        }
        $conn .= '</div>';
        return $conn;
    }
    public static function getRedressCommittee()
    {

        $sql = self::conGRM()->query("SELECT grivance_status.name as comm, COUNT(*) as tot
                                             FROM grivance_status,grivance
                                              WHERE grivance_status.id = grivance.grivance_status_id
                                              GROUP BY grivance_status.id
                                              ");

        $conn = '<div class="row">';
        while ($data = $sql->fetch_assoc()) {

            $conn .= "<div class='col-md-12'><h5><b>$data[comm] </b>  ($data[tot])</h5></div> ";
        }
        $conn .= '</div>';
        return $conn;
    }
    public static function getSettlement()
    {

        $sql = self::conGRM()->query("SELECT grivance_settlement.name as comm, COUNT(*) as tot
                                             FROM grivance_settlement,grivance
                                              WHERE grivance_settlement.id = grivance.grievance_settlement_id
                                              GROUP BY grivance_settlement.id
                                              ");

        $conn = '<div class="row">';
        while ($data = $sql->fetch_assoc()) {

            $conn .= "<div class='col-md-12'><h5><b>$data[comm] </b>  ($data[tot])</h5></div> ";
        }
        $conn .= '</div>';
        return $conn;
    }
    public static function getNature()
    {

        $sql = self::conGRM()->query("SELECT grievance_nature.name as comm, COUNT(*) as tot
                                             FROM grievance_nature,grivance
                                              WHERE grievance_nature.id = grivance.grievance_nature_id
                                              GROUP BY grievance_nature.id
                                              ");

        $conn = '<div class="row">';
        while ($data = $sql->fetch_assoc()) {

            $conn .= "<div class='col-md-12'><h5><b>$data[comm] </b>  ($data[tot])</h5></div> ";
        }
        $conn .= '</div>';
        return $conn;
    }
    public static function getLocationDetailsDistrictIDs()
    {

        $sql = self::conGRM()->query("SELECT district.id as district, COUNT(*) as tot
                                             FROM district,county,subcounty,parish,grivance
                                              WHERE district.id = county.district_id
                                              AND county.id = subcounty.county_id
                                              AND subcounty.id = parish.subcounty_id
                                              AND parish.id = grivance.parish_id
                                              GROUP BY district.id
                                              ");

        $conn = '<div class="row">';
        while ($data = $sql->fetch_assoc()) {

            $conn .= self::getLocationDetailsSubcountyDis($data['district']);
        }
        $conn .= '</div>';
        return $conn;
    }
    public static function getLocationDetailsSubcountyDis($id)
    {

        $sql = self::conGRM()->query("SELECT subcounty.name as subcounty, COUNT(*) as tot
                                             FROM district,county,subcounty,parish,grivance
                                              WHERE district.id = county.district_id
                                              AND county.id = subcounty.county_id
                                              AND subcounty.id = parish.subcounty_id
                                              AND parish.id = grivance.parish_id
                                              AND district.id = $id
                                              GROUP BY subcounty.id
                                              ");


        $disjj = district::getDistrictName($id);
        $conn = "<div class='col-md-3'><h5><b>$disjj </b></h5><ul> ";
        while ($data = $sql->fetch_assoc()) {

            $conn .= "<li>$data[subcounty]  ($data[tot])</li> ";
        }
        $conn .= '</ul></div>';
        return $conn;
    }
    public static function getUserMeetings()
    {



        $sql = self::conGRM()->query(self::switchUserMeetings());
        $rt =  '';
        if ($sql->num_rows > 0) {

            while ($data = $sql->fetch_assoc()) {

                $location = self::getLocationDetailsSubcounty($data['location_id']);

                $fff = '';
                switch ($data['status_id']) {

                    case 3:
                        $fff = '<button type="button" class="btn waves-effect waves-light btn-xs btn-primary">Subcounty GRC</button>';
                        break;
                    case 4:
                        $fff = '<button type="button" class="btn waves-effect waves-light btn-xs btn-danger">District GRC</button>';
                        break;
                    case 5:
                        $fff = '<button type="button" class="btn waves-effect waves-light btn-xs btn-success">National GRC</button>';
                        break;
                }



                $rt .= '<tr>
                                                <td><a href="">METN-' . $data['id'] . '</a></td>
                                                <td><a href="">' . $data['theme'] . '</a> </td>
                                                <td>' . $fff . '</td>
                                                <td>' . $location['district'] . ' /<small>' . $location['subcounty'] . '</small> </td>
                                                <td>' . $data['attendees'] . '</td>
                                                <td>' . $data['created'] . '</td>
                                                <td></td>
                                            </tr>';
            }
        } else {
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

    public static function getUserWorkplanList()
    {



        $sql = database::performQuery(self::switchUserManageList());

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];




            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                ';


            //Get Location
            if ((isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != 0) || !isset($_REQUEST['district_id'])) {
                $rt .= '<td>' . self::getUserDistrict(($data['district_id'])) . self::getUserLocation(($data['location'])) . '</td>';
            }


            $rt .= '<td>
                                              
                                                <a href="' . ROOT . '/?action=viewUserWorkplan&id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="fa fa-eye"></i> View Workplan</button></a>
                                               ';


            if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4 || $_SESSION['user']['user_category_id'] == 12  || $_SESSION['user']['user_category_id'] == 84 || $_SESSION['user']['user_category_id'] == 10 || $_SESSION['user']['user_category_id'] == 55 || $_SESSION['user']['user_category_id'] == 56 || $_SESSION['user']['user_category_id'] == 57  || $_SESSION['user']['user_category_id'] == 58 || $_SESSION['user']['user_category_id'] == 59)
                $rt .= '      <a href="' . ROOT . '/?action=addNewWorkplan&id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fa fa-plus"></i> Add New Output</button></a>';

            //DPMO Workplans
            //            if($_SESSION['user']['user_category_id'] == 10 &&  $data['user_category_id']==10)
            //                $rt .='      <a href="'.ROOT.'/?action=addNewWorkplan&id='.$data['id'].'"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fa fa-plus"></i> Add New Output</button></a>';



            $rt .= '   </td>
                                            </tr>';
        }

        return $rt;
    }



    public static function getUserWorkplanListSMS()
    {



        $sql = database::performQuery(self::switchUserManageListSMS());

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];




            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                   ';


            //Get Location
            if ((isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != 0) || !isset($_REQUEST['district_id'])) {
                $rt .= '<td>' . self::getUserDistrict(($data['district_id'])) . self::getUserLocation(($data['location'])) . '</td>';
            }


            $rt .= '
                                                <td>
                                              
                                                <a href="' . ROOT . '/?action=viewUserWorkplan&id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="fa fa-eye"></i> View Workplan</button></a>
                                               ';


            if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4  || $_SESSION['user']['user_category_id'] == 12  || $_SESSION['user']['user_category_id'] == 84  || $_SESSION['user']['user_category_id'] == 10 || $_SESSION['user']['user_category_id'] == 55 || $_SESSION['user']['user_category_id'] == 56 || $_SESSION['user']['user_category_id'] == 57  || $_SESSION['user']['user_category_id'] == 58 || $_SESSION['user']['user_category_id'] == 59)
                $rt .= '      <a href="' . ROOT . '/?action=addNewWorkplan&id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fa fa-plus"></i> Add New Output</button></a>';

            //DPMO Workplans
            //            if($_SESSION['user']['user_category_id'] == 10 ||  $data['user_category_id']==10 )
            //                $rt .='      <a href="'.ROOT.'/?action=addNewWorkplan&id='.$data['id'].'"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fa fa-plus"></i> Add New Output</button></a>';
            //


            $rt .= '   </td>
                                            </tr>';
        }

        //      $rt .='<pre>'.userMgmt::prepSwitchForAllNationalLevelManagers().'</pre>';

        return $rt;
    }
    public static function getUserEvaluationList()
    {
        $id = $_SESSION['user']['location_id'];


        $user_cat = 1;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 57:
                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyCropExtensionStaffUserIDs() . ')';
                break;

            case 3:
            case 56:

                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyVetExtensionStaffUserIDs() . ')';
                break;

            case 4:
            case 58:
                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyFishExtensionStaffUserIDs() . ')';
                break;

            case 12:
            case 59:

                $user_cat = 'user_category_id IN (' . userMgmt::getSubcountyEntomologyExtensionStaffUserIDs() . ')';
                break;

            default:
                break;
        }

        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

                //            case 2:
                //            case 3:
                //            case 4:
                //                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,user.district_id,location_id as location
                //                   FROM district,subcounty,county,user
                //                   WHERE district.id =county.district_id
                //                   AND county.id = subcounty.county_id
                //                   AND subcounty.id = user.location_id
                //                   AND district.id = ".$_SESSION['user']['district_id']."
                //                   AND user_category_id = $user_cat
                //                   ";
                //                break;
                //
                //
                //
                //
                //            case 1:
                //                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,user.district_id,location_id as location
                //                   FROM district,subcounty,county,user
                //                   WHERE district.id =county.district_id
                //                   AND county.id = subcounty.county_id
                //                   AND subcounty.id = user.location_id
                //                   AND subcounty.id = $id
                //                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                //                   ";
                //                break;
                //
                //            case 5:
                //            case 6:
                //            case 15:
                //            case 16:
                //            case 17:
                //            case 18:
                //            case 31:
                //            case 32:
                //            case 33:
                //            case 34:
                //            case 35:
                //            case 36:
                //            case 37:
                //            case 38:
                //            case 39:
                //            case 40:
                //            case 41:
                //            case 42:
                //            case 43:
                //            case 44:
                //            case 45:
                //            case 46:
                //            case 47:
                //            case 48:
                //
                //                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,user.district_id,location_id as location
                //                   FROM district,user,county,subcounty
                //                   WHERE district.id =county.district_id
                //                   AND county.id = subcounty.county_id
                //                    AND subcounty.id = user.location_id
                //                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 2 OR user_category_id = 3 OR user_category_id = 4 OR user_category_id = 10 OR user_category_id = 9 )
                //                   AND county.district_id = ".$_REQUEST['district_id']."
                //                   ";
                //                break;
                //
                //            case 10:
                //            case 11:
                //                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,user.district_id,location_id as location
                //                   FROM district,user,county,subcounty
                //                   WHERE district.id = ".$_SESSION['user']['district_id']."
                //                   AND district.id =county.district_id
                //                   AND county.id = subcounty.county_id
                //                    AND subcounty.id = user.location_id
                //                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                //
                //                   ";
                //                break;
                //
                //            case 6:
                //                $content = '';
                //                break;


            case 1:
                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE location_id = $id
                   AND user_category_id IN (" . userMgmt::getSubcountyExtensionStaffUserIDs() . ")
                   ";
                break;


            case 10:
            case 84:
            case 11:
            case 55:

                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id  as location,user_category_id
                   FROM user
                   WHERE district_id = " . $_SESSION['user']['district_id'] . " AND user_category_id !=84
                
                     ";

                //AND user_category_id NOT IN (".userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs().")

                break;

            case 5:
            case 54:
                //Switch to Manage National level, district heads and zonal heads

                if ($_REQUEST['district_id'] == 0) {
                    //Case WHere District ID is 0
                    $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,user_category_id,directorate_id,department_id,division_id,zone_id
                   FROM user,user_category,user_group
                   WHERE  user.user_category_id = user_category.id
                   AND user_category.user_group_id = user_group.id
                    AND user_group_id IN (1,2,3)";
                } else {
                    $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE district_id = " . $_REQUEST['district_id'] . "  AND user_category_id !=84
                     
                   ";

                    //AND user_category_id NOT IN (".userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs().")

                }



                break;

            case 16:

                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE                  
                  user_category_id = 9 OR user_category_id = 20 OR user_category_id = 3 OR user_category_id = 10 OR user_category_id = 23 
                   ";


                break;


            case 17:

                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE  user_category_id = 8 OR user_category_id = 19 OR user_category_id = 22 OR user_category_id = 2 OR user_category_id = 10
                   ";


                break;

            case 18:

                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user WHERE user_category_id = 7 OR user_category_id = 21  OR user_category_id = 4  OR user_category_id = 10 
                   ";


                break;
                //Subject matter Specialists
            case 2:
            case 3:
            case 4:
            case 12:
            case 56:
            case 57:
            case 58:
            case 59:
                $content = "SELECT phone,user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,user_category_id
                   FROM user
                   WHERE district_id =  " . $_SESSION['user']['district_id'] . "
                   AND  $user_cat
                   ";

                break;

            default:
                $content = '';
                break;
        }


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];
            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                   ';


            //Get Location
            if ((isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != 0) || !isset($_REQUEST['district_id'])) {
                $rt .= '<td>' . self::getUserDistrict(($data['district_id'])) . self::getUserLocation(($data['location'])) . '</td>';
            }


            $rt .= '
                                                <td>
                                                <div>
                                           <span>   <a href="' . ROOT . '/?action=viewEOReport&id=' . $data['id'] . '">
                                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"> <i class="fa fa-chart-area"></i>Officer Report</button>
                                                </a>
                                                </span> 
                                                <span>
                                                   <a href="' . ROOT . '/?action=viewaEvaluationReport&user_id=' . $data['id'] . '">
                                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="fa fa-chart-area"></i>Officer Evaluation</button>
                                                </a>
                                                </span>
                                                <span>
                                                 <a href="' . ROOT . '/?action=viewaDailyActivities&user_id=' . $data['id'] . '">
                                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fa fa-chart-line"></i> Daily Activities</button>
                                                </a>
                                             </span>  
                                                </div>
                                                 </td>
                                            </tr>';
        }

        return $rt;
    }


    public static function getUserEvaluationListSMS()
    {
        $id = $_SESSION['user']['location_id'];


        $user_cat = 1;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
                $user_cat = 8;
                break;

            case 3:
                $user_cat = 9;
                break;

            case 4:
                $user_cat = 7;
                break;

            case 12:
                $user_cat = 13;
                break;

            default:
                break;
        }

        $content = '';
        switch ($_SESSION['user']['user_category_id']) {
            case 5:
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 31:
            case 32:
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            case 41:
            case 42:
            case 43:
            case 44:
            case 45:
            case 46:
            case 47:
            case 48:

                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,location_id
                   FROM user
                   WHERE user_category_id IN (" . userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs() . ")
                 AND district_id = " . $_REQUEST['district_id'] . "
                   ";
                break;

            case 10:
            case 11:
            case 84:
            case 55:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district_id,location_id as location,location_id
                   FROM user
                   WHERE district_id = " . $_SESSION['user']['district_id'] . "
                   AND user_category_id IN (" . userMgmt::getDistrictHeadsAndDistrictSectorHeadsUserIDs() . ")
              
                   ";
                break;

            case 6:
                $content = '';
                break;

            default:
                $content = '';
                break;
        }


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];
            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                   ';


            //Get Location
            if ((isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != 0) || !isset($_REQUEST['district_id'])) {
                $rt .= '<td>' . self::getUserDistrict(($data['district_id'])) . self::getUserLocation(($data['location'])) . '</td>';
            }


            $rt .= '
                                                <td>
                                               <a href="' . ROOT . '/?action=viewEOReport&id=' . $data['id'] . '">
                                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"> <i class="fa fa-chart-area"></i> Report</button>
                                                </a>
                                                
                                                   <a href="' . ROOT . '/?action=viewaEvaluationReport&user_id=' . $data['id'] . '">
                                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="fa fa-chart-area"></i> Evaluation</button>
                                                </a>
                                                
                                                 <a href="' . ROOT . '/?action=viewaDailyActivities&user_id=' . $data['id'] . '">
                                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fa fa-chart-line"></i> Daily Activities</button>
                                                </a>
                                                
                                                
                                                 </td>
                                            </tr>';
        }

        return $rt;
    }

    public static function getUserAnnualActivitiesList()
    {
        $id = $_SESSION['user']['location_id'];


        $user_cat = 1;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
                $user_cat = 8;
                break;

            case 3:
                $user_cat = 9;
                break;

            case 4:
                $user_cat = 7;
                break;

            default:
                break;
        }

        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND district.id = " . $_SESSION['user']['district_id'] . "
                   AND user_category_id = $user_cat
                   ";
                break;



            case 1:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND subcounty.id = $id
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                   ";
                break;


            case 6:

                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";
                break;

            case 10:
            case 11:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id = " . $_SESSION['user']['district_id'] . "
                   AND district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";
                break;

            case 6:
                $content = '';
                break;

            default:
                $content = '';
                break;
        }


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];


            $addd_btn2  = '';
            if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

                $addd_btn2 = '     <a href="' . ROOT . '/?action=manageAnnualActivities&id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Activities</button></a>
                                                   ';
            }




            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                <td>' . $data['location'] . '</td>
                                                <td>
                                               
                                               ' . $addd_btn2 . '
                                                  <a href="' . ROOT . '/?action=viewAnnualActivities&id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View Activities</button></a>
                                                </td>
                                            </tr>';
        }

        return $rt;
    }
    public static function getUserQuartelyActivitiesList()
    {



        $sql = database::performQuery(self::switchUserManageList());

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];



            $addd_btn2  = '';
            if ($_SESSION['user']['user_category_id'] == 55 || $_SESSION['user']['user_category_id'] == 56 || $_SESSION['user']['user_category_id'] == 57  || $_SESSION['user']['user_category_id'] == 58 || $_SESSION['user']['user_category_id'] == 59 ||  $_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4 || $_SESSION['user']['user_category_id'] == 12  || $_SESSION['user']['user_category_id'] == 84 || $_SESSION['user']['user_category_id'] == 10) {

                $addd_btn2 = '      <a href="' . ROOT . '/?action=processEditQuarterlyActivities&user_id=' . $data['id'] . '">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> 
                <i class="fas fa-plus"></i> Add New Activity</button></a>
                                             ';
            }


            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                   ';


            //Get Location
            if ((isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != 0) || !isset($_REQUEST['district_id'])) {
                $rt .= '<td>' . self::getUserDistrict(($data['district_id'])) . self::getUserLocation(($data['location'])) . '</td>';
            }


            $rt .= '
                                                <td>
                                                
                                                 <a href="' . ROOT . '/?action=viewQuarterlyActivities&id=' . $data['id'] . '" ><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View Activities</button></a>
                                              ' . $addd_btn2 . '
                                                </td>
                                            </tr>';
        }

        return $rt;
    }

    public static function getUserQuartelyActivitiesList2()
    {



        $sql = database::performQuery(self::switchUserManageListSMS());

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];



            $addd_btn2  = '';
            if ($_SESSION['user']['user_category_id'] == 55 || $_SESSION['user']['user_category_id'] == 56 || $_SESSION['user']['user_category_id'] == 57  || $_SESSION['user']['user_category_id'] == 58 || $_SESSION['user']['user_category_id'] == 59 || $_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4 || $_SESSION['user']['user_category_id'] == 12  || $_SESSION['user']['user_category_id'] == 84 || $_SESSION['user']['user_category_id'] == 10) {

                $addd_btn2 = '      <a href="' . ROOT . '/?action=processEditQuarterlyActivities&user_id=' . $data['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Activity</button></a>
                                             ';
            }


            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                   ';


            //Get Location
            if ((isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != 0) || !isset($_REQUEST['district_id'])) {
                $rt .= '<td>' . self::getUserDistrict(($data['district_id'])) . self::getUserLocation(($data['location'])) . '</td>';
            }


            $rt .= '
                                                <td>
                                                ' . $addd_btn2 . '
                                                 <a href="' . ROOT . '/?action=viewQuarterlyActivities&id=' . $data['id'] . '" ><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View Quarterly Activities</button></a>
                                                </td>
                                            </tr>';
        }

        return $rt;
    }

    public static function getUserManageAnnualActivity()
    {
        $id = $_SESSION['user']['location_id'];


        $user_cat = 1;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
                $user_cat = 8;
                break;

            case 3:
                $user_cat = 9;
                break;

            case 4:
                $user_cat = 7;
                break;

            default:
                break;
        }

        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND district.id = " . $_SESSION['user']['district_id'] . "
                   AND user_category_id = $user_cat
                   ";
                break;

            case 1:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND subcounty.id = $id
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                   ";
                break;


            case 6:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";
                break;

            case 10:
            case 11:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id = " . $_SESSION['user']['district_id'] . "
                   AND district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";
                break;


            case 6:
                $content = '';
                break;

            default:
                $content = '';
                break;
        }


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];


            $addd_btn2  = '';
            if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

                $addd_btn2 = '     <a href="' . ROOT . '/?action=addAnnualObjectives&id=' . $data['id'] . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Outputs</button></a>
                                              
                                             ';
            }

            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                <td>' . $data['location'] . '</td>
                                                <td>
                                               ' . $addd_btn2 . '
                                                <a href="' . ROOT . '/?action=viewUserObjectives&id=' . $data['id'] . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View Outputs</button></a>
                                                </td>
                                            </tr>';
        }

        return $rt;
    }

    public static function getUserManageAnnualActivity2()
    {
        $id = $_SESSION['user']['location_id'];


        $content = '';
        switch ($_SESSION['user']['user_category_id']) {



            case 6:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";
                break;

            case 10:
            case 11:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id = " . $_SESSION['user']['district_id'] . "
                   AND district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 2 OR user_category_id = 3 OR user_category_id = 4 OR user_category_id = 12 OR user_category_id = 10 )
              
                   ";
                break;




            default:
                $content = '';
                break;
        }


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];


            $addd_btn2  = '';
            if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

                $addd_btn2 = '     <a href="' . ROOT . '/?action=addAnnualObjectives&id=' . $data['id'] . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Outputs</button></a>
                                              
                                             ';
            }

            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                <td>' . $data['location'] . '</td>
                                                <td>
                                               ' . $addd_btn2 . '
                                                <a href="' . ROOT . '/?action=viewUserObjectives&id=' . $data['id'] . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View Outputs</button></a>
                                                </td>
                                            </tr>';
        }

        return $rt;
    }



    public static function getUserManageListQuarterlyOutputs()
    {
        $id = $_SESSION['user']['location_id'];


        $user_cat = 1;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
                $user_cat = 8;
                break;

            case 3:
                $user_cat = 9;
                break;

            case 4:
                $user_cat = 7;
                break;

            default:
                break;
        }

        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND district.id = " . $_SESSION['user']['district_id'] . "
                   AND user_category_id = $user_cat
                   ";
                break;

            case 1:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND subcounty.id = $id
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                   ";
                break;



            case 6:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";
                break;

            case 10:
            case 11:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty
                   WHERE district.id = " . $_SESSION['user']['district_id'] . "
                   AND district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";
                break;


            case 6:
                $content = '';
                break;

            default:
                $content = '';
                break;
        }


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];



            if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

                $addd_btn2 = '      <a href="' . ROOT . '/?action=addNewOuputs&id=' . $data['id'] . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Outputs</button></a>
                                              ';
            } else {

                $addd_btn2  = '';
            }



            $rt .= '<tr>
                                                <td><img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /></td>
                                                <td>' . $data['first_name'] . ' ' . $data['last_name'] . '</td>
                                                <td>' . user::getUserCategory($data['user_category_id']) . '</td>
                                                <td>' . $data['location'] . '</td>
                                               
                                                <td>
                                                ' . $addd_btn2 . '
                                                 <a href="' . ROOT . '/?action=viewUserOuputs&id=' . $data['id'] . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View Outputs</button> </a>
                                                
                                                
                                                
                                                </td>
                                            </tr>';
        }

        return $rt;
    }


    public static function manageUsers()
    {

        $type = $_GET['type'] ?? null;
        $e_selected =  ($type == 'user') ? 'selected' : '';
        $d_selected =  ($type == 'custom') ? 'selected' : '';
        $data_form = ($type == 'custom') ? '<div class="col-md-3">
    <div class="form-group">
        <label class="control-label">Phone Numbers (separate with comma)</label><input id="custom-numbers" required name="custom_numbers" class="form-control"></input>
    </div>
</div>' : '';

        //Display add button
        switch ($_SESSION['user']['user_category_id']) {
            case 2:
            case 3:
            case 4:
            case 10:
            case 12:
            case 84:
            case 55:
            case 56:
            case 57:
            case 58:
            case 59:
                $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addUsers&district_id=' . $_SESSION['user']['district_id'] . '">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Officers</button>
                    </a>
                    <br />
                    <br />
                    </div>';

                break;
            case 5:
            case 54:
            case 15:
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 31:
            case 32:
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            case 41:
            case 42:
            case 43:
            case 44:
            case 45:
            case 46:
            case 47:
            case 48:
                $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addUsers&district_id=' . $_REQUEST['district_id'] . '">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Officers</button>
                    </a>
                    <br />
                    <br />
                    </div>';
                break;

            default:
                $addd_btn  = '';
                break;
        }

        $form_alert = '<div class="card">
    <div class="card-header bg-info">
        <h4 class="m-b-0 text-white">Send Advisory</h4>
    </div> 
    <div class="card-body"> ';
        if (isset($_SESSION['success_message'])) {
            $success_message = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
            $form_alert .= '<div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>' . $success_message . '</strong> .
                        </div>
                        </div>';
        }
        $form_alert .= '<div class="col-lg-12">
   <form method="post" action="' . ROOT . '/?action=sendUserAlert">
      <div class="row p-t-20"> 
      <div class="col-md-3">
        <div class="form-group">
                    <label class="control-label">Advisory For</label><select id="select-alert-type" class="form-control" name="type">                               
                      <option ' . $e_selected . ' value="user">All Users</option>                
                      <option ' . $d_selected . ' value="custom">Some Users</option>
                  </select>
        </div>
      </div>' . $data_form . '
        
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
        const new_url = "' . ROOT . '/?action=manageUsers&type="+vs
        window.location.href = new_url
    });
       
            const addNumberToAlert = (event)=>{
                let phoneElement = event.closest("td");
                const phone = phoneElement.dataset.phone;
                let customN = document.getElementById("custom-numbers")
                const oldNumbers = customN.value;
                if(!oldNumbers.includes(phone)){
                    const newNumbers = oldNumbers+","+phone
                    customN.value = newNumbers;
                }
                //alert(phone)
            }
        
            
    </script>
    </div>
    </div>';

        $content = $addd_btn . '' . $form_alert . '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Work Station</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserManageList() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Work Station</th>
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





    public static function manageMeetings()
    {
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addMeeting">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Meetings</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">' . $addd_btn . '
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                
                                                <th>Theme</th>
                                                <th>Level</th>
                                                <th>Location</th>
                                                <th>Attendees</th>
                                                <th>Created</th>                                                
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserMeetings() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Theme</th>
                                                <th>Level</th>
                                                <th>Location</th>
                                                <th>Attendees</th>
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




    public static function manageGrievances()
    {

        $content = '<div class="row">
                    
                  
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                
                                                <th>Reference</th>                                                
                                                <th>District/<br /> Sub-county</th>                                                
                                                <th>Nature</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>GRC Level</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                          
                                          ' . self::getUserGrievances() . '
                                          
                                                                                
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                 <th>ID</th>                                                
                                                 <th>Reference</th>                                                
                                                 <th>District/Sub-county</th>                                                
                                                 <th>Nature</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                 <th>GRC Level</th>
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


    public static function conGRM()
    {
        $dbconfig = database::getGRMConfigs();

        $con = new mysqli($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
        //$con = new mysqli('localhost','hosteern_user','Makaveli@123??','hosteern_grm');
        return $con;
    }

    public static function getGrievanceNature($id)
    {
        $sql = self::conGRM()->query("SELECT name FROM grievance_nature WHERE id=$id");
        return $sql->fetch_assoc()['name'];
    }

    public static function getGrievanceType($id)
    {
        $sql = self::conGRM()->query("SELECT name FROM grivance_type WHERE id=$id");
        $x = $sql->fetch_assoc();
        $name = 'User';
        if (isset($x['name'])) {
            $name = $x['name'];
        }
        return $name;
    }

    public static function getGrievanceMOR($id)
    {
        $sql = self::conGRM()->query("SELECT name FROM mode_of_receipt WHERE id=$id");
        $x =  $sql->fetch_assoc();
        $name = 'User';
        if (isset($x['name'])) {
            $name = $x['name'];
        }
        return $name;
    }

    public static function getGrievanceFB($id)
    {
        $sql = self::conGRM()->query("SELECT name FROM feedback_mode WHERE id=$id");
        $x =  $sql->fetch_assoc();
        $name = 'User';
        if (isset($x['name'])) {
            $name = $x['name'];
        }
        return $name;
    }

    public static function getGrievanceStatus($id)
    {
        $sql = self::conGRM()->query("SELECT * FROM `grivance_status` WHERE id=$id");
        $x =  $sql->fetch_assoc();
        $name = 'User';
        if (isset($x['name'])) {
            $name = $x['name'];
        }
        return $name;
    }

    public static function getGrievanceSettlementOtherwise($id)
    {
        $sql = self::conGRM()->query("SELECT * FROM `grievance_settle_otherwise` WHERE id=$id");
        $x =  $sql->fetch_assoc();
        $name = 'User';
        if (isset($x['name'])) {
            $name = $x['name'];
        }
        return $name;
    }

    public static function getGrievanceSettlementHow($id)
    {
        $sql = self::conGRM()->query("SELECT * FROM `grivance_settlement` WHERE id=$id");
        $x =  $sql->fetch_assoc();
        $name = 'User';
        if (isset($x['name'])) {
            $name = $x['name'];
        }
        return $name;
    }

    public static function getUserGrievances()
    {


        // echo "Session User ID is :".$_SESSION['user']['user_category_id'];

        switch ($_SESSION['user']['user_category_id']) {

                //Admins
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 10:
            case 11:
            case 12:
            case 24:

                $sql = self::conGRM()->query("SELECT * FROM grivance WHERE parish_id IN (SELECT parish.id FROM parish,subcounty,county,district WHERE district.id=" . $_SESSION['user']['district_id'] . " AND  district.id = county.district_id AND county.id = subcounty.county_id  AND subcounty.id = parish.subcounty_id) ORDER BY grivance.id DESC");

                break;

                //Admins National

            case 6:
            case 15:
            case 16:
            case 17:
            case 18:

                $sql = self::conGRM()->query("SELECT * FROM grivance ORDER BY grivance.id DESC");

                break;


                //EOs
            case 7:
            case 8:
            case 9:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
                $sql = self::conGRM()->query("SELECT * FROM grivance WHERE parish_id IN (SELECT parish.id FROM parish WHERE subcounty_id=" . $_SESSION['user']['location_id'] . ") ORDER BY grivance.id DESC");

                break;


            default:



                break;
        }


        $rt =  '';
        while ($data = $sql->fetch_assoc()) {

            $fff = '';
            switch ($data['grivance_status_id']) {

                case 3:
                    $fff = '<button type="button" class="btn waves-effect waves-light btn-xs btn-primary">Subcounty GRC</button>';
                    break;
                case 4:
                    $fff = '<button type="button" class="btn waves-effect waves-light btn-xs btn-danger">District GRC</button>';
                    break;
                case 5:
                    $fff = '<button type="button" class="btn waves-effect waves-light btn-xs btn-success">National GRC</button>';
                    break;
            }



            //Switch buttons for managing grievances

            switch ($_SESSION['user']['user_category_id']) {

                    //Admins
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 10:
                case 11:
                case 12:
                case 24:


                    $dd = '';
                    switch ($data['grivance_status_id']) {

                        case 4:
                            $dd = ' 
                        <a data-toggle="modal" data-target="#view' . $data['id'] . '" ><span class="label label-info m-r-10">View</span></a>
                        <a data-toggle="modal" data-target="#escalate' . $data['id'] . '" ><span class="label label-success m-r-10">Escalate</span></a>
                        <a data-toggle="modal" data-target="#files' . $data['id'] . '" ><span class="label label-warning m-r-10">Files</span></a>
                        <a data-toggle="modal" data-target="#response' . $data['id'] . '" ><span class="label label-primary m-r-10">Response</span></a>
                        <a data-toggle="modal" data-target="#settle' . $data['id'] . '" ><span class="label label-danger m-r-10">Settle</span></a>
                       ';
                            break;
                        case 3:
                        case 5:
                            $dd = ' <a data-toggle="modal" data-target="#view' . $data['id'] . '" ><span class="label label-info m-r-10">View</span></a>
                        <a data-toggle="modal" data-target="#files' . $data['id'] . '" ><span class="label label-warning m-r-10">Files</span></a>
                        <a data-toggle="modal" data-target="#response' . $data['id'] . '" ><span class="label label-primary m-r-10">Response</span></a>';
                            break;
                    }
                    break;
                    //Admins National

                case 6:
                case 15:
                case 16:
                case 17:
                case 18:


                    $dd = '';
                    switch ($data['grivance_status_id']) {

                        case 5:
                            $dd = ' 
                        <a data-toggle="modal" data-target="#view' . $data['id'] . '" ><span class="label label-info m-r-10">View</span></a>
                        <a data-toggle="modal" data-target="#escalate' . $data['id'] . '" ><span class="label label-success m-r-10">Escalate</span></a>
                        <a data-toggle="modal" data-target="#files' . $data['id'] . '" ><span class="label label-warning m-r-10">Files</span></a>
                        <a data-toggle="modal" data-target="#response' . $data['id'] . '" ><span class="label label-primary m-r-10">Response</span></a>
                        <a data-toggle="modal" data-target="#settle' . $data['id'] . '" ><span class="label label-danger m-r-10">Settle</span></a>
                       ';
                            break;
                        case 4:
                        case 3:
                            $dd = ' <a data-toggle="modal" data-target="#view' . $data['id'] . '" ><span class="label label-info m-r-10">View</span></a>
                        <a data-toggle="modal" data-target="#files' . $data['id'] . '" ><span class="label label-warning m-r-10">Files</span></a>
                        <a data-toggle="modal" data-target="#response' . $data['id'] . '" ><span class="label label-primary m-r-10">Response</span></a>';
                            break;
                    }
                    break;
                    //EOs
                case 7:
                case 8:
                case 9:
                case 19:
                case 20:
                case 21:
                case 22:
                case 23:

                    $dd = '';
                    switch ($data['grivance_status_id']) {

                        case 3:
                            $dd = ' 
                        <a data-toggle="modal" data-target="#view' . $data['id'] . '" ><span class="label label-info m-r-10">View</span></a>
                        <a data-toggle="modal" data-target="#escalate' . $data['id'] . '" ><span class="label label-success m-r-10">Escalate</span></a>
                        <a data-toggle="modal" data-target="#files' . $data['id'] . '" ><span class="label label-warning m-r-10">Files</span></a>
                        <a data-toggle="modal" data-target="#response' . $data['id'] . '" ><span class="label label-primary m-r-10">Response</span></a>
                        <a data-toggle="modal" data-target="#settle' . $data['id'] . '" ><span class="label label-danger m-r-10">Settle</span></a>
                       ';
                            break;
                        case 4:
                        case 5:
                            $dd = ' <a data-toggle="modal" data-target="#view' . $data['id'] . '" ><span class="label label-info m-r-10">View</span></a>
                        <a data-toggle="modal" data-target="#files' . $data['id'] . '" ><span class="label label-warning m-r-10">Files</span></a>
                        <a data-toggle="modal" data-target="#response' . $data['id'] . '" ><span class="label label-primary m-r-10">Response</span></a>';
                            break;
                    }
                    break;


                default:

                    break;
            }

            $rr  = "No";
            if ($data['grievance_settlement_id'] > 1)
                $rr = "Yes";


            //Get Location of compalainant
            $location = ['district' => '', 'subcounty' => '', 'parish' => ''];
            if ($data['parish_id'] > 0)
                $location = self::getLocationDetails($data['parish_id']);



            $anon = 'No';
            if ($data['complainant_anonymous'])
                $anon = "Yes";

            $rt .= '<tr>
                                             <td>' . $data['id'] . '</td>
                                             <td>' . $data['ref_number'] . '</td>
                                             <td>' . $location['district'] . '/<br /><small>' . $location['subcounty'] . '</small></td>
                                                <td>' . self::getGrievanceNature($data['grievance_nature_id']) . ' </td>
                                                <td>' . self::getGrievanceType($data['grivance_type_id']) . '</td>
                                                <td>' . $data['date_of_grivance'] . '</td>
                                                <td>' . $fff . '</td>
                                                
                           <td>
    
       
       ' . $dd . '
       
    <!-- View grievance -->   
       <div id="view' . $data['id'] . '" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">View Grivance Ref: ' . $data['ref_number'] . '</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                 <table class="table table-hover" width="100%">
                                                <tr>
                                                <td width="50%"><h4>Grivance Details</h4>
                                                <table>
                                                  <tr>
                                                   <td>Grivance Referance</td>
                                                   <td>' . $data['ref_number'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Grivance Date</td>
                                                   <td>' . $data['date_of_grivance'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Grivance Nature</td>
                                                   <td>' . self::getGrievanceNature($data['grievance_nature_id']) . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Grivance Type</td>
                                                   <td>' . self::getGrievanceType($data['grivance_type_id']) . ' <br /> ' . $data['grievance_type_if_not_specified'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Mode of Receipt</td>
                                                   <td>' . self::getGrievanceMOR($data['mode_of_receipt_id']) . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Description</td>
                                                   <td>' . $data['description'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Past Actions</td>
                                                   <td>' . $data['past_actions'] . '</td>
                                                  </tr>
                                                </table>
                                                
                                                </td>
                                                <td width="50%"><h4>Grivance Settlement</h4>
                                                <table>
                                                  <tr>
                                                   <td>Days at Subcounty GRC</td>
                                                   <td>' . $data['days_at_sgrc'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Days at District GRC</td>
                                                   <td>' . $data['days_at_dgrc'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Days at National GRC</td>
                                                   <td>' . $data['days_at_ngrc'] . '</td>
                                                  </tr>
                                                  
                                                  <tr>
                                                   <td>Current GRC Level</td>
                                                   <td>' . self::getGrievanceStatus($data['grivance_status_id']) . '</td>
                                                  </tr>
                                                  
                                                  <tr>
                                                   <td>Was Grievance Settled?</td>
                                                   <td>' . $rr . '</td>
                                                  </tr>
                                                  
                                                 
                                                  <tr>
                                                   <td>How was Grievance Settled?</td>
                                                   <td>' . self::getGrievanceSettlementHow($data['grievance_settlement_id']) . '</td>
                                                  </tr>
                                                  </table>
                                                
                                                </td>
                                                                                         
                                                </tr>
                                                  <tr>
                                                <td width="50%"><h4>Grivance Complainant </h4>
                                                 <table>
                                                  <tr>
                                                   <td>Complainant District</td>
                                                   <td>' . $location['district'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Complainant Subcounty</td>
                                                   <td>' . $location['subcounty'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Complainant Parish</td>
                                                   <td>' . $location['parish'] . '</td>
                                                  </tr>
                                                  
                                                  <tr>
                                                   <td>Complainant Name</td>
                                                   <td>' . $data['complainant_name'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Complainant Age</td>
                                                   <td>' . $data['complainant_age'] . '</td>
                                                  </tr>
                                                  
                                                  <tr>
                                                   <td>Complainant Phone</td>
                                                   <td>' . $data['complainant_phone'] . '</td>
                                                  </tr>
                                                  
                                                  <tr>
                                                   <td>Complainant Gender</td>
                                                   <td>' . $data['complainant_gender'] . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Anonymous Complainant?</td>
                                                   <td>' . $anon . '</td>
                                                  </tr>
                                                  <tr>
                                                   <td>Prefered Feedback Mode?</td>
                                                   <td>' . self::getGrievanceFB($data['complainant_feedback_mode']) . '</td>
                                                  </tr>
                                                  
                                                   <tr>
                                                   <td>Complainant Location</td>
                                                   <td>' . $data['complainant_gender'] . '</td>
                                                  </tr>
                                                  </table>
                                                
                                                
                                                </td>
                                                <td width="50%"><h4>Grivance Files & Responses</h4>
                                                <h5>Responses</h5>
                                                ' . self::viewGRMResponses($data['id']) . '
                                                
                                                <h5>Files</h5>
                                                ' . self::viewGRMFiles($data['id']) . '
                                                </td>                                             
                                                </tr>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>    
    <!-- Escalate grievance -->   
       <div id="escalate' . $data['id'] . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"> Esacalate Grivance Ref: ' . $data['ref_number'] . '</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Escalate Grievance to higher GRC</h4>
                                                <p> Please note that when you escalate the grievance, you will not be able to settle it anymore and the higher authority will take it on from there and settle issues.
                                                You will however be able to still submit files and responses partining this particular grievance in your location.
                                                </p>
                                                
                                                <p>Press the button below if you have failed to settle the grievance with Reference : ' . $data['ref_number'] . ' and wish to escalate it.</p>
                                               <a href="' . ROOT . '/?action=escalateGrievance&id=' . $data['id'] . '"> <button type="button" class="btn btn-success btn-lg waves-effect" >Escalate Grievance</button></a>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>    
    <!-- Files grievance -->   
       <div id="files' . $data['id'] . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add Files Grivance Ref: ' . $data['ref_number'] . '</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Add files/photos supporting grievance</h4>
                                           <form method="post" action="" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <div class="form-group">
                                                    <label class="control-label">Describe File Details</label>
                                                    <input type="text" id="firstName" class="form-control input-lg input-block-level" placeholder="" name="name">
                                                    </div>
                                                    
                                                    
                                    </div> <div class="input-group mb-3">
                                    <div class="form-group">
                                                    <label class="control-label">Select File</label>
                                                    </div>
                                    </div> <div class="input-group mb-3">
                                    
                                       
                                        <div class="custom-file">
                                            <input type="file" name="fileToUpload"  id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div> <input type="hidden" name="id" value="' . $data['id'] . '">
                                                        <input type="hidden" name="action" value="fileGrievance">
                                                       
                                     <button type="submit" class="btn btn-success btn-lg waves-effect waves-light">Submit</button>
                                </form>
                                 </div>
                                        
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>    
    <!-- Response grievance -->   
       <div id="response' . $data['id'] . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                   <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Comment/Respond to Complaint</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="">
                                                    
                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Your Response/Comment:</label>
                                                        <input type="hidden" name="id" value="' . $data['id'] . '">
                                                        <input type="hidden" name="action" value="responseGrievance">
                                                        <textarea class="form-control" name="text" id="message-text"></textarea>
                                                    </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Save Response</button>
                                            </div>
                                            
                                            </form>
                                        </div>
                                    </div>
                                </div>    
    <!-- Settle grievance -->   
       <div id="settle' . $data['id'] . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Settle Grivance Ref: ' . $data['ref_number'] . '</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Settle Grievance</h4>
                                            
                                            
                                            
                                            
                                            
                                             </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success waves-effect" >Save Settlement</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
       
                    
                           
</td>
                                            </tr>';
        }

        return $rt;
    }

    public static function viewGRMResponses($id)
    {
        $content = "No responses for this grivance yet.";
        $sql = self::conGRM()->query("SELECT * FROM grivance_response WHERE grivance_id=$id ORDER BY id DESC");
        if ($sql->num_rows > 0) {
            $rr = [];
            while ($data = $sql->fetch_assoc()) {
                $user = user::getUserDetails($data['user_id']);
                $user_category  = user::getUserCategory($user['user_category_id']);
                $now = date('Y-m-d H:i:s');

                $rr[] = '<p style="border-bottom:1px dotted dimgrey ">' . $data['description'] . ' <br /><small><i><b>' . $user['first_name'] . ' ' . $user['last_name'] . '</b></i>  - ' . $user['phone'] . '  <br /> ' . $user_category . '<br /> ' . makeAgo($now, $data['created'], 1) . ' ago.</small></p> ';
            }

            $content = implode(" ", $rr);
        }


        return $content;
    }

    public static function viewGRMFiles($id)
    {
        $content = "No files for this grivance yet.";
        $sql = self::conGRM()->query("SELECT * FROM files WHERE grievance_id=$id ORDER BY id DESC");
        if ($sql->num_rows > 0) {
            $rr = [];
            $x = 1;
            while ($data = $sql->fetch_assoc()) {

                $user = user::getUserDetails($data['user_id']);
                $user_category  = user::getUserCategory($user['user_category_id']);
                $now = date('Y-m-d H:i:s');

                $rr[] = ' File ' . $x . ' <a href="' . ROOT . '/' . $data['url'] . '">' . $data['name'] . '</a> <br /><small><i><b>' . $user['first_name'] . ' ' . $user['last_name'] . '</b></i>  - ' . $user['phone'] . '  <br /> ' . $user_category . '<br /> ' . makeAgo($now, $data['created'], 1) . ' ago.</small></p>';
                $x++;
            }

            $content = implode(" ", $rr);
        }


        return $content;
    }
    public static function viewGRMReport()
    {

        $content = '
     
     <table class="table table-striped">
     <tr>
     <th>Grievance Nature</th>
     <th>Jul/19</th>
     <th>Aug/19</th>
     <th>Sept/19</th>
     <th>OCt/19</th>
     <th>Nov/19</th>
     <th>Dec/19</th>
     <th>Jan/20</th>
     <th>Feb/20</th>
     <th>Mar/20</th>
     <th>Apr/20</th>
     <th>May/20</th>
     <th>Jun/20</th>
     
</tr>
<tr>
<th>Fraud</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(1) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<th>Land Dispute</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(2) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<th>Compesation</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(3) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<th>Environmental</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(4) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<th>Social Issues</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(5) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<th>Management</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(6) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>

<tr>
<th>E-Voucher System</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(7) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<th>Input Dealers</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(9) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>

<tr>
<th>Others</th>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>' . self::countGrievancesByNature(10) . '</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
     </table>
     ';


        return $content;
    }

    public static function countGrievancesByNature($id)
    {


        // echo "Session User ID is :".$_SESSION['user']['user_category_id'];

        switch ($_SESSION['user']['user_category_id']) {

                //Admins
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 10:
            case 11:
            case 12:
            case 24:

                $sql = self::conGRM()->query("SELECT * FROM grivance WHERE grievance_nature_id=$id AND parish_id IN (SELECT parish.id FROM parish,subcounty,county,district WHERE district.id=" . $_SESSION['user']['district_id'] . " AND  district.id = county.district_id AND county.id = subcounty.county_id  AND subcounty.id = parish.subcounty_id)  ORDER BY grivance.id DESC");
                break;

                //Admins National

            case 6:
            case 15:
            case 16:
            case 17:
            case 18:

                $sql = self::conGRM()->query("SELECT * FROM grivance WHERE grievance_nature_id=$id ORDER BY grivance.id DESC");

                break;


                //EOs
            case 7:
            case 8:
            case 9:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
                $sql = self::conGRM()->query("SELECT * FROM grivance WHERE grievance_nature_id=$id AND parish_id IN (SELECT parish.id FROM parish WHERE subcounty_id=" . $_SESSION['user']['location_id'] . ")  ORDER BY grivance.id DESC");

                break;


            default:


                break;
        }

        return $sql->num_rows;
    }

    public static function getLocationDetails($parish_id)
    {

        $sql = database::performQuery("SELECT district.name as district, subcounty.name as subcounty,parish.name as parish FROM district,county,subcounty,parish
                                              WHERE district.id = county.district_id
                                              AND county.id = subcounty.county_id
                                              AND subcounty.id =parish.subcounty_id
                                              AND parish.id = $parish_id
                                              ");


        return $sql->fetch_assoc();
    }


    public static function getLocationDetailsSubcounty($subcounty_id)
    {

        $sql = database::performQuery("SELECT district.name as district, subcounty.name as subcounty FROM district,county,subcounty
                                              WHERE district.id = county.district_id
                                              AND county.id = subcounty.county_id
                                              AND subcounty.id = $subcounty_id
                                              ");


        return $sql->fetch_assoc();
    }



    public static function escalateGrievance()
    {

        $id = $_REQUEST['id'];
        $date = makeMySQLDate();

        $sql = self::conGRM()->query("SELECT * FROM `grivance` WHERE  id=$id");
        while ($data = $sql->fetch_assoc()) {
            $status_id = $data['grivance_status_id'] + 1;
            if ($status_id == 4)
                $qq = 'date_dgrc = \'' . $date . '\'';
            else if ($status_id == 5)
                $qq = 'date_dgrc = \'' . $date . '\'';
            $sqla = self::conGRM()->query("UPDATE grivance SET grivance_status_id=$status_id,$qq  WHERE id=$id");
        }
        redirect_to(ROOT . '/?action=viewaGRMGrievance');
    }


    public static function responseGrievance()
    {

        $id = database::prepData($_REQUEST['id']);
        $uid = $_SESSION['user']['id'];
        $text = database::prepData($_REQUEST['text']);
        $created = makeMySQLDateTime();

        $sql = self::conGRM()->query("INSERT INTO `grivance_response`(`grivance_id`, `user_id`, `description`, `created`) 
                                                       VALUES ($id,$uid,'$text','$created') ");

        redirect_to(ROOT . '/?action=viewaGRMGrievance');
    }


    public static function fileGrievance()
    {

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $uid = $_SESSION['user']['id'];
        $created = makeMySQLDateTime();

        $month = date("m");
        $day = date("d");
        $year = date("Y");

        $target_dir = "grm/uploads/" . $year . "/" . $month . "/";
        $target_file = $target_dir . time() . basename($_FILES["fileToUpload"]["name"]);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        $sql = self::conGRM()->query("INSERT INTO `files`(`name`,url, `user_id`, `grievance_id`, `created`) 
                                                       VALUES ('$name','$target_file',$uid,$id,'$created') ");

        redirect_to(ROOT . '/?action=viewaGRMGrievance');
    }

    public static function manageUsersWorkplanButtons()
    {

        $district =  district::getDistrictName($_SESSION['user']['district_id']);
        $content = '';

        if (dashboard::checkIfDistrictLeadershipAdminAccount()) {
            //Case When DPMO CAO Account
            $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-3 col-md-3">
                                       <h4>' . self::checkCityDistrictStatus($_SESSION['user']['district_id']) . ' : ' . $district . '</h4>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageWorkplanDistrict&district_id=' . $_SESSION['user']['district_id'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-info">' . self::checkCityDistrictStatus($_SESSION['user']['district_id']) . '  Workplan</button></a> 
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageWorkplans2">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">' . self::checkCityDistrictStatus($_SESSION['user']['district_id']) . '  Heads Workplans</button></a> 
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageWorkplans">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-warning">Extension Officers Workplans</button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
        } else if (dashboard::checkIfMAAIFAdminAccount()) {

            //Choose Distict form
            $content .= '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Choose District/City Form</h3>
                                <h4 class="card-subtitle"> Choose District whose workplans to view </h4>
                                <form class="m-t-30" method="get" action="#">
                                   <table class="table table-borderless">
                                   <tr><td>
                                    <div class="form-group m-b-30">
                                        <label class="mr-sm-2">Select District/City</label>
                                        <select  name="district" data-border-color="success" data-border-variation="darken-2" class="select2 select2-with-border border-sucess form-control custom-select" style="width: 100%; height:36px;" required>
                                            ' . district::getAllDistrictsList() . '
                                        </select>
                                    </div>     
                                          </td>
                                          <td>                 
                                    <input type="hidden" name="action" value="manageWorkplansButtons" />
                                    <button type="submit" class="btn btn-lg btn-rounded btn-success">View Workplans</button>
                                     </td> </tr> 
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';


            if (isset($_REQUEST['district'])) {

                $district = district::getDistrictName($_REQUEST['district']);
                //Case when MAAIF Account
                $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-3 col-md-3">
                                       <h4>' . self::checkCityDistrictStatus($_REQUEST['district']) . '  : ' . $district . '</h4>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageWorkplanDistrict&district_id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-info">' . self::checkCityDistrictStatus($_REQUEST['district']) . ' Workplan</button></a> 
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageWorkplans2&district_id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">' . self::checkCityDistrictStatus($_REQUEST['district']) . ' Heads Workplans</button></a> 
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageWorkplans&district_id=' . $_REQUEST['district'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-warning">Extension Officers Workplans</button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }







        return $content;
    }

    public static function manageUsersButtons()
    {

        $content = '';

        if (dashboard::checkIfMAAIFAdminAccount()) {

            //Choose Distict form
            $content .= '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Choose District Form</h4>
                                <h6 class="card-subtitle"> Choose District whose users to view </h6>
                                <form class="m-t-30" method="get" action="#">
                                   
                                    <div class="form-group m-b-30">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select District</label>
                                        <select  name="district_id" data-border-color="success" data-border-variation="darken-2" class="select2 select2-with-border border-sucess form-control custom-select" style="width: 100%; height:36px;" required>
                                        ';
            //Check if System Admin or Data Manager and display option to Manage MAAIF Users
            if ($_SESSION['user']['user_category_id'] == 5 || $_SESSION['user']['user_category_id'] == 54) {
                $content .= '<option value="0">MAAIF USERS</option>';
            }

            $content .= district::getAllDistrictsList() . '
                                        </select>
                                    </div>                                    
                                    <input type="hidden" name="action" value="manageUsers" />
                                    <button type="submit" class="btn btn-lg btn-success">Manage Users</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';


            if (isset($_REQUEST['district'])) {

                $district = district::getDistrictName($_REQUEST['district']);
                //Case when MAAIF Account
                $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-4 col-md-4">
                                       <h4>District : ' . $district . '</h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=manageUsers&district_id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">Manage ' . $district . ' Users</button></a> 
                                    </div>
                                                                        
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }







        return $content;
    }


    public static function manageDistrictReportsButtons()
    {

        $content = '';

        if (dashboard::checkIfMAAIFAdminAccount()) {

            //Choose Distict form
            $content .= '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Choose District Form</h4>
                                <h6 class="card-subtitle"> Choose District whose reports to view </h6>
                                <form class="m-t-30" method="get" action="#">
                                   <table class="table table-borderless">
                                   <tr><td>
                                    <div class="form-group m-b-30">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select District</label>
                                        <select  name="district" data-border-color="success" data-border-variation="darken-2" class="select2 select2-with-border border-sucess form-control custom-select" style="width: 100%; height:36px;" required>
                                            ' . district::getAllDistrictsList() . '
                                        </select>
                                    </div>        
                                    </td>
                                          <td>                             
                                    <input type="hidden" name="action" value="manageDistrictReportingButtons" />
                                    <button type="submit" class="btn btn-rounded btn-lg btn-success">View Reports</button>
                                     </td> </tr> 
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';


            if (isset($_REQUEST['district'])) {

                $district = district::getDistrictName($_REQUEST['district']);
                //Case when MAAIF Account
                $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-4 col-md-4">
                                       <h4>District : ' . $district . '</h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewEODistrictReport&id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">General District Report</button></a> 
                                    </div>
                                    
                                    
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageDistrictSectorReport&sector=1&district_id=' . $_REQUEST['district'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-warning">District Crop Report  </button></a>
                                    </div>
                                    
                                     <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageDistrictSectorReport&sector=2&district_id=' . $_REQUEST['district'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-primary">District Livestock Report  </button></a>
                                    </div>
                                    
                                     <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageDistrictSectorReport&sector=3&district_id=' . $_REQUEST['district'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-danger">District Fish Report  </button></a>
                                    </div>
                                    
                                     <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageDistrictSectorReport&sector=4&district_id=' . $_REQUEST['district'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-dark">District Entomology Report  </button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }







        return $content;
    }

    public static function manageZonalReportsButtons()
    {

        $content = '';

        if (dashboard::checkIfMAAIFAdminAccount()) {

            //Choose Distict form
            $content .= '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Choose Zone Form</h4>
                                <h6 class="card-subtitle"> Choose Zone whose reports to view </h6>
                                <form class="m-t-30" method="get" action="#">
                                   
                                    <div class="form-group m-b-30">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select Zone</label>
                                        <select class="custom-select mr-sm-2" name="zone" id="inlineFormCustomSelect">
                                            ' . reportZonal::getAllZonesList() . '
                                        </select>
                                    </div>                                    
                                    <input type="hidden" name="action" value="manageZonalReportingButtons" />
                                    <button type="submit" class="btn btn-lg btn-success">View Reports</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';


            if (isset($_REQUEST['zone'])) {

                $zone = reportZonal::getZonalName($_REQUEST['zone']);
                //Case when MAAIF Account
                $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-4 col-md-4">
                                       <h4>Zone : ' . $zone . ' ZARDI</h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewEOZonalReport&id=' . $_REQUEST['zone'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">General Zonal Report</button></a> 
                                    </div>
                                    
                                    
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageZonalSectorReport&sector=1&zone_id=' . $_REQUEST['zone'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-warning">Zonal Crop Report  </button></a>
                                    </div>
                                    
                                     <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageZonalSectorReport&sector=2&zone_id=' . $_REQUEST['zone'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-primary">Zonal Livestock Report  </button></a>
                                    </div>
                                    
                                     <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageZonalSectorReport&sector=3&zone_id=' . $_REQUEST['zone'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-danger">Zonal Fish Report  </button></a>
                                    </div>
                                    
                                     <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewManageZonalSectorReport&sector=4&zone_id=' . $_REQUEST['zone'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-dark">Zonal Entomology Report  </button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }







        return $content;
    }

    public static function manageUsersEvaluationButtons()
    {

        $district =  district::getDistrictName($_SESSION['user']['district_id']);
        $content = '';

        if (dashboard::checkIfDistrictLeadershipAdminAccount()) {
            //Case When DPMO CAO Account
            $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-4 col-md-4">
                                       <h4>' . self::checkCityDistrictStatus($_SESSION['user']['district_id']) . ' : ' . $district . '</h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewEvaluaton2">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">' . self::checkCityDistrictStatus($_SESSION['user']['district_id']) . ' Heads Evaluations</button></a> 
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=viewEvaluaton">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-warning">Extension Officers Evaluations </button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
        } else if (dashboard::checkIfMAAIFAdminAccount()) {

            //Choose Distict form
            $content .= '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Choose District/City Form</h4>
                                <h6 class="card-subtitle"> Choose District whose evaluations to view </h6>
                                <form class="m-t-30" method="get" action="#">
                                    <table class="table table-borderless">
                                   <tr><td>
                                    <div class="form-group m-b-30">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select District/City</label>
                                        <select  name="district" data-border-color="success" data-border-variation="darken-2" class="select2 select2-with-border border-sucess form-control custom-select" style="width: 100%; height:36px;" required>
                                            ' . district::getAllDistrictsList() . '
                                        </select>
                                    </div>       
                                    </td>
                                          <td>                               
                                    <input type="hidden" name="action" value="viewEvaluatonButtons" />
                                    <button type="submit" class="btn btn-lg btn-rounded btn-success">View Evaluations</button>
                                    
                                     </td> </tr> 
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';


            if (isset($_REQUEST['district'])) {

                $district = district::getDistrictName($_REQUEST['district']);
                //Case when MAAIF Account
                $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-3 col-md-3">
                                       <h4>' . self::checkCityDistrictStatus($_REQUEST['district']) . ' : ' . $district . '</h4>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=viewEvaluatonDistrict&district_id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-info">' . self::checkCityDistrictStatus($_REQUEST['district']) . '  Evaluation</button></a> 
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=viewEvaluaton2&district_id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">' . self::checkCityDistrictStatus($_REQUEST['district']) . ' Heads Evaluation </button></a> 
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=viewEvaluaton&district_id=' . $_REQUEST['district'] . '">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-warning">Extension Officers Evaluation</button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }







        return $content;
    }


    public static function manageQuarterlyActivitiesNewButtons()
    {

        $district =  district::getDistrictName($_SESSION['user']['district_id']);
        $content = '';

        if (dashboard::checkIfDistrictLeadershipAdminAccount()) {
            //Case When DPMO CAO Account
            $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-4 col-md-4">
                                       <h4>' . self::checkCityDistrictStatus($_SESSION['user']['district_id']) . ' : ' . $district . '</h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=manageQuarterlyActivitiesNew2">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-success">' . self::checkCityDistrictStatus($_SESSION['user']['district_id']) . ' Heads Quarterly Activities</button></a> 
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                     <a href="' . ROOT . '/?action=manageQuarterlyActivitiesNew">    <button type="button" class="btn btn-block btn-rounded btn-lg btn-warning">Extension Officers Quarterly Activities </button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
        } else if (dashboard::checkIfMAAIFAdminAccount()) {

            //Choose Distict form
            $content .= '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Choose District/City Form</h4>
                                <h6 class="card-subtitle"> Choose District/City whose Quarterly Activities to view </h6>
                                <form class="m-t-30" method="get" action="#">
                                   <table class="table table-borderless">
                                   <tr><td>
                                    <div class="form-group m-b-30">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select District/City</label>
                                        <select  name="district" data-border-color="success" data-border-variation="darken-2" class="select2 select2-with-border border-sucess form-control custom-select" style="width: 100%; height:36px;" required>
                                            ' . district::getAllDistrictsList() . '
                                        </select>
                                    </div>         
                                     </td>
                                          <td>                             
                                    <input type="hidden" name="action" value="manageQuarterlyActivitiesNewButtons" />
                                    <button type="submit" class="btn btn-lg btn-rounded btn-success">View Quarterly Activities</button>
                              </td> </tr> 
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';


            if (isset($_REQUEST['district'])) {

                $district = district::getDistrictName($_REQUEST['district']);
                //Case when MAAIF Account
                $content .= '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                 <div class="row button-group">
                                    <div class="col-lg-3 col-md-3">
                                       <h4>' . self::checkCityDistrictStatus($_REQUEST['district']) . '  : ' . $district . '</h4>
                                    </div>
                                   <!-- <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageQuarterlyActivitiesNew2&district_id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-lg btn-rounded btn-info">' . self::checkCityDistrictStatus($_REQUEST['district']) . '  Quarterly Activities</button></a> 
                                    </div>-->
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageQuarterlyActivitiesNew2&district_id=' . $_REQUEST['district'] . '">  <button type="button" class="btn btn-block btn-xl btn-rounded btn-success">' . self::checkCityDistrictStatus($_REQUEST['district']) . ' Heads Quarterly Activities</button></a> 
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                     <a href="' . ROOT . '/?action=manageQuarterlyActivitiesNew&district_id=' . $_REQUEST['district'] . '">    <button type="button" class="btn btn-block btn-rounded btn-xl btn-warning">Extension Officers Quarterly Activities </button></a>
                                    </div>
                                    
                                 </div>   
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }







        return $content;
    }

    public static function manageUsersWorkplan()
    {



        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Distrcit / <br />Subcounty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserWorkplanList() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
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

    public static function manageUsersWorkplanSMS()
    {



        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Workstation</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserWorkplanListSMS() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Workstation</th>
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


    public static function manageUsersEvaluation()
    {

        $content = '<div class="row">
                   
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Manage User\'s Evauation</h4>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserEvaluationList() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
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


    public static function manageUsersEvaluation2()
    {

        $content = '<div class="row">
                   
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Manage User\'s Evauation</h4>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserEvaluationListSMS() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
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

    public static function manageUsersAnnualActivitiesNew()
    {

        $content = '<div class="row">
                   
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserAnnualActivitiesList() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
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



    public static function manageUsersQuarterlyActivitiesNew()
    {

        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserQuartelyActivitiesList() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
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

    public static function manageUsersQuarterlyActivitiesNew2()
    {

        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserQuartelyActivitiesList2() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
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



    public static function manageAnnualObjectivesNew()
    {

        $content = '<div class="row">
                
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserManageAnnualActivity() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Subcounty</th>
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



    public static function manageQuarterlyOutputs()
    {

        $content = '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>District</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . self::getUserManageListQuarterlyOutputs() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Photo</th>                                                
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>District</th>
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

    public static function switchUserCat()
    {

        $content = '<select class="form-control custom-select" name="user_cat">';
        switch ($_SESSION['user']['user_category_id']) {


            case 2:
            case 57:
                $sql = database::performQuery("SELECT * FROM user_category WHERE user_group_id IN (7)  ORDER BY name ASC");
                while ($data = $sql->fetch_assoc()) {
                    $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                }


                break;

            case 3:
            case 56:
                $sql = database::performQuery("SELECT * FROM user_category WHERE user_group_id IN (8)  ORDER BY name ASC");
                while ($data = $sql->fetch_assoc()) {
                    $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                }
                break;

            case 4:
            case 58:


                $sql = database::performQuery("SELECT * FROM user_category WHERE user_group_id IN (9)  ORDER BY name ASC");
                while ($data = $sql->fetch_assoc()) {
                    $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                }
                break;


            case 12:
            case 59:
                $sql = database::performQuery("SELECT * FROM user_category WHERE user_group_id IN (10)  ORDER BY name ASC");
                while ($data = $sql->fetch_assoc()) {
                    $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                }
                break;



                //System Admins Check
            case 5:
            case 54:

                if ($_REQUEST['district_id'] == 0) {
                    $sql = database::performQuery("SELECT * FROM user_category  ORDER BY name ASC");
                    while ($data = $sql->fetch_assoc()) {
                        $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                    }
                } else {
                    $sql = database::performQuery("SELECT * FROM user_category WHERE user_group_id IN (3,4)  ORDER BY name ASC");
                    while ($data = $sql->fetch_assoc()) {
                        $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                    }
                }

                break;



                //DPO
            case 10:
            case 55:

                $sql = database::performQuery("SELECT * FROM user_category WHERE user_group_id IN (5,6,11) ORDER BY name ASC");
                while ($data = $sql->fetch_assoc()) {
                    $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                }

                break;


            case 84:

                $sql = database::performQuery("SELECT * FROM user_category WHERE user_group_id IN (5,6,7,8,9,10,11) ORDER BY name ASC");
                while ($data = $sql->fetch_assoc()) {
                    $content .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                }

                break;

            default:
                $content = '';
                break;
        }

        $content .= '</select>';
        return $content;
    }


    public static function getAreaSubcounties()
    {


        $id = $_SESSION['user']['district_id'];
        $sql = database::performQuery("SELECT subcounty.name,subcounty.id FROM subcounty,county,district
                                              WHERE district.id =county.district_id
                                              AND county.id = subcounty.county_id
                                              AND district_id=$id
                                              ORDER BY subcounty.name ASC");

        $content = '';

        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . '</option>';
        }
        return $content;
    }


    public static function getAreaSubcountiesSelected($district_id)
    {


        $id = $_SESSION['user']['district_id'];
        $sql = database::performQuery("SELECT subcounty.name,subcounty.id FROM subcounty,county,district
                                              WHERE district.id =county.district_id
                                              AND county.id = subcounty.county_id
                                              AND district_id=$district_id
                                              ORDER BY subcounty.name ASC");

        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . '</option>';
        }
        return $content;
    }
    public static function getAreaCounties($district_id)
    {


        $id = $_SESSION['user']['district_id'];
        $sql = database::performQuery("SELECT * FROM county
                                              WHERE  district_id=$district_id 
                                              ORDER BY name ASC");

        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . '</option>';
        }
        return $content;
    }

    public static function getDistricts()
    {

        $sql = database::performQuery("SELECT district.name,district.id FROM district
                                            ORDER BY name ASC
                                             ");
        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . ' </option>';
        }
        return $content;
    }
    public static function getDistrictsSelected($district_id)
    {

        $sql = database::performQuery("SELECT district.name,district.id FROM district
                                            ORDER BY name ASC
                                             ");
        $content = '';
        while ($data = $sql->fetch_assoc()) {
            if ($district_id == $data['id'])
                $content .= '<option value="' . $data['id'] . '" SELECTED>' . ucwords(strtolower($data['name'])) . ' </option>';
            else
                $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . ' </option>';
        }
        return $content;
    }
    public static function switchUserLocation()
    {


        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
            case 10:
            case 12:
            case 84:
            case 55:
            case 56:
            case 57:
            case 58:
            case 59:
                $content = '


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select District/City</label>
                                                    <input type="hidden" name="district_id" value="' . $_SESSION['user']['district_id'] . '" />
                                                   <select class="form-control custom-select" name="district_id"  disabled>
                                                    ' . self::getDistrictsSelected($_SESSION['user']['district_id']) . '
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="control-label">Select Subcounty/Town Council</label>
                                                <select class="form-control custom-select" name="location_id" id="select_subcounty">
                                                   <option value="0">District/City Headquarters</option>
                                                   ' . self::getAreaSubcounties() . '
                                                   </select>
                                                </div>
                                            </div>
                                            
                                             
                                            <!--/span-->
                                           
                                        </div>
';
                break;


            case 6:
            case 5:
            case 54:
                $content = '
                                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select District/City</label>
                                                    <input type="hidden" name="district_id" value="' . $_REQUEST['district_id'] . '" />
                                                    <select class="form-control custom-select" name="district_id" disabled>
                                                    ' . self::getDistrictsSelected($_REQUEST['district_id']) . '
                                                    </select>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="control-label">Select Subcounty/Town Council</label>
                                                <select class="form-control custom-select" name="location_id"  id="select_subcounty">
                                                     <option value="0">District/City Headquarters</option>
                                                   ' . self::getAreaSubcountiesSelected($_REQUEST['district_id']) . '
                                                   </select>
                                                </div>
                                            </div>
                                         
                                            <!--/span-->
                                           
                                        </div>';
                break;

            default:
                $content = '';
                break;
        }
        return $content;
    }


    public static function getDistrictBySubcounty($id)
    {

        $sql = database::performQuery("SELECT district_id FROM subcounty,county WHERE county.id = subcounty.county_id AND  subcounty.id=$id");

        return $sql->fetch_assoc()['district_id'];
    }

    public static function processNewUser()
    {

        $reponse =  array();

        $firstname = database::prepData($_REQUEST['firstname']);
        $lastname = database::prepData($_REQUEST['lastname']);
        $username = database::prepData($_REQUEST['username']);
        $phone = database::prepData($_REQUEST['phone']);
        $email = database::prepData($_REQUEST['email']);
        $gender = database::prepData($_REQUEST['gender']);
        $location = database::prepData($_REQUEST['location_id']) ?? NULL;
        $district = database::prepData($_REQUEST['district_id']);
        $password = database::prepData($_REQUEST['password']);
        $user_cat = database::prepData($_REQUEST['user_cat']);
        $directorate_id = database::prepData($_REQUEST['directorate_id']) ?? NULL;
        $department_id = database::prepData($_REQUEST['department_id']) ?? NULL;
        $division_id = database::prepData($_REQUEST['division_id']) ?? NULL;
        $parish_id = database::prepData($_REQUEST['parish_id']) ?? NULL;
        $municipality_id = database::prepData($_REQUEST['municipality_id']) ?? NULL;



        $created = makeMySQLDateTime();
        $sql = database::performQuery("INSERT INTO `user`( `first_name`, `last_name`, `username`, `email`, `password`, `created`, `phone`, `location_id`, `user_category_id`,  `gender`, district_id, `directorate_id`, `department_id`, `division_id`,parish_id,municipality_id)
                                           VALUES('$firstname','$lastname','$username','$email','$password','$created','$phone',NULLIF('$location', ''),$user_cat,'$gender',$district, NULLIF('$directorate_id', ''), NULLIF('$department_id', ''), NULLIF('$division_id', ''),NULLIF('$parish_id', ''),NULLIF('$municipality_id', ''))");

        $id = database::getLastInsertID();

        $verification_code = mt_rand(10000, 99999);

        $verification_sms = 'You were signed up for the MAAIF Extension System. Your verification code
            is ' . $verification_code;

        $send_sms =  self::send_sms_niita($phone, $verification_sms);

        $sql = database::performQuery("INSERT INTO `user_verification`(`verification_code`, `user_id`)
                                           VALUES($verification_code, $id)");


        print_r($send_sms);

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'users@m-omulimisa.com';
        $mail->Password = '@Myheartgud2022';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('users@m-omulimisa.com', 'MAAIF E-extension SYSTEM');  // Set sender of the mail
        $mail->addAddress($email);

        $mail->Subject = 'WELCOME EMAIL';
        // Set HTML
        $mail->isHTML(TRUE);

        $mail->Body = "
        <html>
        <head>
        <title>MAAIF E-extension SYSTEM</title>
        </head>
        <body>
        <p>HELLO, " . $firstname . " " . $lastname . " </p>
        <p> You are receiving this email because you were signed up for
        the MAAIF E-extension System. </p>

        <p> Your Login credentials are: <br/>
        Username : " . $username . "<br/>
        Password : " . $password . "<br/>

        <p>Kindly follow this link to access the system: https://extension.agriculture.go.ug </p>



        <p>If this is not you, kindly ignore this email</p>
        <p>Thank You</p>
        </body>
        </html>
            ";

        $mail->AltBody = 'Hello Welcome to MAAIF SYSTEM';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {

            $response['message'] =  "Data inserted successfully";
            http_response_code(200);
            echo json_encode($response);
        }
    }


    public static function switchUserMeetingsStatus()
    {



        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

                //National
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:

                $content = 5;

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

                $content = 4;

                break;


                //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

                $content = 3;

                break;

            default:
                $content = 3;
                break;
        }


        return $content;
    }


    public static function processNewMeeting()
    {

        $theme = database::prepData($_REQUEST['theme']);
        $attendees = database::prepData($_REQUEST['attendees']);
        $proceedings = database::prepData($_REQUEST['proceedings']);
        $discussions = database::prepData($_REQUEST['discussions']);
        $recommendations = database::prepData($_REQUEST['recommendations']);

        $location_id = $_SESSION['user']['location_id'];
        $user_id = $_SESSION['user']['id'];
        $status_id = self::switchUserMeetingsStatus();
        $created = makeMySQLDateTime();

        $sql = self::conGRM()->query("INSERT INTO `meeting`(`theme`, `created`, `proceedings`, `discussions`, `recommendations`, `attendees`, `status_id`, `location_id`, `user_id`) 
                                                VALUES ('$theme','$created','$proceedings','$discussions','$recommendations','$attendees','$status_id','$location_id',$user_id)");


        redirect_to(ROOT . '/?action=manageMeetings');
    }

    public static function editUserProfile()
    {

        $firstname = database::prepData($_REQUEST['firstname']);
        $lastname = database::prepData($_REQUEST['lastname']);
        $username = trim(database::prepData($_REQUEST['username']));
        $phone = database::prepData($_REQUEST['phone']);
        $email = database::prepData($_REQUEST['email']);
        $gender = database::prepData($_REQUEST['gender']);
        $password = trim(database::prepData($_REQUEST['password']));
        $id = database::prepData($_REQUEST['id']);


        $es = "UPDATE `user` SET `first_name` = '$firstname', 
                                                             `last_name` = '$lastname', 
                                                             `username` = '$username', 
                                                             `email` = '$email',
                                                              `password` = '$password', 
                                                              `phone` = '$phone', 
                                                               `gender` = '$gender'
                                           WHERE id = $id";
        $sql = database::performQuery($es);


        redirect_to(ROOT . '/?action=viewUserProfile&id=' . $id);
    }


    public static function editMyProfile()
    {

        $firstname = database::prepData($_REQUEST['firstname']);
        $lastname = database::prepData($_REQUEST['lastname']);
        $username = database::prepData($_REQUEST['username']);
        $phone = database::prepData($_REQUEST['phone']);
        $email = database::prepData($_REQUEST['email']);
        $gender = database::prepData($_REQUEST['gender']);
        $password = database::prepData($_REQUEST['password']);
        $id = $_SESSION['user']['id'];
        $year_working = database::prepData($_REQUEST['year_working']);
        $year_maaif = database::prepData($_REQUEST['year_maaif']);
        $job_title = database::prepData($_REQUEST['job_title']);
        $education = database::prepData($_REQUEST['education']);


        $es = "UPDATE `user` SET `first_name` = '$firstname',
                                      year_working = '$year_working', year_maaif = '$year_maaif',
                                      education = '$education',job_title = '$job_title', 
                                                             `last_name` = '$lastname', 
                                                             `username` = '$username', 
                                                             `email` = '$email',
                                                              `password` = '$password', 
                                                              `phone` = '$phone', 
                                                               `gender` = '$gender'
                                           WHERE id = $id";

        //echo $es;
        $sql = database::performQuery($es);


        redirect_to(ROOT . '/?action=viewProfile');
    }



    public static function processNewAnnualKO()
    {

        $year = database::prepData($_REQUEST['year']);
        $output = database::prepData($_REQUEST['output']);
        $target = database::prepData($_REQUEST['target']);
        $indicator = database::prepData($_REQUEST['indicator']);
        $budget = database::prepData($_REQUEST['budget']);
        $id = database::prepData($_REQUEST['id']);
        $activ = [];
        foreach ($_REQUEST['activities'] as $activity)
            $activ[] = $activity;
        $activities = implode(',', $activ);


        $sql = database::performQuery("INSERT INTO `ext_area_annual_outputs`(`key_output`, `activities`, `indicators`, `target`, `year`, `budget`, `user_id`)
                                                                          VALUES('$output','$activities','$indicator','$target','$year','$budget','$id')");


        redirect_to(ROOT . '/?action=viewUserWorkplan&id=' . $id);
    }

    public static function processAnnualObjectives()
    {

        $year = database::prepData($_REQUEST['year']);
        $id = database::prepData($_REQUEST['user_id']);
        $objectives = $_REQUEST['objective'];
        $data = [];
        foreach ($objectives as $objective) {
            if ($objective != '')
                $data[] = "('$objective',$id,$year)";
        }
        //         echo '<pre>';
        //         print_r($data);
        //         exit;
        $dd = "INSERT INTO `ext_objectives_annual` (objective,user_id,year) VALUES " . implode(',', $data);

        $sql = database::performQuery($dd);
        redirect_to(ROOT . '/?action=viewUserObjectives&id=' . $id);
    }


    public static function processPotentialEnt()
    {

        $id = database::prepData($_REQUEST['user_id']);
        $objectives = $_REQUEST['entreprize_id'];
        $data = [];
        foreach ($objectives as $objective) {
            if ($objective != '')
                $data[] = "($objective,$id)";
        }
        //         echo '<pre>';
        //         print_r($data);
        //         exit;
        $dd = "INSERT INTO ext_potenial ( `km_category_id`, `user_id`) VALUES " . implode(',', $data);


        //   echo $dd;
        $sql = database::performQuery($dd);
        redirect_to(ROOT . '/?action=potenialCommodities');
    }




    public static function processPopularEnt()
    {

        $id = database::prepData($_REQUEST['user_id']);
        $objectives = [];
        if (isset($_REQUEST['entreprize_id'])) {
            $objectives = $_REQUEST['entreprize_id'];
        }
        $data = [];
        foreach ($objectives as $objective) {
            if ($objective != '')
                $data[] = "($objective,$id)";
        }
        //         echo '<pre>';
        //         print_r($data);
        //         exit;
        $dd = "INSERT INTO ext_popular ( `km_category_id`, `user_id`) VALUES " . implode(',', $data);


        //   echo $dd;
        $sql = database::performQuery($dd);
        redirect_to(ROOT . '/?action=popularCommodities');
    }




    public static function processAreaProfileNew()
    {

        $id = $_REQUEST['user_id'];


        $count = COUNT($_REQUEST['parish_id']);
        $ff = [];
        for ($x = 0; $x < $count; $x++) {
            $ff[] = '(' . $id . ',' . $_REQUEST['parish_id'][$x] . ',' . $_REQUEST['men'][$x] . ',' . $_REQUEST['women'][$x] . ',' . $_REQUEST['group'][$x] . ')';
        }



        //
        //        echo '<pre>';
        //        print_r($ff);
        //        exit;

        $dd = "INSERT INTO `ext_area_profile`(`user_id`, `parish_id`, `pop_males`, `pop_females`, `pop_ben_groups`)
                VALUES  " . implode(',', $ff);


        //   echo $dd;
        $sql = database::performQuery($dd);
        redirect_to(ROOT . '/?action=areaProfile');
    }



    public static function processAnnualActivities()
    {

        $year = database::prepData($_REQUEST['year']);
        $user_id = database::prepData($_REQUEST['user_id']);
        $planned = database::prepData($_REQUEST['planned_num']);
        $target = database::prepData($_REQUEST['target']);
        $activity = database::prepData($_REQUEST['activity_id']);


        $dd = "
INSERT INTO `ext_area_annual_activity`( `activity`, `num_planned`, `num_target_ben`,`year`,user_id)
VALUES ('$activity','$planned','$target','$year',$user_id)";
        echo $dd;
        $sql = database::performQuery($dd);
        // redirect_to(ROOT.'/?action=viewAnnualActivities&id='.$user_id);

    }



    public static function processQuarterlyActivities()
    {

        //$month = database::prepData($_REQUEST['month']);
        $quarter = $_REQUEST['quarter'];
        $user_id = $_REQUEST['id'];
        $planned = database::prepData($_REQUEST['planned_num']);
        $target = database::prepData($_REQUEST['target']);
        $activity = database::prepData($_REQUEST['activity_id']);
        $budget = database::prepData($_REQUEST['budget']);
        $outputs = database::prepData($_REQUEST['outputs']);
        $topics = [];
        foreach ($_REQUEST['topics'] as $topic)
            $topics[] = $topic;
        $topics = implode(',', $topics);


        $entt = [];
        foreach ($_REQUEST['entt'] as $ent)
            $entt[] = $ent;
        $entt = implode(',', $entt);


        $output = [];
        foreach ($_REQUEST['outputs'] as $outputz)
            $output[] = $outputz;
        $output = implode(',', $output);




        $dd = "
        INSERT INTO `ext_area_quaterly_activity`
        (`num_planned`, `num_target_ben`,  `budget`, `annual_id`, `quarter`,user_id,topic,entreprizes,key_output_id)
        VALUES('$planned','$target','$budget','$activity','$quarter',$user_id,'$topics','$entt','$output')";

        //        echo"<pre>".$dd."</pre>";

        $sql = database::performQuery($dd);
        redirect_to(ROOT . '/?action=viewQuarterlyActivities&id=' . $user_id);
    }




    public static function processSubmitQuarterlyActivities()
    {

        //$month = database::prepData($_REQUEST['month']);
        $quarter = $_REQUEST['quarter'];
        $user_id = $_REQUEST['id'];
        $planned = database::prepData($_REQUEST['planned_num']);
        $target = database::prepData($_REQUEST['target']);
        $activity = database::prepData($_REQUEST['activity_id']);
        $budget = database::prepData($_REQUEST['budget']);
        $outputs = database::prepData($_REQUEST['outputs']);
        $topics = [];
        foreach ($_REQUEST['topics'] as $topic)
            $topics[] = $topic;
        $topics = implode(',', $topics);


        $entt = [];
        foreach ($_REQUEST['entt'] as $ent)
            $entt[] = $ent;
        $entt = implode(',', $entt);


        $output = [];
        foreach ($_REQUEST['outputs'] as $outputz)
            $output[] = $outputz;
        $output = implode(',', $output);




        $dd = "
        INSERT INTO `ext_area_quaterly_activity`
        (`num_planned`, `num_target_ben`,  `budget`, `annual_id`, `quarter`,user_id,topic,entreprizes,key_output_id)
        VALUES('$planned','$target','$budget','$activity','$quarter',$user_id,'$topics','$entt','$output')";


        $sql = database::performQuery($dd);
        redirect_to(ROOT . '/?action=viewQuarterlyActivities&id=' . $user_id);
    }



    public static function getExitingQO($id)
    {

        $sql = database::performQuery("SELECT * FROM `ext_quarterly_output` WHERE user_id=$id ORDER BY YEAR ASC, quater ASC");


        if ($sql->num_rows > 0) {
            $content = '<table class="table table-bordered table-striped">
                                <tr>
                                <th>Year</th>
                                <th>Quarter</th>
                                </tr>
                                ';
            while ($data = $sql->fetch_assoc()) {

                $content .= '<tr>';
                $content .= '<td>' . $data['year'] . '</td>';
                $content .= '<td>' . $data['quater'] . '</td>';
                $content .= '</tr>';
            }
            $content .= '</table>';
        } else
            $content = 'None! ';


        return $content;
    }




    public static function getUserProfile()
    {

        $id = 0;
        if (isset($_REQUEST['user_id']))
            $id = $_REQUEST['user_id'];
        else
            $id = $_SESSION['user']['id'];


        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);

        //TODO fix this
        $year_working = date("Y") - $user[0]['year_working'];
        $year_maaif = date("Y") - $user[0]['year_maaif'];
        $content = '
        
       
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                
                                    <!--<a href=""><h6 class="card-subtitle"  style="color:#000"> <i class="fas fa-image"></i> Edit Profile Photo</h6></a>-->
                                  ' . self::userCardView($loc, $user, $cat) . '  
                                    <br/>
                                <a href="' . ROOT . '/?action=changeUserPassword"><button type="button" class="btn btn-primary">Change password</button></a>
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body" style="color:#000;font-size:14px"> 
                                <small class="text-muted" style="color:#000;font-size:14px">Username</small><h6>' . $user[0]['username'] . '</h6> 
                                <small class="text-muted" style="color:#000;font-size:14px">Email address </small><h6>' . $user[0]['email'] . '</h6> 
                                <small class="text-muted p-t-30 db" style="color:#000;font-size:14px">Phone</small><h6>' . $user[0]['phone'] . '</h6> 
                                <small class="text-muted p-t-30 db" style="color:#000;font-size:14px">District</small> <h6>' . $loc['district'] . '</h6>
                                <small class="text-muted p-t-30 db" style="color:#000;font-size:14px">Sub-County</small> <h6>' . $loc['subcounty'] . '</h6>
                                 
                               
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tabs -->
                            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                               
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
                                </li>
                                <li class="nav-item">
                                   <!-- <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false"> Edit My Profile</a>-->
                                </li>
                            </ul>
                            <!-- Tabs -->
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12"> <strong>Full Name</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['first_name'] . ' ' . $user[0]['last_name'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Username</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['username'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['phone'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Email</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['email'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>District</strong>
                                                <br>
                                                <p class="text-muted">' . $loc['district'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>User Category</strong>
                                                <br>
                                                <p class="text-muted">' . $cat . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Gender</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['gender'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Job Title</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['job_title'] . '</p>
                                            </div>
                                              <div class="col-md-12"> <strong>Education</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['education'] . '</p>
                                            </div>
                                             <div class="col-md-12"> <strong>Working Experience</strong>
                                                <br>
                                                <p class="text-muted">' . $year_working . ' years</p>
                                            </div>
                                             <div class="col-md-12"> <strong>Working Experience with MAAIF</strong>
                                                <br>
                                                <p class="text-muted">' . $year_maaif . ' years</p>
                                            </div>
                                        </div>
                                      
                                        
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material" action="" method="POST">
                                            <div class="form-group">
                                                <label class="col-md-12">First Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="firstname" value="' . $user[0]['first_name'] . ' " class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Last Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="lastname" value="' . $user[0]['last_name'] . ' " class="form-control form-control-line">
                                                </div>
                                            </div>
                                                 <div class="form-group">
                                                <label class="col-md-12">Username</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="username" value="' . $user[0]['username'] . ' " class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input type="email" name="email" value="' . $user[0]['email'] . ' " class="form-control form-control-line" name="example-email" id="example-email">
                                                </div>
                                            </div>
                                         
                                            <div class="form-group">
                                                <label class="col-md-12">Phone No</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="phone" value="' . $user[0]['phone'] . '" class="form-control form-control-line">
                                                </div>
                                            </div>
                                               <div class="form-group">
                                                <label class="col-md-12">Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" name="password" placeholder="password" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-12">Gender</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line" name="gender">
                                                        <option>Select Gender</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                             
                                            <div class="form-group">
                                                <label class="col-sm-12">Education</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line" name="education">
                                                        <option value="None">None</option>
                                                        <option value="Primary">Primary</option>
                                                        <option value="Secondary">Secondary</option>
                                                        <option value="Tertiary">Tertiary</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-sm-12">Year Started Working</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line" name="year_working">
                                                        <option value="2018">2018</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2009">2009</option>
                                                        <option value="2008">2008</option>
                                                        <option value="2007">2007</option>
                                                        <option value="2006">2006</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2004">2004</option>
                                                        <option value="2003">2003</option>
                                                        <option value="2002">2002</option>
                                                        <option value="2001">2001</option>
                                                        <option value="2000">2000</option>
                                                        <option value="1999">1999</option>
                                                        <option value="1998">1998</option>
                                                        <option value="1997">1997</option>
                                                        <option value="1996">1996</option>
                                                        <option value="1995">1995</option>
                                                        <option value="1994">1994</option>
                                                        <option value="1993">1993</option>
                                                        <option value="1992">1992</option>
                                                        <option value="1991">1991</option>
                                                        <option value="1990">1990</option>
                                                        <option value="1989">1989</option>
                                                        <option value="1988">1988</option>
                                                        <option value="1987">1987</option>
                                                        <option value="1986">1986</option>
                                                        <option value="1985">1985</option>
                                                        <option value="1984">1984</option>
                                                        <option value="1983">1983</option>
                                                        <option value="1982">1982</option>
                                                        <option value="1981">1981</option>
                                                        <option value="1980">1980</option>
                                                        <option value="1979">1979</option>
                                                        <option value="1978">1978</option>
                                                        <option value="1977">1977</option>
                                                        <option value="1976">1976</option>
                                                        <option value="1975">1975</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1971">1971</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1960">1960</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="form-group">
                                                <label class="col-md-12">Job Title</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="' . $user[0]['job_title'] . '"  name="job_title" class="form-control form-control-line">
                                                </div>
                                            </div>
                                                     
                                            <div class="form-group">
                                                <label class="col-sm-12">Year Working With MAAIF</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line" name="year_maaif">
                                                        <option value="2018">2018</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2009">2009</option>
                                                        <option value="2008">2008</option>
                                                        <option value="2007">2007</option>
                                                        <option value="2006">2006</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2004">2004</option>
                                                        <option value="2003">2003</option>
                                                        <option value="2002">2002</option>
                                                        <option value="2001">2001</option>
                                                        <option value="2000">2000</option>
                                                        <option value="1999">1999</option>
                                                        <option value="1998">1998</option>
                                                        <option value="1997">1997</option>
                                                        <option value="1996">1996</option>
                                                        <option value="1995">1995</option>
                                                        <option value="1994">1994</option>
                                                        <option value="1993">1993</option>
                                                        <option value="1992">1992</option>
                                                        <option value="1991">1991</option>
                                                        <option value="1990">1990</option>
                                                        <option value="1989">1989</option>
                                                        <option value="1988">1988</option>
                                                        <option value="1987">1987</option>
                                                        <option value="1986">1986</option>
                                                        <option value="1985">1985</option>
                                                        <option value="1984">1984</option>
                                                        <option value="1983">1983</option>
                                                        <option value="1982">1982</option>
                                                        <option value="1981">1981</option>
                                                        <option value="1980">1980</option>
                                                        <option value="1979">1979</option>
                                                        <option value="1978">1978</option>
                                                        <option value="1977">1977</option>
                                                        <option value="1976">1976</option>
                                                        <option value="1975">1975</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1971">1971</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1960">1960</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="hidden" name="action" value="editMyProfile" />
                                                    <button class="btn btn-success" type="submit">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
           
        
        ';


        return $content;
    }




    public static function viewUserProfile($id)
    {



        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);




        if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4 || $_SESSION['user']['user_category_id'] == 10 ||  $_SESSION['user']['user_category_id'] == 6) {

            $addd_btn2 = '    <li class="nav-item">
                                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Update User Profile</a>
                                </li>
                                             ';
        } else {

            $addd_btn2  = '';
        }

        $content = '
        
       
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                   
                                ' . self::userCardView($loc, $user, $cat) . '  
                                
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                          
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tabs -->
                            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                               
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
                                </li>
                               ' . $addd_btn2 . '
                            </ul>
                            <!-- Tabs -->
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12"> <strong>Full Name</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['first_name'] . ' ' . $user[0]['last_name'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Username</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['username'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['phone'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Email</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['email'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>District</strong>
                                                <br>
                                                <p class="text-muted">' . $loc['district'] . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>User Category</strong>
                                                <br>
                                                <p class="text-muted">' . $cat . '</p>
                                            </div>
                                            <div class="col-md-12"> <strong>Gender</strong>
                                                <br>
                                                <p class="text-muted">' . $user[0]['gender'] . '</p>
                                            </div>
                                            
                                        </div>
                                      
                                        
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material" action="" method="POST">
                                            <div class="form-group">
                                                <label class="col-md-12">First Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="firstname" value="' . trim($user[0]['first_name']) . ' " class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Last Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="lastname" value="' . trim($user[0]['last_name']) . ' " class="form-control form-control-line">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-12">Username</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="username" value="' . trim($user[0]['username']) . ' " class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input type="email" name="email" value="' . trim($user[0]['email']) . ' " class="form-control form-control-line" name="example-email" id="example-email">
                                                </div>
                                            </div>
                                         
                                            <div class="form-group">
                                                <label class="col-md-12">Phone No</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="phone" value="' . trim($user[0]['phone']) . '" class="form-control form-control-line">
                                                </div>
                                            </div>
                                               <div class="form-group">
                                                <label class="col-md-12">Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" name="password" placeholder="password" class="form-control form-control-line">
                                                </div>
                                            </div>
                                               
                                            
                                            <div class="form-group">
                                                <label class="col-sm-12">Gender</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line" name="gender">
                                                        <option>Select Gender</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                        
                                            
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="hidden" name="action" value="editUserProfile" />
                                                    <input type="hidden" name="id" value="' . $_REQUEST['id'] . '" />
                                                    <button class="btn btn-success" type="submit">Update User Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
           
        
        ';


        return $content;
    }


    public static function  getUserAnnualObjectives($id)
    {

        $content = '<tr>
                        <td>1.</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                    </tr>';
        $sql = database::performQuery(" SELECT * FROM `ext_objectives_annual` WHERE user_id=$id ORDER BY year DESC");
        if ($sql->num_rows > 0) {

            $content = '';
            $x = 1;
            while ($data = $sql->fetch_assoc()) {



                if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

                    $addd_btn2 = '    <td><a href="' . ROOT . '/?action=deleteUserObjective&id=' . $data['id'] . '">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"><i class="fas fa-times"></i> Delete</button></a> 
                                                </td>
                                             ';
                } else {

                    $addd_btn2  = '';
                }

                $content .= '<tr>
                          <td scope="row">' . $x . '</td>
                          <td>' . $data['year'] . '</td>
                          <td>' . $data['objective'] . '</td>
                          ' . $addd_btn2 . '
                           

                          </tr>';

                $x++;
            }
        }


        return $content;
    }


    public static function  getUserWorkplan($id)
    {

        $content = '<tr>
                        <td>1.</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        
                    </tr>';
        $sql = database::performQuery(" SELECT * FROM ext_area_annual_outputs WHERE user_id=$id AND DATE(created) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]' AND year='$_SESSION[financial_year]' ORDER BY id ASC");
        if ($sql->num_rows > 0) {


            $content = '';
            $x = 1;
            while ($data = $sql->fetch_assoc()) {






                if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

                    $addd_btn2 = '    <td><a href="' . ROOT . '/?action=deleteUserWorkplan&id=' . $data['id'] . '" title="Delete User Workplan" class="text-danger"><i class="fas fa-trash"></i></a> 
                                    &nbsp;&nbsp;
                                    <a href="' . ROOT . '/?action=editUserWorkplan&id=' . $data['id'] . '" title="Edit User Workpplan" class="text-info"><i class="fas fa-pencil-alt"></i></a> 
                                    </td>
                                
                                             ';
                } else if ($_SESSION['user']['user_category_id'] == 10 && $_SESSION['user']['id'] == $data['user_id']) {
                    $addd_btn2 = '    <td><a href="' . ROOT . '/?action=deleteUserWorkplan&id=' . $data['id'] . '" title="Delete User Workplan" class="text-danger"><i class="fas fa-trash"></i></a> 
                        &nbsp;&nbsp;
                        <a href="' . ROOT . '/?action=editUserWorkplan&id=' . $data['id'] . '" title="Edit User Workpplan" class="text-info"><i class="fas fa-pencil-alt"></i></a> 
                        </td>
                    
                                    ';
                } else {

                    $addd_btn2  = '';
                }
                $activity = '<ol>';
                $activities = array_unique(explode(',', $data['activities']));
                //print_r($activities);
                foreach ($activities as $activityz) {
                    $activity .= '<small><li>' . self::getActivityName($activityz) . '</li></small>';
                }
                $activity .= '</ol>';


                $content .= '<tr>
                          <td>' . $data['year'] . '</td>
                          <td style="font-size:11px">' . $data['key_output'] . '</td>
                          <td>' . $activity . '</td>
                          <td style="font-size:11px">' . stripslashes($data['indicators']) . '</td>
                          <td>' . str_replace('rn', ' &nbsp;<br />', stripcslashes(stripslashes($data['target']))) . '</td>
                          <td>' . number_format($data['budget']) . '</td>
                          ' . $addd_btn2 . '
                          </tr>';

                $x++;
            }
        }


        return $content;
    }

    public static function  getUserQuarterlyActivities($id)
    {

        $content = '<tr>
                      <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
                        
                    </tr>';
        $sql = database::performQuery("SELECT * FROM `ext_area_quaterly_activity` WHERE user_id=$id ORDER BY  id DESC,quarter DESC");
        if ($sql->num_rows > 0) {

            $content = '';
            $x = 1;
            while ($data = $sql->fetch_assoc()) {


                $addd_btn2  = '';
                if (userMgmt::checkDistrictExtensionStaffUserIDs($_SESSION['user']['user_category_id'])) {

                    $addd_btn2 = '     
                               <td>
                               <a href="' . ROOT . '/?action=editUserActivityQuarterly&id=' . $data['id'] . '&user_id=' . $_REQUEST['user_id'] . '" title="Edit Quartely Activity" class="text-info"><i class="fas fa-pencil-alt"></i></a>        
                              
                              <a href="' . ROOT . '/?action=deleteUserActivityQuarterly&id=' . $data['id'] . '&user_id=' . $_REQUEST['user_id'] . '">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"><i class="fas fa-times"></i> Delete</button></a> 
                                &nbsp;&nbsp;
                               </td>                
                                ';
                }


                $content .= '
        
                        <tr>
                            <td> ' . $x . '</td>
                             <td>' . content::getActivityName($data['annual_id'])['name'] . '<br />
                              <b style="font-size:10px">Topics</b>
                          <ul style="font-size:12px">                          
                          ' . self::getTopicsListed($data['topic']) . '
                             
                             </td>
                              <td> <ul style="font-size:12px">                          
                          ' . self::getEntListed($data['entreprizes']) . '
                          </ul></td>
                              <td> ' . $data['num_planned'] . '</td>
                               <td> ' . $data['num_target_ben'] . '</td>
                               <td> Q' . $data['quarter'] . '</td>
                               <td> ' . number_format($data['budget']) . '/=</td>
                               <td>' . $addd_btn2 . '</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }


        return $content;
    }

    public static function  getUserAnnualActivitiesAdmin($id)
    {

        $content = '<tr>
                        <td>1.</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                    </tr>';
        $sql = database::performQuery(" SELECT * FROM ext_area_annual_activity WHERE user_id=$id ORDER BY year DESC, id DESC");
        if ($sql->num_rows > 0) {

            $content = '';
            $x = 1;
            while ($data = $sql->fetch_assoc()) {


                $addd_btn2  = '';
                if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

                    $addd_btn2 = '   <td><a href="' . ROOT . '/?action=deleteUserActivity&id=' . $data['id'] . '">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"><i class="fas fa-times"></i> Delete</button></a> 
                                                </td>';
                }

                $content .= '<tr>
                          <td scope="row">' . $x . '</td>
                          <td>' . $data['year'] . '</td>
                          <td>' . self::getActivity($data['activity'])['name'] . '</td>
                          <td>' . $data['num_planned'] . '</td>
                          <td>' . $data['num_target_ben'] . '</td>
                          
                           ' . $addd_btn2 . '

                          </tr>';

                $x++;
            }
        }


        return $content;
    }


    public static function getActivityId($id)
    {
        $sql = database::performQuery("SELECT activity  FROM ext_area_annual_activity WHERE id=$id");

        $sql = $sql->fetch_assoc();

        return $sql['activity'];
    }




    public static function getTopicsListed($ids)
    {
        $content = '';

        $sql = database::performQuery("SELECT * FROM ext_topics WHERE id IN ($ids)");
        while ($data = $sql->fetch_assoc()) {

            $content .= "<li><small>$data[name]</small></li>";
        }

        return $content;
    }



    public static function getEntListed($ids)
    {
        $content = '';

        $sql = database::performQuery("SELECT * FROM km_category WHERE id IN ($ids)");
        while ($data = $sql->fetch_assoc()) {

            $content .= "<li><small>$data[name]</small></li>";
        }

        return $content;
    }

    public static function  getUserQuarterlyActivitiesAdmin($id)
    {

        $content = '<tr>
                        <td>1.</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                    </tr>';
        $sql = database::performQuery(" SELECT ext_area_quaterly_activity.budget,year,quarter,annual_id,topic,entreprizes,num_planned,num_target_ben,ext_area_quaterly_activity.id FROM ext_area_quaterly_activity,ext_area_annual_outputs WHERE ext_area_quaterly_activity.key_output_id  = ext_area_annual_outputs.id AND  ext_area_quaterly_activity.user_id=$id AND quarter = $_SESSION[quarter] AND year='$_SESSION[financial_year]' ORDER BY  ext_area_quaterly_activity.id ASC");
        if ($sql->num_rows > 0) {

            $content = '';
            $x = 1;
            while ($data = $sql->fetch_assoc()) {



                $addd_btn2  = '';
                if (userMgmt::checkDistrictExtensionStaffUserIDs($_SESSION['user']['user_category_id'])) {

                    $addd_btn2 = '     
                               <td>
                               <a href="' . ROOT . '/?action=editUserActivityQuarterly&id=' . $data['id'] . '&user_id=' . $_REQUEST['id'] . '" title="Edit Quartely Activity" class="text-info"><i class="fas fa-pencil-alt"></i></a>        
                              
                              <a href="' . ROOT . '/?action=deleteUserActivityQuarterly&id=' . $data['id'] . '&user_id=' . $_REQUEST['id'] . '">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"><i class="fas fa-times"></i> Delete</button></a> 
                                &nbsp;&nbsp;
                               </td>                
                                ';
                }

                $content .= '<tr>
                          <td scope="row">' . $x . '</td>
                          <td>' . $data['year'] . '</td>
                          <td>' . $data['quarter'] . '</td>
                          <td>' . number_format($data['budget']) . '/=</td>
                          <td>' . self::getActivityName($data['annual_id']) . '
                        <br />  <b style="font-size:10px">Topics</b>
                          <ul style="font-size:12px">                          
                          ' . self::getTopicsListed($data['topic']) . '
                          </ul></td>
                          <td>
                          <ul style="font-size:12px">                          
                          ' . self::getEntListed($data['entreprizes']) . '
                          </ul>                          
                          </td>
                          <td>' . $data['num_planned'] . '</td>
                          <td>' . $data['num_target_ben'] . '</td>
                         
                           ' . $addd_btn2 . '

                          </tr>';

                $x++;
            }
        }


        return $content;
    }


    public static function viewUserObjectives($id)
    {



        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);


        $addd_btn2  = '';
        if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

            $addd_btn2 = '     
                                  <a href="' . ROOT . '/?action=addAnnualObjectives&id=' . $id . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Outputs</button></a>
                                             
                               
                                             ';
        }

        $content = '
        
       
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                  ' . self::userCardView($loc, $user, $cat) . '  
                                <br />
                               
                               
                               ' . $addd_btn2 . '
                               
                               
                                   
                                </center>
                            </div>
                            <div>
                               </div>
                          
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tabs -->
                         
                         
                         
                        
                       <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Year</th>
                                            <th scope="col">Objecive</th>
                                            <th scope="col">Action</th>
                                           </tr>
                                    </thead>
                                    <tbody>
                               
                                       ' . self::getUserAnnualObjectives($id) . '
                                     
                                    </tbody>
                                </table>
                            </div>
                        
                        
                        
                         </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
           
        
        ';


        return $content;
    }



    public static function annualWorkplanDateFilter()
    {
        return '<div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Filter Date Range for Workplan</h4>
                            <form class="m-t-30" action="#">
<table class="table table-bordered table-condensed">
<tr>
<td>

<div class="form-group">
                                                    <label class="control-label">Financial Year</label>
                                                    
                                                    <select class="form-control custom-select" name="year" required>
                                                        <option value="2018/2019">2018/2019</option>
                                                        <option value="2019/2020">2019/2020</option>
                                                        <option value="2020/2021">2020/2021</option>
                                                        <option value="2021/2022">2021/2022</option>
                                                        <option value="2022/2023" SELECTED>2022/2023</option>
                                                        <option value="2023/2024">2023/2024</option>
                                                        <option value="2024/2025">2024/2025</option>
                                                        <option value="2025/2026">2025/2026</option>
                                                        <option value="2026/2027">2026/2027</option>
                                                        <option value="2027/2028">2027/2028</option>
                                                        <option value="2028/2029">2028/2029</option>
                                                        <option value="2029/2030">2029/2030</option>
                                                        <option value="2030/2031">2030/2031</option>
                                                       
                                                    </select>
                                                    
                                                     </div>

</td>
<td>        <div class="form-group">
                                        <label>Filter start date</label>
                                        <input type="date" class="form-control" name="date_from" value="' . $_SESSION['date_from'] . '" required>
                                    </div>
                                    
                       
                        </td>
                        <td> <div class="form-group">
                                        <label>Filter end date</label>
                                        <input type="date" class="form-control" name="date_to" value="' . $_SESSION['date_to'] . '" required>
                                    </div></td>
                                    
                                     <td> <div class="form-group">
                                      <label>&nbsp;</label><br />
                                      <input type="hidden" name="action" value="setSessionDatesYear" />
                                       <button type="submit" class="btn waves-effect waves-light btn-rounded btn-info">Filter</button>
                                    </div></td>
                                    <td>
                                    <br />
                                     <button type="button" onclick="window.print()" class="btn waves-effect waves-light btn-rounded  btn-success">Print Workplan</button>
          
                                    </td>
                            
                        </div>
                    </div>';
    }

    public static function quarterlyActivitesDateFilter()
    {
        return '<div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Filter Date Range for Quarterly Actvities</h4>
                            <form class="m-t-30" action="#">
<table class="table table-bordered table-condensed">
<tr>
<td>

<div class="form-group">
                                                    <label class="control-label">Financial Year</label>
                                                    
                                                    <select class="form-control custom-select" name="year" required>
                                                        <option value="2018/2019">2018/2019</option>
                                                        <option value="2019/2020">2019/2020</option>
                                                        <option value="2020/2021">2020/2021</option>
                                                        <option value="2021/2022">2021/2022</option>
                                                        <option value="2022/2023" SELECTED>2022/2023</option>
                                                        <option value="2023/2024">2023/2024</option>
                                                        <option value="2024/2025">2024/2025</option>
                                                        <option value="2025/2026">2025/2026</option>
                                                        <option value="2026/2027">2026/2027</option>
                                                        <option value="2027/2028">2027/2028</option>
                                                        <option value="2028/2029">2028/2029</option>
                                                        <option value="2029/2030">2029/2030</option>
                                                        <option value="2030/2031">2030/2031</option>
                                                       
                                                    </select>
                                                    
                                                     </div>

</td>
<td>

<div class="form-group">
                                                    <label class="control-label">Quarter</label>
                                                    
                                                    <select class="form-control custom-select" name="quarter" required>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                     
                                                       
                                                    </select>
                                                    
                                                     </div>

</td>

                        
                                    
                                     <td> <div class="form-group">
                                      <label>&nbsp;</label><br />
                                      <input type="hidden" name="action" value="setSessionYearQuarter" />
                                       <button type="submit" class="btn waves-effect waves-light btn-rounded btn-info">Filter</button>
                                    </div></td>
                                    <td>
                                    <br />
                                     <button type="button" onclick="window.print()" class="btn waves-effect waves-light btn-rounded  btn-success">Print Quarterly Workplan</button>
          
                                    </td>
                                    </tr>
                                    </table>
                            
                        </div>
                    </div>';
    }

    public static function dailyActivitesDateFilter()
    {
        return '<div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Filter Date Range for Daily Actvities</h4>
                            <form class="m-t-30" action="#">
<table class="table table-bordered table-condensed">
<tr>
<td>        <div class="form-group">
                                        <label>Choose start date</label>
                                        <input type="date" class="form-control" name="date_from" value="' . $_SESSION['date_from'] . '" required>
                                    </div>
                                    
                       
                        </td>
                        <td> <div class="form-group">
                                        <label>Choose end date</label>
                                        <input type="date" class="form-control" name="date_to" value="' . $_SESSION['date_to'] . '" required>
                                    </div></td>
                                    
                                     <td> <div class="form-group">
                                      <label>&nbsp;</label><br />
                                      <input type="hidden" name="action" value="setSessionDates" />
                                       <button type="submit" class="btn waves-effect waves-light btn-rounded btn-info">Filter</button>
                                    </div></td>
                                    <td>
                                    <br />
                                     <button type="button" onclick="window.print()" class="btn waves-effect waves-light btn-rounded  btn-success">Print Daily Activities</button>
          
                                    </td>
                            
                        </div>
                    </div>';
    }

    public static function evaluationDateFilter()
    {
        return '<div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Filter Date Range for Evaluation</h4>
                            <form class="m-t-30" action="#">
<table class="table table-bordered table-condensed">
<tr>
<td>        <div class="form-group">
                                        <label>Choose start date</label>
                                        <input type="date" class="form-control" name="date_from" value="' . $_SESSION['date_from'] . '" required>
                                    </div>
                                    
                       
                        </td>
                        <td> <div class="form-group">
                                        <label>Choose end date</label>
                                        <input type="date" class="form-control" name="date_to" value="' . $_SESSION['date_to'] . '" required>
                                    </div></td>
                                    
                                     <td> <div class="form-group">
                                      <label>&nbsp;</label><br />
                                      <input type="hidden" name="action" value="setSessionDates" />
                                       <button type="submit" class="btn waves-effect waves-light btn-rounded btn-info">Filter</button>
                                    </div></td>
                                    <td>
                                    <br />
                                     <button type="button" onclick="window.print()" class="btn waves-effect waves-light btn-rounded  btn-success">Print Evaluation Report</button>
          
                                    </td>
                            
                        </div>
                    </div>';
    }

    public static function userCardView($loc, $user, $cat)
    {

        if (userMgmt::checkSubcountyExtensionStaffUserIDs($user[0]['user_category_id'])) {
            $content = '<center class="m-t-30"> <img src="' . ROOT . '/images/users/' . $user[0]['photo'] . '" class="rounded-circle" width="150" />
                                    <h3 class="card-title m-t-10">' . $user[0]['first_name'] . ' ' . $user[0]['last_name'] . '</h3>
                                    <h4 class="card-subtitle" style="color:#000">' . $cat . '</h4>
                                    <h5 class="card-subtitle" style="color:#000">' . $loc['district'] . ' / <small>' . $loc['subcounty'] . '</small></h5>';

            return $content;
        } else if (userMgmt::checkDistrictExtensionStaffUserIDs($user[0]['user_category_id'])) {
            $content = '<center class="m-t-30"> <img src="' . ROOT . '/images/users/' . $user[0]['photo'] . '" class="rounded-circle" width="150" />
                                    <h3 class="card-title m-t-10">' . $user[0]['first_name'] . ' ' . $user[0]['last_name'] . '</h3>
                                    <h4 class="card-subtitle" style="color:#000">' . $cat . '</h4>
                                    <h5 class="card-subtitle" style="color:#000">' . user::getUserDistrict($user[0]['district_id']) . ' DISTRICT</h5>';

            return $content;
        } else if (userMgmt::checkZonalExtensionStaffUserIDs($user[0]['user_category_id'])) {
            $content = '<center class="m-t-30"> <img src="' . ROOT . '/images/users/' . $user[0]['photo'] . '" class="rounded-circle" width="150" />
                                    <h3 class="card-title m-t-10">' . $user[0]['first_name'] . ' ' . $user[0]['last_name'] . '</h3>
                                    <h4 class="card-subtitle" style="color:#000">' . $cat . '</h4>
                                    <h5 class="card-subtitle" style="color:#000">ZONAL HEAD QUARTERS</h5>';

            return $content;
        } else if (userMgmt::checkNationalStaffUserIDs($user[0]['user_category_id'])) {
            $content = '<center class="m-t-30"> <img src="' . ROOT . '/images/users/' . $user[0]['photo'] . '" class="rounded-circle" width="150" />
                                    <h3 class="card-title m-t-10">' . $user[0]['first_name'] . ' ' . $user[0]['last_name'] . '</h3>
                                    <h4 class="card-subtitle" style="color:#000">' . $cat . '</h4>
                                    <h5 class="card-subtitle" style="color:#000">MAAIF HEAD QUARTERS</h5>';

            return $content;
        }
    }
    public static function viewUserWorkplan($id)
    {



        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);



        if ($_SESSION['user']['user_category_id'] == 55 || $_SESSION['user']['user_category_id'] == 56 || $_SESSION['user']['user_category_id'] == 57  || $_SESSION['user']['user_category_id'] == 58 || $_SESSION['user']['user_category_id'] == 59 ||  $_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4 || $_SESSION['user']['user_category_id'] == 12 || $_SESSION['user']['user_category_id'] == 10) {

            $addd_btn2 = '     <a href="' . ROOT . '/?action=addNewWorkplan&id=' . $id . '"> <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Output</button></a>
                                               
                                
                                             ';
        } else {

            $addd_btn2  = '';
        }


        $content = '
        
       
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
              
               <div class="row">
                    <!-- Column -->
                    <div class="col-lg-2 col-xlg-2 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                 ' . self::userCardView($loc, $user, $cat) . '
                                 <br />                     
                                 ' . $addd_btn2 . '
                                </center>
                            </div>
                       
                          
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-10 col-xlg-10 col-md-10">
                        <div class="card">
                            <!-- Tabs -->
                         
                           <div class="row">
                
                
                ' . self::annualWorkplanDateFilter() . '
                
               </div>
                         
                        
                       <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Year</th>
                                            <th scope="col">Output</th>
                                            <th scope="col">Planned Activities</th>                                            
                                            <th scope="col">Indicator</th>
                                            <th scope="col">Target</th>
                                            <th scope="col">Budget</th>                                            
                                            <th scope="col">Action</th>
                                           </tr>
                                    </thead>
                                    <tbody>
                               
                                       ' . self::getUserWorkplan($id) . '
                                     
                                    </tbody>
                                </table>
                            </div>
                        
                        
                        
                         </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
           
        
        ';


        return $content;
    }


    public static function viewUserQuaterlyAcitivitiesNew($id)
    {



        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);



        if ($_SESSION['user']['user_category_id'] == 12 || $_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4 || $_SESSION['user']['user_category_id'] == 10) {

            $addd_btn2 = '     <a href="' . ROOT . '/?action=processEditQuarterlyActivities&user_id=' . $_SESSION['user']['id'] . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Activities</button></a>             
                                
                                             ';
        } else {

            $addd_btn2  = '';
        }






        $content = '
        
       
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-2 col-xlg-2 col-md-2">
                        <div class="card">
                            <div class="card-body">
                               
                               ' . self::userCardView($loc, $user, $cat) . '  
                                <br />                                
                                ' . $addd_btn2 . '
                                </center>
                            </div>
                       
                          
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-10 col-xlg-10 col-md-10">
                        <div class="card">
                            <!-- Tabs -->
                         
                        
                           <div class="row">
                
                
                ' . self::quarterlyActivitesDateFilter() . '
                
               </div>
                       <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                                                                    <th> Activity& Topics</th>
                                                                                    <th> Entreprize(s)</th>
                                                                                    <th> Planned No.</th>
                                                                                    <th> Beneficiaries</th>
                                                                                    <th>Quarter</th>
                                                                                    <th>Budget</th>
                                           </tr>
                                    </thead>
                                    <tbody>
                               
                                       ' . self::getUserQuarterlyActivities($id) . '
                                     
                                    </tbody>
                                </table>
                            </div>
                        
                        
                        
                         </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
        ';
        return $content;
    }


    public static function viewAnnualActivities($id)
    {



        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);



        $addd_btn2  = '';
        if ($_SESSION['user']['user_category_id'] == 2 || $_SESSION['user']['user_category_id'] == 3 || $_SESSION['user']['user_category_id'] == 4) {

            $addd_btn2 = '      <a href="' . ROOT . '/?action=manageAnnualActivities&id=' . $id . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Activities</button></a>
                              ';
        }

        $content = '
        
       
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                  
                                ' . self::userCardView($loc, $user, $cat) . '  
                                <br />
                                                
                                ' . $addd_btn2 . '
                                </center>
                            </div>
                          
                          
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tabs -->
                         
                         
                         
                        
                       <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Year</th>
                                            <th scope="col">Activity</th>
                                            <th scope="col">Planned</th>
                                            <th scope="col">Beneficiaries</th>
                                            <th scope="col">Action</th>
                                           </tr>
                                    </thead>
                                    <tbody>
                               
                                       ' . self::getUserAnnualActivitiesAdmin($id) . '
                                     
                                    </tbody>
                                </table>
                            </div>
                       
                        
                        
                         </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
           
        
        ';


        return $content;
    }


    public static function viewQuarterlyActivities($id)
    {



        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);


        $addd_btn2  = '';
        if (userMgmt::checkDistrictExtensionStaffUserIDs($_SESSION['user']['user_category_id'])) {

            $addd_btn2 = '     
                                 <a href="' . ROOT . '/?action=processEditQuarterlyActivities&user_id=' . $id . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"> <i class="fas fa-plus"></i> Add New Quarterly Activities</button></a>
                                 
                                 <br />
                                 <br />
                                 <a href="' . ROOT . '/?action=processSubmitQuarterlyActivities&user_id=' . $id . '"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-warning"> <i class="fas fa-check"></i> Submit Approved Quarterly actvities</button></a>
                                               
                                ';
        }

        $content = '
        
       
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                   ' . self::userCardView($loc, $user, $cat) . '  
                                <br />
                                
                                ' . $addd_btn2 . '
                                
                                 
                                
                                </center>
                            </div>
                          
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-9 col-xlg-9 col-md-9">
                        <div class="card">
                            <!-- Tabs -->
                         
                         
                           <div class="row">
                
                
                ' . self::quarterlyActivitesDateFilter() . '
                
               </div>
                         
                        
                       <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">FY</th>
                                            <th scope="col">Quarter</th>
                                            <th scope="col">Budget</th>
                                            <th scope="col">Activity/Topics</th>
                                            <th scope="col">Entreprizes</th>
                                            <th scope="col">Planned</th>
                                            <th scope="col">Beneficiaries</th>
                                            <th scope="col">Action</th>
                                           </tr>
                                    </thead>
                                    <tbody>
                               
                                       ' . self::getUserQuarterlyActivitiesAdmin($id) . '
                                     
                                    </tbody>
                                </table>
                            </div>
                       
                        
                        
                         </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
           
        
        ';


        return $content;
    }



    public static function countAllUserActtivities()
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT * FROM `ext_area_quaterly_activity` where user_id=$id");
        return $sql->num_rows;
    }

    public static function countAllWomen()
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_females) as women FROM `ext_area_daily_activity` where user_id=$id");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMen()
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_males) as women FROM `ext_area_daily_activity` where user_id=$id");
        return $sql->fetch_assoc()['women'];
    }

    public static function countAllMenWomen()
    {
        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_total) as women FROM `ext_area_daily_activity` where user_id=$id");
        return $sql->fetch_assoc()['women'];
    }
    public static function countAllObjectives()
    {

        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT * FROM `ext_objectives_annual` where user_id=$id");
        return $sql->num_rows;
    }
    public static function countAllUserBeneficiaries()
    {

        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(num_ben_total) FROM ext_area_daily_activity where user_id=$id");
        return $sql->num_rows;
    }
    public static function countAllUserGroups()
    {

        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT SUM(ben_group) as tot FROM ext_area_daily_activity where user_id=$id");
        return $sql->fetch_assoc()['tot'];
    }
    public static function latestActivities()
    {
    }
    public static function sendFeedback()
    {

        $content = '';


        return $content;
    }


    public static function deleteUserProfile($id)
    {

        $sql = database::performQuery("DELETE FROM user WHERE id =$id");


        redirect_to($_SERVER['HTTP_REFERER']);
    }


    public static function deleteUserKMU($id)
    {

        $sql = database::performQuery("DELETE FROM `kmu_has_km_category` WHERE kmu_id =$id");
        $sqlb = database::performQuery("DELETE FROM kmu WHERE id =$id");


        redirect_to(ROOT . '/?action=manageKMU');
    }



    public static function deleteUserObjective($id)
    {

        $sql = database::performQuery("DELETE FROM ext_objectives_annual WHERE id =$id");

        $ref  = $_SERVER['HTTP_REFERER'];

        redirect_to($ref);
    }


    public static function deleteUserWorkplan($id)
    {

        $sql = database::performQuery("DELETE FROM ext_area_annual_outputs WHERE id =$id");

        $ref  = $_SERVER['HTTP_REFERER'];

        redirect_to($ref);
    }

    public static function deleteUserActivity($id)
    {

        $sql = database::performQuery("DELETE FROM ext_area_annual_activity WHERE id =$id");

        $ref  = $_SERVER['HTTP_REFERER'];

        redirect_to($ref);
    }


    public static function deleteDailyActivity($id)
    {

        $sql = database::performQuery("DELETE FROM ext_area_daily_activity WHERE id =$id");

        $ref  = $_SERVER['HTTP_REFERER'];

        redirect_to($ref);
    }


    public static function deleteUserActivityQuarterly($id, $user)
    {

        $sql = database::performQuery("DELETE FROM ext_area_quaterly_activity WHERE id =$id");

        // echo 'Deleted '.$id;
        //  $ref  = $_SERVER['HTTP_REFERER'];

        redirect_to(ROOT . '/?action=viewQuarterlyActivities&id=' . $user);
    }


    public static function feedbackInbox()
    {
        $content = '
        
         <!-- ============================================================== -->
            <div class="email-app">
                ' . self::feedbackMenu() . '
                </div>
                
                
                 <div class="right-part mail-list bg-white">
                 
                 ' . self::feedbackCheckMail() . '
                 
                 </div>             
                
               
                
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
        
        ';

        return $content;
    }



    public static function feedbackNewMail()
    {
        $content = '
        
         <!-- ============================================================== -->
            <div class="email-app">
                ' . self::feedbackMenu() . '
                </div>
                
                 
                     <!-- ============================================================== -->
                <!-- Right Part  Mail Compose -->
                <!-- ============================================================== -->
                <div class="right-part mail-compose bg-white" >
                    <div class="p-20 border-bottom">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4>Compose</h4>
                                <span>create new message</span>
                            </div>
                           
                        </div>
                    </div>
                    <!-- Action part -->
                    <!-- Button group part -->
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                
                                <h4>Send To</h4>
                                   <select class="select2 form-control" name="users[]" multiple="multiple" style="height: 36px;width: 100%;">
                                   
                                    ' . self::sendToSelector() . '
                                </select>                               
                                
                            </div>
                            <div class="form-group">
                              <h4>Subject</h4>
                                <input type="text" id="example-subject" name="subject" class="form-control" placeholder="Subject here">
                            </div>
                              <h4>Message</h4>
                            <textarea class="form-control" rows="5" name="msg" placeholder=""> </textarea>
                             <input type="hidden" name="action" value="processMsg" />
                            <button type="submit" class="btn btn-success m-t-20"><i class="far fa-envelope"></i> Send</button>
                            
                        </form>
                        <!-- Action part -->
                    </div>
                </div>
        
                 
       
                
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
        
        ';

        return $content;
    }




    public static function feedbackSentMail()
    {
        $content = '
        
         <!-- ============================================================== -->
            <div class="email-app">
                ' . self::feedbackMenu() . '
                </div>
                
                
                  <div class="right-part mail-compose bg-white">
                   
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table email-table no-wrap table-hover v-middle">
                                        <thead>
                                            <tr>
                                                <th width="10%">&nbsp;</th>                                                
                                                
                                                                                         
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        
                                        
               
                                        
                                            ' . self::getUserFeedbackSent() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                  <th>&nbsp;</th>                                                
                                              
                                                             
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
                
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
        
        ';

        return $content;
    }





    public static function feedbackCheckMail()
    {

        $content = '<div class="row">
                   
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table email-table no-wrap table-hover v-middle">
                                        <thead>
                                            <tr>
                                                <th width="10%">&nbsp;</th>                                                
                                                
                                                                                         
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        
                                        
               
                                        
                                            ' . self::getUserFeedbackList() . '                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                  <th>&nbsp;</th>                                                
                                              
                                                             
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



    public static function feedbackDetail()
    {

        $content = '
         <!-- ============================================================== -->
                <!-- Right Part  Mail detail -->
                <!-- ============================================================== -->
                <div class="right-part mail-details bg-white" style="display: none;">
                    <div class="card-body bg-light">
                        <button type="button" id="back_to_inbox" class="btn btn-outline-secondary font-18 m-r-10"><i class="mdi mdi-arrow-left"></i></button>
                        <div class="btn-group m-r-10" role="group" aria-label="Button group with nested dropdown">
                            <button type="button" class="btn btn-outline-secondary font-18"><i class="mdi mdi-reply"></i></button>
                            <button type="button" class="btn btn-outline-secondary font-18"><i class="mdi mdi-alert-octagon"></i></button>
                            <button type="button" class="btn btn-outline-secondary font-18"><i class="mdi mdi-delete"></i></button>
                        </div>
                        <div class="btn-group m-r-10" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-folder font-18 "></i> </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"> <a class="dropdown-item" href="javascript:void(0)">Dropdown link</a> <a class="dropdown-item" href="javascript:void(0)">Dropdown link</a> </div>
                            </div>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-label font-18"></i> </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"> <a class="dropdown-item" href="javascript:void(0)">Dropdown link</a> <a class="dropdown-item" href="javascript:void(0)">Dropdown link</a> </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom">
                        <h4 class="m-b-0">Your Message title goes here</h4>
                    </div>
                    <div class="card-body border-bottom">
                        <div class="d-flex no-block align-items-center m-b-40">
                            <div class="m-r-10"><img src="../../assets/images/users/1.jpg" alt="user" class="rounded-circle" width="45"></div>
                            <div class="">
                                <h5 class="m-b-0 font-16 font-medium">Hanna Gover <small> ( hgover@gmail.com )</small></h5><span>to Suniljoshi19@gmail.com</span>
                            </div>
                        </div>
                        <h4 class="m-b-15">Hey Hi,</h4>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.</p>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.</p>
                    </div>
                    <div class="card-body">
                        <h4><i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments <span>(3)</span></h4>
                        <div class="row">
                            <div class="col-md-2">
                                <a href="javascript:void(0)"> <img class="img-thumbnail img-responsive" alt="attachment" src="../../assets/images/big/img1.jpg"> </a>
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:void(0)"> <img class="img-thumbnail img-responsive" alt="attachment" src="../../assets/images/big/img2.jpg"> </a>
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:void(0)"> <img class="img-thumbnail img-responsive" alt="attachment" src="../../assets/images/big/img3.jpg"> </a>
                            </div>
                        </div>
                        <div class="border m-t-20 p-15">
                            <p class="p-b-20">click here to <a href="javascript:void(0)">Reply</a> or <a href="javascript:void(0)">Forward</a></p>
                        </div>
                    </div>
                </div>
        
        ';

        return $content;
    }



    public static function feedbackMenu()
    {

        $content = '<!-- ============================================================== -->
                <!-- Left Part -->
                <!-- ============================================================== -->
                <div class="left-part">
                    <a class="ti-menu ti-close btn btn-success show-left-part d-block d-md-none" href="javascript:void(0)"></a>
                    <div class="scrollable" style="height:100%;">
                        <div class="p-15">
                            <a id="compose_mail" class="waves-effect waves-light btn btn-danger d-block" href="' . ROOT . '/?action=feedbackCompose">Compose</a>
                        </div>
                        <div class="divider"></div>
                        <ul class="list-group">
                            <li>
                                <small class="p-15 grey-text text-lighten-1 db">Folders</small>
                            </li>
                            <li class="list-group-item">
                                <a href="' . ROOT . '/?action=feedback" class=" list-group-item-action"><i class="fas fa-inbox"></i> Inbox </a>
                            </li>
                            <li class="list-group-item">
                                <a href="' . ROOT . '/?action=feedbackSent" class="list-group-item-action"> <i class="far fa-paper-plane"></i> Sent  </a>
                            </li>
                      
                            <li class="list-group-item">
                                <hr>
                            </li>
                            <li>
                                <small class="p-15 grey-text text-lighten-1 db">Labels</small>
                            </li>
                             <li class="list-group-item">
                                <a href="javascript:void(0)" class="list-group-item-action"><i class="text-success mdi mdi-checkbox-blank-circle"></i> MAAIF </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javascript:void(0)" class="list-group-item-action"><i class="text-danger mdi mdi-checkbox-blank-circle"></i> CAO </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javascript:void(0)" class="list-group-item-action"><i class="text-cyan mdi mdi-checkbox-blank-circle"></i> DPMO </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javascript:void(0)" class="list-group-item-action"><i class="text-warning mdi mdi-checkbox-blank-circle"></i> Direct Supervisor </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javascript:void(0)" class="list-group-item-action"><i class="text-info mdi mdi-checkbox-blank-circle"></i> Extension Officer </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javascript:void(0)" class="list-group-item-action"><i class=" mdi mdi-checkbox-blank-circle"></i> Sub County Chief </a>
                            </li>
                        </ul>
                    </div>';

        return $content;
    }


    public static function getUserFeedbackList()
    {
        $id = $_SESSION['user']['id'];


        $content = '';
        $content = "SELECT ext_feedback.id as fid, user.id,photo,first_name,last_name,user_category_id,title,ext_feedback.created
                   FROM user,ext_feedback
                   WHERE user.id =ext_feedback.from_user_id
                   AND to_user_id = $id
                  ORDER BY ext_feedback.id DESC
                   ";


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];
            $rt .= '<tr>
                                                <td width="20%">
                                                <div class="row">
                                                <div class="col-md-1 col-xl-1" style="display: inline">  <img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /> </div>
                                                <div class="col-md-2 col-xl-2" style="display: inline"> <b>' . $data['first_name'] . ' ' . $data['last_name'] . '</b>  </div>
                                                <div class="col-md-7 col-xl-7" style="display: inline"> ' . $data['title'] . ' </div>
                                                <div class="col-md-2 col-xl-2" style="display: inline"> ' . makeAgo($data['created'], time(), 1) . ' </td></div>
                                               
                                               
                                               
                                                </div>
                                            </tr>';
        }

        return $rt;
    }


    public static function getUserFeedbackSent()
    {
        $id = $_SESSION['user']['id'];


        $content = '';
        $content = "SELECT ext_feedback.id as fid, user.id,photo,first_name,last_name,user_category_id,title,ext_feedback.created
                   FROM user,ext_feedback
                   WHERE user.id =ext_feedback.to_user_id
                   AND from_user_id = $id
                  ORDER BY ext_feedback.created DESC
                   ";


        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {
            $pic = 'user.png';
            if (isset($data['photo']))
                $pic = $data['photo'];
            $rt .= '<tr>
                                                <td width="20%">
                                                <div class="row">
                                                <div class="col-md-1 col-xl-1" style="display: inline">  <img  class="rounded-circle" width="40" src="' . ROOT . '/images/users/' . $pic . '" /> </div>
                                                <div class="col-md-2 col-xl-2" style="display: inline"> <b>' . $data['first_name'] . ' ' . $data['last_name'] . '</b>  </div>
                                                <div class="col-md-7 col-xl-7" style="display: inline"> ' . $data['title'] . ' </div>
                                                <div class="col-md-2 col-xl-2" style="display: inline"> ' . makeAgo($data['created'], time(), 1) . ' </td></div>
                                               
                                               
                                               
                                                </div>
                                            </tr>';
        }

        return $rt;
    }



    public static function sendToSelector()
    {


        $id = $_SESSION['user']['location_id'];

        //Handle Sending Messages for Subject Matter Specialists
        $user_cat = 1;
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
                $user_cat = "user_category_id =  8";
                break;

            case 3:
                $user_cat = "user_category_id =  9";
                break;

            case 4:
                $user_cat = "user_category_id =  7";
                break;


            case 8:
                $user_cat = " (user_category_id =  2  OR user_category_id =  1) ";
                break;

            case 9:
                $user_cat = " (user_category_id =  3  OR user_category_id =  1)  ";
                break;

            case 7:
                $user_cat = "(user_category_id =  4  OR user_category_id =  1) ";
                break;

            case  1:

                break;

            case  11:

                break;

            default:
                break;
        }



        $content = '';
        switch ($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,user_category.name as cat,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user,user_category 
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                   AND user.user_category_id = user_category.id                       
                   AND subcounty.id = user.location_id
                   AND district.id = " . $_SESSION['user']['district_id'] . "
                   AND $user_cat
                   ";
                break;

            case 7:
            case 8:
            case 9:

                $id =      $_SESSION['user']['district_id'];

                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,user_category.name as cat,district.name as district 
                        FROM district,user,user_category 
                        WHERE district_id =  $id
                        AND user.user_category_id = user_category.id
                        AND  $user_cat
                        AND district.id = user.district_id
                   ";

                break;



            case 1:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id, user_category.name as cat,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user,user_category 
                   WHERE district.id =county.district_id
                   AND user.user_category_id = user_category.id                       
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND subcounty.id = $id
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
                   ";
                break;



            case 10:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id, user_category.name as cat,district.name as district,subcounty.name as location
                   FROM district,subcounty,county,user,user_category 
                   WHERE district.id =county.district_id
                   AND user.user_category_id = user_category.id                       
                   AND county.id = subcounty.county_id
                   AND subcounty.id = user.location_id
                   AND subcounty.id = $id
                   AND (user_category_id = 2 OR user_category_id = 3 OR user_category_id = 4  OR user_category_id = 11  OR user_category_id = 6 )
                   ";
                break;



            case 11:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id, user_category.name as cat,district.name as district,subcounty.name as location
                   FROM district,user,county,subcounty,user_category 
                   WHERE district.id = " . $_SESSION['user']['district_id'] . "
                   AND district.id =county.district_id
                   AND user.user_category_id = user_category.id    
                   AND county.id = subcounty.county_id
                    AND subcounty.id = user.location_id                   
                   AND  user_category_id = 10 
              
                   ";
                break;


            case 6:
                $content = "SELECT user.id,photo,first_name,last_name,user_category_id,district.name as district,subcounty.name as location,user_category.name as cat
                   FROM district,user,county,subcounty,user_category 
                   WHERE district.id =county.district_id
                   AND county.id = subcounty.county_id
                    AND user.user_category_id = user_category.id                      
                    AND subcounty.id = user.location_id                   
                   AND (user_category_id = 7 OR user_category_id = 8 OR user_category_id = 9)
              
                   ";

                break;


            default:
                $content = '';
                break;
        }


        //echo $content;

        $sql = database::performQuery($content);

        $rt =  '';
        while ($data = $sql->fetch_assoc()) {

            $rt .= '<option value="' . $data['id'] . '"> ' . $data['first_name'] . ' ' . $data['last_name'] . ' (<small>' . $data['cat'] . '</small>) </option>';
        }

        return $rt;
    }



    public static function processMsg()
    {

        $msg = database::prepData($_REQUEST['msg']);
        $subject = database::prepData($_REQUEST['subject']);
        $in_reply = 0;
        if (isset($_REQUEST['in_reply']))
            $in_reply = database::prepData($_REQUEST['in_reply']);
        $from = $_SESSION['user']['id'];
        $created = makeMySQLDateTime();
        $read = 0;
        $users = $_REQUEST['users'];

        $dataz = [];
        foreach ($users as $user) {
            if ($user != '')
                $dataz[] = "('$subject','$msg','$created','$from','$user','$in_reply','$read')";
        }

        $x = implode(",", $dataz);


        $sql = database::performQuery("INSERT INTO `ext_feedback`(`title`, `texts`, `created`, `from_user_id`, `to_user_id`, `in_reply_to_id`, `read_status`) 
         VALUES $x");

        $id = database::getLastInsertID();
        redirect_to(ROOT . '/?action=feedbackSent&id=' . $id);
    }


    public function editUserWorkplan($id)
    {

        $conn = self::getConnection();

        $sql =  "SELECT * FROM  `ext_area_annual_outputs` WHERE id = ?";

        $stmt =  $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $financial_years =  ['2018/2019', '2019/2020', '2020/2021', '2021/2022', '2022/2023', '2023/2024', '2024/2025', '2025/2026'];

        if ($data['year'] == '2018/2019') {
            $financial_years = '
            <option value="2018/2019" selected>2018/2019</option>
            <option value="2019/2020">2019/2020</option>
            <option value="2020/2021">2020/2021</option>
            <option value="2021/2022">2021/2022</option>
            <option value="2022/2023">2022/2023</option>
            <option value="2023/2024">2023/2024</option>
            <option value="2024/2025">2024/2025</option>';
        } else if ($data['year'] == '2019/2020') {
            $financial_years = '
            <option value="2018/2019">2018/2019</option>
            <option value="2019/2020" selected>2019/2020</option>
            <option value="2020/2021">2020/2021</option>
            <option value="2021/2022" selected>2021/2022</option>
            <option value="2022/2023">2022/2023</option>
            <option value="2023/2024">2023/2024</option>
            <option value="2024/2025">2024/2025</option>';
        } else if ($data['year'] == '2020/2021') {
            $financial_years = '
            <option value="2018/2019" selected>2018/2019</option>
            <option value="2019/2020">2019/2020</option>
            <option value="2020/2021" selected>2020/2021</option>
            <option value="2021/2022">2021/2022</option>
            <option value="2022/2023">2022/2023</option>
            <option value="2023/2024">2023/2024</option>
            <option value="2024/2025">2024/2025</option>';
        } else if ($data['year'] == '2021/2022') {
            $financial_years = '
            <option value="2018/2019" selected>2018/2019</option>
            <option value="2019/2020">2019/2020</option>
            <option value="2020/2021">2020/2021</option>
            <option value="2021/2022" selected>2021/2022</option>
            <option value="2022/2023">2022/2023</option>
            <option value="2023/2024">2023/2024</option>
            <option value="2024/2025">2024/2025</option>';
        } else if ($data['year'] == '2022/2023') {
            $financial_years =  '
            <option value="2018/2019" selected>2018/2019</option>
            <option value="2019/2020">2019/2020</option>
            <option value="2020/2021">2020/2021</option>
            <option value="2021/2022">2021/2022</option>
            <option value="2022/2023" selected>2022/2023</option>
            <option value="2023/2024">2023/2024</option>
            <option value="2024/2025">2024/2025</option>';
        } else if ($data['year'] == '2023/2024') {
            $financial_years =  '
            <option value="2018/2019" selected>2018/2019</option>
            <option value="2019/2020">2019/2020</option>
            <option value="2020/2021">2020/2021</option>
            <option value="2021/2022">2021/2022</option>
            <option value="2022/2023" selected>2022/2023</option>
            <option value="2023/2024" selected>2023/2024</option>
            <option value="2024/2025">2024/2025</option>';
        } else if ($data['year'] == '2024/2025') {
            $financial_years =  '
            <option value="2018/2019" selected>2018/2019</option>
            <option value="2019/2020">2019/2020</option>
            <option value="2020/2021">2020/2021</option>
            <option value="2021/2022">2021/2022</option>
            <option value="2022/2023" selected>2022/2023</option>
            <option value="2023/2024">2023/2024</option>
            <option value="2024/2025" selected>2024/2025</option>';
        }





        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Fill the form below</h4>
                            </div>
                            
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Financial Year</label>
                                                    
                                                    <select class="form-control custom-select" name="year" id="year">
                                                        ' . $financial_years . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Key Output</label>
                                                    <textarea class="form-control" placeholder="Key Output here" rows="3" name="output">' . $data['key_output'] . '</textarea>
                                                     </div>
                                            </div>
                                            <!--/span-->
                                           
                                            
                                              <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Planned Activities</label>
                                                    
                                                    
                                                    <select class="select2 form-control" name="activities[]" multiple="multiple" style="height: 36px;width: 100%;" id="activities">
                                                        ' . self::getListofActivities() . '
                                                    </select>
                                                    
                                                      </div>
                                            </div>
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row p-t-20">
                                       
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Key Indicators</label>
                                                  <textarea class="form-control" placeholder="Enter All Key Indicators here for the key output"  rows="5" name="indicator">' . $data['indicators'] . '</textarea>
                                                       </div>
                                            </div>
                                            
                                            
                                           <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Key Targets</label>
                                                  <textarea class="form-control" rows="5" placeholder="Enter All Key Targets here for the key output"  name="target">' . $data['target'] . '</textarea>
                                                  
                                                  
                                                       </div>
                                            </div>
                                            
                                            
                                               
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Total Budget</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" name="budget"   placeholder="" value="' . $data['budget'] . '" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                            
                                            
                                            
                                            <!--/span-->
                                        </div>
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="action" value="editAnnualKO"/>
                                            <input type="hidden" name="id" value="' . $_REQUEST['id'] . '"/>
                                            <input type="hidden" name="user_id" value="' . $data['user_id'] . '"/>
                                            <input type="hidden" name="annual_outputs_id" value="' . $data['id'] . '"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i>Submit Changes</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script src="' . ROOT . '/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script>
                
                <script>
                $(document).ready(function(){
                    var activities = [' . $data["activities"] . '];
                
                    $("#activities").val(activities).change();
                    


                });
                </script>
                ';

        return $content;
    }


    public function editAnnualKO()
    {

        $year = database::prepData($_REQUEST['year']);
        $output = database::prepData($_REQUEST['output']);
        $target = database::prepData($_REQUEST['target']);
        $indicator = database::prepData($_REQUEST['indicator']);
        $budget = database::prepData($_REQUEST['budget']);
        $id = database::prepData($_REQUEST['id']);
        $user_id = database::prepData($_REQUEST['user_id']);
        $external_area_annual_outputs_id = database::prepData($_REQUEST['annual_outputs_id']);

        $activ = [];
        foreach ($_REQUEST['activities'] as $activity)
            $activ[] = $activity;
        $activities = implode(',', $activ);

        $conn = self::getConnection();

        $sql =  "UPDATE `ext_area_annual_outputs` SET 
        `year`=?, key_output=?, indicators=?, `target`=?, budget=?, `activities` = ?
        WHERE id = ?";

        $stmt =  $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $year, $output, $indicator, $target, $budget, $activities, $external_area_annual_outputs_id);
        if ($stmt->execute()) {

            $success_message = "Added Successfully";
            $stmt->close();
            $conn->close();
            redirect_to(ROOT . '/?action=viewUserWorkplan&id=' . $user_id);
        } else {

            $error_message = "Problem in Adding New Record";
            $stmt->close();
            $conn->close();
        }
    }

    public static function getLanguages()
    {

        $sql = database::performQuery("SELECT * FROM km_language");
        $content = '';
        while ($data = $sql->fetch_assoc()) {

            $content .= '<option value="' . $data['id'] . '">' . strtoupper(strtolower($data['name']));
        }

        return $content;
    }


    public static function getEnterprises()
    {

        $sql = database::performQuery("SELECT * FROM km_category");
        $content = '';
        while ($data = $sql->fetch_assoc()) {

            $content .= '<option value="' . $data['name'] . '">' . strtoupper(strtolower($data['name']));
        }

        return $content;
    }


    public static function getEnterprisesWithID()
    {

        $sql = database::performQuery("SELECT * FROM km_category");
        $content = '';
        while ($data = $sql->fetch_assoc()) {

            $content .= '<option value="' . $data['id'] . '">' . strtoupper(strtolower($data['name']));
        }

        return $content;
    }

    public function getChangeUserPassword()
    {

        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Fill the form below</h4>
                            </div>
                            <br/>
                            <div class="alert alert-danger" style="display:none" id="Validation-Div">
                                <ul id ="Validation">
                                    
                                </ul>
                            </div>

                            <div class="alert alert-success" style="display:none" id="Success-Div">
                                <ul id ="Success">
                                    
                                </ul>
                            </div>
                            <form  method="POST" id="change-password-form">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="current_password"   placeholder="Enter Current Password"  >
                                                </div> 
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="new_password"   placeholder="Enter New Password"  >
                                                </div> 
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="confirm_password"   placeholder="Confirm Password"  >
                                                </div> 
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <hr>
                                <div class="form-actions">
                                    <div class="card-body">
                                 
                                        <input type="hidden" name="user_id" value="' . $_SESSION['user']['id'] . '"/>
                                        <button type="submit" id="ConfirmButton" name="change_password" 
                                        class="btn btn-success button-prevent-multiple-submits"> <i class="fa fa-check"></i>Edit Password</button>
                                        <button type="reset" class="btn btn-dark">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script src="' . ROOT . '/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script>
            <script>
                $(document).ready(function () {
                    $("#change-password-form").on("submit", function(e){
                        e.preventDefault();
                        $(".button-prevent-multiple-submits").attr("disabled", true);      
                        
                        $.ajax({
                            method: \'POST\',
                            url: \'' . ROOT . '/?action=processChangeUserPassword\',
                            data: $( this ).serialize(),
                          
                            beforeSend:function(){
                                $("#ConfirmButton").text("Processing...");
                            },
                            success: function (response) {      
                                data = JSON.parse(response);
                                console.log(data);

                                if(data.success == false){
                                    
                                    $("#Success-Div").hide(); //hide succcess div in case
                                    $("#Validation").empty();     

                                    window.scrollTo(0,0) // Scroll to the top to display error message
                                    $("#Validation-Div").show(); // Unhide the div
                                    
                                    $("#Validation").append("<li>" + data.errors.error + "</li>");
                                }
                                else{
                                    $("#Validation-Div").hide(); //hide succcess div in case
                                    $("#Success").empty();     

                                    window.scrollTo(0,0) // Scroll to the top to display error message
                                    $("#Success-Div").show(); // Unhide the div
                                    
                                    $("#Success").append("<li>" + data.message + "</li>");

                                    $("#change-password-form").trigger("reset");
                                }

                                $(".button-prevent-multiple-submits").attr("disabled", false);
                                $("#ConfirmButton").text("Edit Password");
                            }  
                        });
                    });
                });
            </script>';

        return $content;
    }


    public static function processChangeUserPassword()
    {

        $errors = [];
        $data = [];


        $current_password = database::prepData($_REQUEST['current_password']);
        $confirm_password = database::prepData($_REQUEST['confirm_password']);

        if ($_POST['current_password'] == '') {
            $errors['error'] = 'Current Password field is required!';
        } elseif ($_POST['new_password'] == '') {
            $errors['error'] = 'New Password field is required!';
        } elseif ($_POST['confirm_password'] == '') {
            $errors['error'] = 'Please confirm your new password!';
        } elseif ($_POST['new_password'] != $_POST['confirm_password']) {
            $errors['error'] = 'Password confirmation does not match with new password!';
        } elseif ($_POST['current_password'] == $_POST['new_password']) {
            $errors['error'] = 'New Password and current password can not be the same!';
        } else {
            $user_id = database::prepData($_REQUEST['user_id']);

            $sql = database::performQuery("SELECT * FROM user WHERE  id = $user_id");

            $dat = $sql->fetch_assoc();

            if ($current_password != $dat['password']) {
                $errors['error'] = 'Current Password does not match our records';
            }
        }


        if (!empty($errors)) {

            $data['success'] = false;
            $data['errors'] = $errors;
        } else {




            $sql = database::performQuery("UPDATE user SET `password` = '" . $confirm_password . "' WHERE id = $user_id");

            $mail = new PHPMailer();


            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'users@m-omulimisa.com';
            $mail->Password = '@Myheartgud2022';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('users@m-omulimisa.com', 'MAAIF E-extension SYSTEM');  // Set sender of the mail
            $mail->addAddress($dat['email']);

            $mail->Subject = 'PASSWORD CHANGE';
            // Set HTML
            $mail->isHTML(TRUE);

            $mail->Body = '
            <html>
            <head>
            <title>Password Reset</title>
            </head>
            <body>
                <div>
                    <div style="border:1px solid red;">
                    
                    </div>
                    <p>HELLO, <b>' . $dat["first_name"] . ' ' . $dat["last_name"] . '</b> </p>
                    <p> You are receiving this email because you changed your password for
                    the MAAIF E-extension System. </p>
        
                    <p> Your new login credentials are: <br/>
                    Username : ' . $dat["username"] . '<br/>
                    Password : ' . $confirm_password . '<br/>
        
                    <p>If this was not you, kindly reach out to the support team</p>
                    <p>Thank You</p>
                </div>
            </body>
            </html>
                ';

            $mail->AltBody = 'Hello Welcome to MAAIF SYSTEM';

            if (!$mail->send()) {
                $data['success'] = false;
                $data['errors'] =  $errors['error'] = 'An error occured sending a confirmation mail!';
            } else {

                $data['success'] = true;
                $data['message'] = 'Password updated successfully!';
            }
        }

        echo json_encode($data);
    }

    public function editUserActivityQuarterly($id, $user)
    {

        $user = user::getUserDetails($_REQUEST['user_id']);
        $activities = self::getUserAnnualActivities2($_REQUEST['user_id']);
        $topics = self::getListofTopics();
        $outputs = self::getListofOutputs($_REQUEST['user_id']);
        $entt = self::getListofEnterprizes();

        $sql = database::performQuery("SELECT * FROM `ext_area_quaterly_activity` WHERE id = $id");
        $data =  $sql->fetch_assoc();


        $content = '<div class="row" xmlns="http://www.w3.org/1999/html">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Quarterly Activities for ' . $user['first_name'] . ' ' . $user['last_name'] . '</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                        <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Extension Officer</label>
                                                    
                                                     <div class="form-group">
                                                    <input type="text" class="form-control" id="nametext1" name="officer"   placeholder="' . $user['first_name'] . ' ' . $user['last_name'] . '" disabled >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                            
                                            
                                             <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Outputs to Fullfill</label>
                                                    
                                                  
                                                      </div>
                                                      
                                                      
                                                          <select class="select2 form-control" name="outputs[]" multiple="multiple" style="height: 36px;width: 100%;" id="outputs">
                                    ' . $outputs . '
                                </select>
                                            <br />          
                                            <br />   <br />          
                                            <br />             
                                                  
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Quarter</label>
                                                    
                                                    <select class="form-control custom-select" name="quarter">
                                                      <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4" SELECTED>4</option>
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Activity From Annual Activities for this Quarter</label>
                                                    
                                                    <select class="form-control custom-select" name="activity_id" id="activity">
                                                      <option>Select Activity</option>
                                                      ' . $activities . '
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Topics</label>
                                                    
                                                      </div>
                                                      
                                               
                                                      
                                                      
                                <select class="select2 form-control" name="topics[]" multiple="multiple" style="height: 36px;width: 100%;" id="topics">
                                    ' . $topics . '
                                </select>
                                
                                            <br />          
                                            <br />   <br />          
                                            <br />             
                                                      
                                            </div>
                                      <br />          
                                            <br />   
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Entreprizes</label>
                                                    
                                                  
                                                      </div>
                                                      
                                                      
                                                          <select class="select2 form-control" name="entt[]" multiple="multiple" style="height: 36px;width: 100%;" id="enterprises">
                                    ' . $entt . '
                                </select>
                                            <br />          
                                            <br />   <br />          
                                            <br />             
                                                  
                                            </div>
                                      
                                      
                                      
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Planned Number of Times this Quarter</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="planned_num"value="' . $data['num_planned'] . '"    placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                             
                                               <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> Number of Target Beneficiaries this Quarter</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="target" value="' . $data['num_target_ben'] . '"    placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>
                                            
                                             
                                              <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Budget this Quarter</label>
                                                    
                                                    <div class="form-group">
                                                    <input type="number" class="form-control" id="nametext1" name="budget" value="' . $data['budget'] . '"   placeholder="" >
                                                        </div> 
                                                      </div>
                                            </div>     
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="id" value="' . $_REQUEST['user_id'] . '"/>
                                            <input type="hidden" name="record_id" value="' . $data['id'] . '"/>
                                            <input type="hidden" name="action" value="processingEditQuarterlyActivities"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i>Submit Changes</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <script src="' . ROOT . '/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script>
                
                <script>
                $(document).ready(function () {
                    var enterprises = [' . $data["entreprizes"] . '];
                    var topics = [' . $data["topic"] . '];
                    var activity = ' . $data["annual_id"] . ';
                    var outputs =  [' . $data["key_output_id"] . '];
             

                    $("#enterprises").val(enterprises).change();
                    $("#topics").val(topics).change();
                    $("#activity").val(activity).change();
                    $("#outputs").val(outputs).change();

                });

                </script>
                ';

        return $content;
    }


    public function processingEditQuarterlyActivities()
    {

        //$month = database::prepData($_REQUEST['month']);
        $quarter = $_REQUEST['quarter'];
        $user_id = $_REQUEST['id'];
        $record_id = $_REQUEST['record_id'];
        $planned = database::prepData($_REQUEST['planned_num']);
        $target = database::prepData($_REQUEST['target']);
        $activity = database::prepData($_REQUEST['activity_id']);
        $budget = database::prepData($_REQUEST['budget']);
        //$outputs = database::prepData($_REQUEST['outputs']);
        $topics = [];
        foreach ($_REQUEST['topics'] as $topic)
            $topics[] = $topic;
        $topics = implode(',', $topics);


        $entt = [];
        foreach ($_REQUEST['entt'] as $ent)
            $entt[] = $ent;
        $entt = implode(',', $entt);


        $output = [];
        foreach ($_REQUEST['outputs'] as $outputz)
            $output[] = $outputz;
        $output = implode(',', $output);



        $sql = database::performQuery("UPDATE `ext_area_quaterly_activity` SET
        `num_planned` = '" . $planned . "', `num_target_ben` ='" . $target . "',  `budget` = '" . $budget . "', 
        `annual_id` = '" . $activity . "',
        `quarter` = '" . $quarter . "', `topic` = '" . $topics . "', `entreprizes`='" . $entt . "',
       `key_output_id` = '" . $output . "'
        WHERE id='" . $record_id . "'");

        redirect_to(ROOT . '/?action=viewQuarterlyActivities&id=' . $user_id);
    }




    public function getForgotPassword()
    {

        $content = '
        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-2">
                        <!--begin::Card body-->
                        <div class="card-body p-10 p-lg-15">
                            <!--begin::Title-->
                            <h5 class="fw-bolder text-dark mb-12 ps-0">Kindly enter your email address</h5>
                            <!--end::Title-->
                            <!--begin::Row-->
                            <div class="row">  
                                <div class="alert alert-danger" style="display:none" id="Validation-Div">
                                    <ul id ="Validation">
                                        
                                    </ul>
                                </div>

                                <div class="alert alert-success" style="display:none" id="Success-Div">
                                    <ul id ="Success">
                                        
                                    </ul>
                                </div>
                                <div class = "col-lg-10">
                                    <form action="#" id="forgot-password-form" method="post">
                                    <div class="col-lg-12">
                                        <label class="fs-6 form-label fw-bolder text-dark">Email Address</label>
                                        <input type="email" class="form-control" name="email"   placeholder="Enter email address" autocomplete="off" required>
                                    </div>  
                                    <br/>

                                    <div class="col-lg-3">
                                        <label class="fs-6 form-label fw-bolder text-dark">&nbsp; </label> <br />
                                        <input type="hidden" name="action" value="processForgotPassword"/>
                                        <button type="submit" id="ConfirmButton" class="btn btn-primary me-5 button-prevent-multiple-submits">Reset Account</button>
                                    </div>
                                    </form>
                                </div>           
                            </div>
                        <!--end::Row-->
                        </div>
                    <!--end::Card body-->
                    </div>
                </div>
            </div>';
        $scripts = '
            <script src="' . ROOT . '/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script>
            <script>
                $(document).ready(function () {
                    $("#forgot-password-form").on("submit", function(e){
                        e.preventDefault();
                        $(".button-prevent-multiple-submits").attr("disabled", true);      
                        
                        $.ajax({
                            method: \'POST\',
                            url: \'' . ROOT . '/?action=processForgotPassword\',
                            data: $( this ).serialize(),
                          
                            beforeSend:function(){
                                $("#ConfirmButton").text("Processing...");
                            },
                            success: function (response) {      
                                data = JSON.parse(response);
                                console.log(data);

                                if(data.success == false){
                                    
                                    $("#Success-Div").hide(); //hide succcess div in case
                                    
                                    $("#Validation").empty();     

                                    window.scrollTo(0,0) // Scroll to the top to display error message
                                    $("#Validation-Div").show(); // Unhide the div
                                    
                                    $("#Validation").append("<li>" + data.errors.error + "</li>");
                                }
                                else{
                                    $("#Validation-Div").hide(); //hide succcess div in case
                                    $("#email-field").hide(); //hide form div in case
                                    $("#Success").empty();     

                                    window.scrollTo(0,0) // Scroll to the top to display error message
                                    $("#Success-Div").show(); // Unhide the div
                                    
                                    $("#Success").append("<li>" + data.message + "</li>");
                                }

                                $(".button-prevent-multiple-submits").attr("disabled", false);
                                $("#ConfirmButton").text("Reset Account");
                            }  
                        });
                    });
                });
            </script>';

        return [
            'content' => $content,
            'scripts' => $scripts,
            'styles' => $styles
        ];
    }

    public static function generateRandomString($length = 10)
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function processForgotPassword()
    {

        $errors = [];
        $data = [];


        $email = database::prepData($_REQUEST['email']);


        if ($_POST['email'] == '') {
            $errors['error'] = 'Email field is required!';
        } else {
            $sql = database::performQuery("SELECT * FROM `user`  WHERE `email` = '" . $email . "' ");
            $num_rows = mysqli_num_rows($sql);
            if ($num_rows < 1) {
                $errors['error'] = 'Email does not exist in our records!';
            }
        }

        if (!empty($errors)) {

            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $password = self::generateRandomString(10);

            $data = $sql->fetch_assoc();

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'users@m-omulimisa.com';
            $mail->Password = '@Myheartgud2022';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('users@m-omulimisa.com', 'MAAIF E-extension SYSTEM');  // Set sender of the mail
            $mail->addAddress($data['email']);

            $mail->Subject = 'PASSWORD RESET';
            // Set HTML
            $mail->isHTML(TRUE);

            $mail->Body = '
            <html>
            <head>
            <title>Password Reset</title>
            </head>
            <body>
                <div>
                    <div style="border:1px solid red;">
                    </div>
                    <p>HELLO, <b>' . $data["first_name"] . ' ' . $data["last_name"] . '</b> </p>
                    <p> You are receiving this email because you requested for a password reset for
                    the MAAIF E-extension System. </p>
        
                    <p> Your new login credentials are: <br/>
                    Username : ' . $data["username"] . '<br/>
                    Password : ' . $password . '<br/>
        
                    <p>If this was not you, kindly reach out to the support team</p>
                    <p>Thank You</p>
                </div>
            </body>
            </html>
                ';

            $mail->AltBody = 'Hello Welcome to MAAIF SYSTEM';

            if (!$mail->send()) {
                $data['success'] = false;
                $data['errors'] =  $errors['error'] = 'An error occured. Please try again!';
            } else {

                $sql = database::performQuery("UPDATE `user` SET
                `password` = '" . $password . "'
                WHERE id='" . $data["id"] . "'");

                $data['success'] = true;
                $data['message'] = 'Email has been sent to the email provided!';
            }
        }

        echo json_encode($data);
    }

    public static function sendUserLogins()
    {

        $errors = [];
        $data = [];




        $user_id = database::prepData($_POST['user_id']);

        $sql = database::performQuery("SELECT * FROM `user`  WHERE `id` = '" . $user_id . "' ");
        $num_rows = mysqli_num_rows($sql);
        if ($num_rows < 1) {
            $errors['error'] = 'User does not exist in our records!';
        }

        $data = $sql->fetch_assoc();


        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'users@m-omulimisa.com';
        $mail->Password = '@Myheartgud2022';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('users@m-omulimisa.com', 'MAAIF E-extension SYSTEM');  // Set sender of the mail
        $mail->addAddress($data['email']);

        $mail->Subject = 'USER CREDENTIALS';
        // Set HTML
        $mail->isHTML(TRUE);

        $mail->Body = '
            <html>
            <head>
            <title>User Credentials</title>
            </head>
            <body>
                <div>
                    <div style="border:1px solid red;">
                    </div>
                    <p>HELLO, <b>' . $data["first_name"] . ' ' . $data["last_name"] . '</b> </p>
                    <p> You are receiving this email because you requested for a password reset for
                    the MAAIF E-extension System. </p>
        
                    <p> Your new login credentials are: <br/>
                    Username : ' . $data["username"] . '<br/>
                    Password : ' . $data["password"] . '<br/>
        
                    <p>If this account does not belong  you, kindly reach out to the support team</p>
                    <p>Thank You</p>
                </div>
            </body>
            </html>
                ';

        $mail->AltBody = 'User Credentials to MAAIF SYSTEM';

        if (!$mail->send()) {
            $data['success'] = false;
            $data['errors'] =  $errors['error'] = 'An error occured. Please try again!';
        } else {

            $data['success'] = true;
            $data['message'] = 'Email has been sent to the email provided!';
        }

        echo json_encode($data);
    }

    public function getReportGrievance()
    {

        $content =  [
            'content' => '
                <div class="container py-4">

                    <div class="row mb-2">
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <p class="mb-4"><strong>Fill in the form below!</strong></p>
                                            <!-- form -->
                                            <div class="alert alert-danger" style="display:none", id="Validation-Div">
                                                <ul id ="Validation">
                                        
                                                </ul>
                                            </div>

                                            <div class="alert alert-success" style="display:none", id="Success-Div">
                                                <ul id ="Success">
                                        
                                                </ul>
                                            </div>
                                                <form action="#" method="POST" id="grievance-form">

                                                <div class="row"> 
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">First name</label>
                                                        <input type="text" class="form-control text-3 h-auto py-2" name="first_name" placeholder="Enter first name" required>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Last name</label>
                                                        <input type="text" class="form-control text-3 h-auto py-2" name="last_name" placeholder="Enter last name" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Gender</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="gender" required>
                                                          <option value="">--select gender --</option>  
                                                          <option value="male">Male</option>         
                                                          <option value="female">Female</option>                                                                       
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Date of Birth</label>
                                                        <input type="date" class="form-control text-3 h-auto py-2" name="date_of_birth"  placeholder="Date of birth" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label mb-1 text-2">Contact</label>
                                                        <input type="text" class="form-control text-3 h-auto py-2" name="contact" placeholder="Enter contact" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">District</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2"  id="sel_district" required>
                                                          <option value = "">--select district -- </option>  
                                                          ' . self::getGRMDistricts() . '                    
                                                          </select>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Subcounty</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="subcounty_id" id="sel_subcounty" required>
                                                            <option value = "">--select sub county -- </option> 
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row">
                                                    
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Parish</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="parish_id" id="sel_parish" required>
                                                          <option value = "">--select parish -- </option> 
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Date of Grievance</label>
                                                        <input type="date" class="form-control text-3 h-auto py-2" name="date_of_grievance"  placeholder="Date of grievances" required>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Mode of Feedback</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="feedback_mode" required>
                                                          <option value = "">--select mode of feedback -- </option>  
                                                            ' . self::getModeOfFeedback() . ' 
                                                          </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Nature of Grievance</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="nature_of_grievance" id="grievance_nature" required>
                                                          <option value = "">--select nature of grievance -- </option>  
                                                            ' . self::getGrievanceNatures() . ' 
                                                          </select>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Type of Grievance</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="type_of_grievance" id="grievance-type" required>
                                                          <option value = "">--select type of grievance -- </option>  
                                                          </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label class="form-label mb-1 text-2">Description</label>
                                                        <textarea maxlength="5000" data-msg-required="Enter Description of the event" rows="5" class="form-control text-3 h-auto py-2" name="description" required=""></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <input type="hidden" name="action" value="saveGrievanceReport">
                                                        <input type="submit" value="Submit Grievance" id="confirmButton" class="btn btn-primary btn-modern button-prevent-multiple-submits" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                        </div>
                    </div>

                </div>',

            'styles' => null,
            'scripts' => '
                <!-- <script src="' . ROOT . '/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script> -->
                  <script src="' . ROOT . '/includes/theme/assets/libs/select2/dist/js/select2.full.min.js"></script>
                  <script src="' . ROOT . '/includes/theme/assets/libs/select2/dist/js/select2.min.js"></script>
                  <!--<script src="' . ROOT . '/includes/theme/dist/js/pages/forms/select2/select2.init.js"></script>  -->
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>


                  <script>
                  
                  $(document).ready(function(){
                         
                          // $(".select2").select2();

                          $("#sel_district").change(function(){
                            var id = $(this).val();   
                            $.ajax({
                                url: \'' . ROOT . '/?action=getSubCountiesByDistrict\',
                                method: \'POST\',
                                data: {"id":id},
                                success:function(response){
                                    console.log(response);
                                    data = JSON.parse(response);
                                    
                                    $("#sel_subcounty").empty();
                                    $("#sel_parish").empty();
                                    $.each(data, function (key, entry) {
                                        console.log(entry);
                                        $("#sel_subcounty").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");                               
                                    });
                                },
                                error:function(response){
                                    console.log(response);
                                }
                            });
                        });
                       
                       

                        $("#sel_subcounty").change(function(){
                            var id = $(this).val();
                    
                            $.ajax({
                                url: \'' . ROOT . '/?action=getParishesBySubCounty\',
                                method: \'POST\',
                                data: {"id":id},
                                success:function(response){
                                    data = JSON.parse(response);
                                    console.log(data);
                                    
                                    $("#sel_parish").empty();
                                    $.each(data, function (key, entry) {
                                        console.log(entry);
                                        $("#sel_parish").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");
                                    });
                                }
                            });
                        });

                          $("#grievance_nature").change(function(){
                            var id = $(this).val();   
                            $.ajax({
                                url: \'' . ROOT . '/?action=getGrievanceTypesByNature\',
                                method: \'POST\',
                                data: {"id":id},
                                success:function(response){
                                    data = JSON.parse(response);
                                    console.log(response);
                                    
                                    $("#grievance-type").empty();
                                   
                                    $.each(data, function (key, entry) {
                                        console.log(entry);
                                        $("#grievance-type").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");                               
                                    });
                                },
                                error:function(response){
                                    console.log(response);
                                }
                            });
                        });

                        $("#grievance-form").validate({
                            rules:{
                                first_name:{
                                    required: true,
                                    maxlength: 35,
                                    minlength: 3
                                },
    
                                last_name:{
                                    required: true,
                                    maxlength: 35,
                                    minlength: 3
                                },
    
                                gender:{
                                    required: true,
                                  
                                },
                                language:{
                                    required: true,
                                   
                                },
    
                                contact:{
                                    required: true,
                                  
                                },

                                a1:{
                                    required: true,
                                },

                                a2:{
                                    required: true
                                },

                                parish:{
                                    required: true
                                },

                                body:{
                                    required: true
                                },

                                enterprise:{
                                    required: true
                                }
                            },
    
                            errorElement: \'span\',
                            errorPlacement: function (error, element) {
                            error.addClass(\'invalid-feedback\');
                            element.closest(\'.form-group\').append(error);
                            },
    
                            // Called when the element is invalid:
                            highlight: function (element, errorClass, validClass) {
                                $(element).addClass(\'is-invalid\');
                            },
                
                            // Called when the element is valid:
                            unhighlight: function (element, errorClass, validClass) {
                                $(element).removeClass(\'is-invalid\');
                            },
    
                            submitHandler: function(form) {
    
                                var formData = new FormData(form);
                  
                                $(\'.button-prevent-multiple-submits\').attr(\'disabled\', true); // Disable button on clicking submit
    
                                $.ajax({
                                    url: \'' . ROOT . '/?action=saveGrievanceReport\',
                                    type: \'post\',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    beforeSend:function(){
                                        $(\'#confirmButton\').text(\'Processing...\');
                                    },
    
                                    success: function(response) {
                                        $("#Success").empty();
                                        $(\'#confirmButton\').text(\'Add New\');
                                        console.log(response);
                     
                                        $("#Validation-Div").hide();
                                        
                        
                                        window.scrollTo(0,0) // Scroll to the top to display error message
                                        $("#Success-Div").show(); // Unhide the div
                      
                                        $("#Success").append(\'<li>\' + "Grievance has been submitted successfully." + \'</li>\');
                                        $("#grievance-form")[0].reset(); // Reset Form
                    
                                        $(\'.button-prevent-multiple-submits\').attr(\'disabled\', false);
                     
                                    }
                                });
                            }
                                    
    
                        });
                      });
                  
                  </script>'
        ];

        return $content;
    }


    public static function getGRMDistricts()
    {

        $sql = self::conGRM()->query("SELECT district.id,district.name FROM district ORDER BY name ASC");

        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . ' District</option>';
        }
        return $content;
    }


    public static function getGRMCountiesByDistrict()
    {

        $id =  database::prepData($_REQUEST['id']);

        $sql = self::conGRM()->query("SELECT id, `name` FROM county WHERE district_id='" . $id . "' ORDER BY name ASC");


        $counties = [];

        $counties[] = array("id" => 0, "name" => "--select county--");
        while ($data = $sql->fetch_assoc()) {

            $counties[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
        }
        echo json_encode($counties);
    }

    public static function getGRMSubCountiesByCounty()
    {

        $id =  database::prepData($_REQUEST['id']);

        $sql = self::conGRM()->query("SELECT id, `name` FROM subcounty WHERE county_id='" . $id . "' ORDER BY name ASC");


        $sub_counties = [];

        $sub_counties[] = array("id" => 0, "name" => "--select sub county--");
        while ($data = $sql->fetch_assoc()) {

            $sub_counties[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
        }
        echo json_encode($sub_counties);
    }

    public static function getGRMParishesBySubCounty()
    {

        $id =  database::prepData($_REQUEST['id']);

        $sql = self::conGRM()->query("SELECT id, `name` FROM parish WHERE subcounty_id='" . $id . "' ORDER BY name ASC");


        $parishes = [];

        $parishes[] = array("id" => 0, "name" => "--select parish--");
        while ($data = $sql->fetch_assoc()) {

            $parishes[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
        }
        echo json_encode($parishes);
    }


    public static function getModeOfFeedback()
    {

        $sql = self::conGRM()->query("SELECT id,`name` FROM feedback_mode");

        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . '</option>';
        }
        return $content;
    }

    public static function getGrievanceNatures()
    {

        $sql = self::conGRM()->query("SELECT id,`name` FROM grievance_nature");

        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . '</option>';
        }
        return $content;
    }

    public static function getGrievanceTypesByNature()
    {

        $id =  database::prepData($_REQUEST['id']);

        $sql = self::conGRM()->query("SELECT id, `name` FROM `grivance_type` WHERE grievance_nature_id='" . $id . "' ORDER BY name ASC");


        $types = [];

        $types[] = array("id" => 0, "name" => "--Type of grievance--");
        while ($data = $sql->fetch_assoc()) {

            $types[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
        }
        echo json_encode($types);
    }


    public function saveGrievanceReport()
    {

        $parish_id =  database::prepData($_REQUEST['parish_id']);
        $first_name =  database::prepData($_REQUEST['first_name']);
        $last_name =  database::prepData($_REQUEST['last_name']);
        $gender =  database::prepData($_REQUEST['gender']);
        $contact =  database::prepData($_REQUEST['contact']);
        $date_of_birth =  database::prepData($_REQUEST['date_of_birth']);
        $date_of_grievance =  database::prepData($_REQUEST['date_of_grievance']);
        $description =  database::prepData($_REQUEST['description']);
        $feedback_mode =  database::prepData($_REQUEST['feedback_mode']);
        $nature_of_grievance =  database::prepData($_REQUEST['nature_of_grievance']);
        $type_of_grievance =  database::prepData($_REQUEST['type_of_grievance']);


        $name =  $first_name . ' ' . $last_name;

        $today = date("Y-m-d");
        $age = date_diff(date_create($date_of_birth), date_create($today))->format('%Y');



        $sql = self::conGRM()->query("INSERT INTO grivance (parish_id, complainant_name, 
        complainant_age, complainant_phone, complainant_gender, complainant_feedback_mode,
        complainant_anonymous, date_of_grivance, grievance_nature_id, grievance_type_id,
        `description`) 
        VALUES ('$parish_id','$name', '$age', '$contact',
        '$gender','$feedback_mode',0,'$date_of_grievance',
        '$nature_of_grievance', '$type_of_grievance', '$description')");


        $response['message'] =  "Data inserted successfully";
        http_response_code(200);
        echo json_encode($response);
    }

    public static function getUserNotifications()
    {

        $user =  $_SESSION['user']['id'];

        $data = [];


        $sql = database::performQuery("SELECT notifications.title, notifications.message,
        notification_user.is_read, notification_user.id, notifications.publish_date FROM notification_user 
        INNER JOIN notifications ON notification_user.notification_id=notifications.id
        AND notification_user.user_id = '" . $user . "' ORDER BY notification_user.id DESC LIMIT 5");

        $unread_messages = database::performQuery("SELECT COUNT(id) as unread_messages FROM notification_user WHERE `user_id` =  '" . $user . "'
        AND is_read = 0 ");

        $unread_messages = $unread_messages->fetch_assoc();

        $notifications = [];

        while ($data = $sql->fetch_assoc()) {

            $notifications[] = array(
                "id" => $data['id'], "title" => strtoupper($data['title']),
                "message" => $data['message'], "is_read" => $data['is_read'],
                "publish_date" => $data['publish_date']
            );
        }

        $data = ['count' => $unread_messages, 'notifications' => $notifications];
        echo json_encode($data);
    }


    public function viewAllUserNotifications()
    {

        $id =  $_SESSION['user']['id'];

        $sql = database::performQuery("SELECT * FROM user WHERE id LIKE $id LIMIT 1");
        $user = [];
        while ($data = $sql->fetch_assoc()) {
            $user[] = $data;
        }

        $cat = user::getUserCategory($user[0]['user_category_id']);
        $loc = subcounty::getSubCounty($user[0]['location_id']);

        $content = '

            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-2 col-xlg-2 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                ' . self::userCardView($loc, $user, $cat) . '  
                                <br />
                                </center>
                            </div>
                       
                          
                        </div>
                    </div>
                    
                    <div class="col-lg-10 col-xlg-10 col-md-10">
                    <a href="' . ROOT . '/?action=markAllNotificationsAsRead"><button class ="btn btn-primary">Mark All as Read</button></a>

                    <a href="' . ROOT . '/?action=deleteAllUserNotifications"><button class ="btn btn-primary">Delete All User Notifications</button></a>
                        <div class="card">
                        
                            <!-- Tabs -->
                       <div class="table-responsive">
                                <table class="table table-striped" id="notifications-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Publish Date</th>                                            
                                            <th scope="col">Priority</th>
                                            <th scope="col">Actions</th>
                                           </tr>
                                    </thead>
                                    <tbody>
                                        ' . self::getAllUserNotifications() . '
                                    </tbody>
                                </table>
                            </div>
                        
                        
                        
                         </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
        ';


        return $content;
    }


    public function getAllUserNotifications()
    {

        $id =  $_SESSION['user']['id'];

        $content = '<tr>       
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>
                        <td>None</td>   
                    </tr>';

        $sql = database::performQuery("SELECT notifications.title, notifications.message, 
        notification_user.is_read, notification_user.id, notifications.publish_date, notifications.priority FROM notification_user 
        INNER JOIN notifications ON notification_user.notification_id=notifications.id
        AND notification_user.user_id = '" . $id . "' ORDER BY notification_user.id DESC");

        if ($sql->num_rows > 0) {



            $content = '';
            $x = 1;
            while ($data = $sql->fetch_assoc()) {

                $addd_btn2 = '<td><a href="' . ROOT . '/?action=deleteUserNotification&id=' . $data['id'] . '" title="Delete Notification" class="text-danger"><i class="fas fa-trash"></i></a> 
                &nbsp;&nbsp;
                </td>';

                $content .= '<tr>
                <td>' . $data['title'] . '</td>
                <td style="font-size:12px">' . $data['message'] . '</td>
                <td style="font-size:12px">' . $data['publish_date'] . '</td>
                <td style="font-size:12px">' . $data['priority'] . '</td>
                ' . $addd_btn2 . '
                </tr>';
            }
        }

        return $content;
    }


    public function markAllNotificationsAsRead()
    {

        $id =  $_SESSION['user']['id'];

        $read = 1;

        $sql = database::performQuery("UPDATE `notification_user` SET
        `is_read` = '" . $read . "'
        WHERE user_id='" . $id . "'");

        redirect_to(ROOT . '/?action=viewAllUserNotifications');
    }


    public function deleteAllUserNotifications()
    {

        $id =  $_SESSION['user']['id'];

        $sql = database::performQuery("DELETE FROM `notification_user`
        WHERE user_id ='" . $id . "'");

        redirect_to(ROOT . '/?action=viewAllUserNotifications');
    }


    public function deleteUserNotification($id)
    {

        $sql = database::performQuery("DELETE FROM `notification_user`
    WHERE id ='" . $id . "'");

        redirect_to(ROOT . '/?action=viewAllUserNotifications');
    }

    public static function sendUserNotification($ids, $title, $message, $priority = "medium")
    {

        $title =  database::prepData($title);
        $message = database::prepData($message);
        $priority = database::prepData($priority);
        $publish_date = date("Y-m-d");
        $created_at = date("Y-m-d h:i:s");


        $sql = database::performQuery("INSERT INTO `notifications` (title, `message`, publish_date, priority, created_at)
        VALUES ('" . $title . "','" . $message . "', '" . $publish_date . "','" . $priority . "', '" . $created_at . "')");

        $is_read = 0;
        $notification_id = database::getLastInsertID();

        foreach ($ids as $id) {

            $sql = database::performQuery("INSERT INTO `notification_user` (notification_id, `user_id`, is_read)
            VALUES ('" . $notification_id . "','" . $id . "', '" . $is_read . "')");
        }
    }

    public static function getDirectorates()
    {

        $sql = database::performQuery("SELECT id,directorate FROM directorates ORDER BY directorate ASC");
        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['directorate'])) . '</option>';
        }
        return $content;
    }

    public function getDepartmentsByDirectorate()
    {
        $id = $_REQUEST['id'];

        $sql = database::performQuery("SELECT id,department FROM departments WHERE directorate_id  ='" . $id . "'
        ORDER BY department ASC");

        $departments[] = array("id" => "", "name" => "--select department--");
        while ($data = $sql->fetch_assoc()) {
            $departments[] = array("id" => $data['id'], "name" => strtoupper($data['department']));
        }

        echo json_encode($departments);
    }


    public function getDivisionsByDepartment()
    {
        $id = $_REQUEST['id'];

        $sql = database::performQuery("SELECT id,division FROM divisions WHERE department_id  ='" . $id . "'
        ORDER BY division ASC");

        $divisions[] = array("id" => "", "name" => "--select division--");
        while ($data = $sql->fetch_assoc()) {
            $divisions[] = array("id" => $data['id'], "name" => strtoupper($data['division']));
        }

        echo json_encode($divisions);
    }

    public function adminGetParishesBySubcounty()
    {
        $id = $_REQUEST['id'];

        $sql = database::performQuery("SELECT id,name FROM parish WHERE subcounty_id  ='" . $id . "'
        ORDER BY name ASC");

        $divisions[] = array("id" => "", "name" => "--select parish--");
        while ($data = $sql->fetch_assoc()) {
            $divisions[] = array("id" => $data['id'], "name" => strtoupper($data['name']));
        }

        echo json_encode($divisions);
    }

    public function getEditUserDetails($id)
    {

        $sql = database::performQuery("SELECT * FROM user WHERE id  ='" . $id . "' LIMIT 1");


        $data = $sql->fetch_assoc();

        $content = '<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                        <br/>

                            <form method="POST" id="send-user-login-form">
                                <input type ="hidden" id="login_user_id" name ="user_id" value="' . $data['id'] . '" />
                                <input type="hidden" name="action" value="sendUserLogin"/>
                                <button type="submit" id="Send-Logins"style="float: right;" class="btn btn-success button-prevent-multiple-submits">Send Logins</button>
                            </form>
                        <br/>

                            <div class="card-header bg-info">
                                <h4 class="m-b-0 txt-white">Edit User</h4>
                            </div>
                            <div class="alert alert-danger" style="display:none", id="Validation-Div">
                                <ul id ="Validation">
                        
                                </ul>
                            </div>

                            <div class="alert alert-success" style="display:none", id="Success-Div">
                                <ul id ="Success">
                        
                                </ul>
                            </div>

                            <form action="" method="POST" id="edit-user-form">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                    
                                        <div class="row p-t-20">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" id="firstName" class="form-control" placeholder="firstname" name="firstname" value="' . $data['first_name'] . '" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-4">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" id="lastName" class="form-control form-control-danger" placeholder="lastname" value="' . $data['last_name'] . '" name="lastname" required>
                                                     </div>
                                            </div>
                                            
                                             <div class="col-md-4">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Username</label>
                                                    <input type="text" id="lastName" class="form-control form-control-danger" placeholder="username" value="' . $data['username'] . '" name="username" required>
                                                     </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" id="firstName" name="email" class="form-control" placeholder="john@gmai.com" value="' . $data['email'] . '" required>
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Password</label>
                                                <input type="password" id="lastName" name="password" class="form-control form-control-danger"value="' . $data['password'] . '" placeholder="xxx" required>
                                                 </div>
                                        </div>
                                        <!--/span-->
                                            <!--/span-->
                                            
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Gender</label>
                                                    <select class="form-control custom-select" name="gender">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                    <small class="form-control-feedback"> Select your gender </small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Phone</label>
                                                    <input type="text" class="form-control" name="phone" placeholder="0701 234567" value="' . $data['phone'] . '" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">User Category</label>
                                                    ' . self::switchUserCat() . '
                                                </div>
                                            </div>
                                                                                        <!--/span-->
                                           
                                       </div>';

        if (isset($data['location_id'])) {
            $content .= '<div class="col-md-6" style="select_area_districts">
                        <div class="form-group">
                            <label class="control-label">Select District</label>
                            <select class="form-control custom-select" name="district_id" id="select_district">
                                <option value="">--Select district--</option> 
                                ' . self::getSelectedDistricts($data['district_id']) . '
                            </select>
                        </div>
                    </div>';
        } else {
            $content .= '<div class="col-md-6" style="select_area_districts" style="display:none;">
                        <div class="form-group">
                            <label class="control-label">Select District</label>
                            <select class="form-control custom-select" name="district_id" id="select_district">
                                <option value="">--Select district--</option> 
                                ' . self::getSelectedDistricts($data['district_id']) . '
                            </select>
                        </div>
                    </div>';
        }

        if (isset($data['location_id'])) {
            $content .= '<div class="col-md-6" id="select_area_subcounty">
                                    <div class="form-group">
                                        <label class="control-label">Select Subcounty</label>
                                        <select class="form-control custom-select" name="location_id" id="select_subcounty">
                                            <option value="">--Select subcounty--</option> 
                                            ' . self::getSelectedSubCounties($data['district_id'], $data['location_id']) . '
                                        </select>
                                    </div>
                                </div>';
        } else {

            $content .= '<div class="col-md-6" style="display:none;" id="select_area_subcounty">
                    <div class="form-group">
                        <label class="control-label">Select Subcounty</label>
                        <select class="form-control custom-select" name="location_id" id="select_subcounty">
                            <option value="">--Select subcounty--</option> 
                            ' . self::getSubCountiesFromDistrict($data['district_id']) . '
                        </select>
                    </div>
                </div>';
        }


        if (isset($data['directorate_id']) || isset($data['department_id'])) {

            $content .= '  
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6" id="maaif_directorate">
                            <div class="form-group">
                                <label class="control-label">Select Directorate</label>
                                <select class="form-control custom-select" name="directorate_id" id="select_directorate">
                                    <option value="">--Select directorate--</option> 
                                    ' . self::getSelectedDirectorates($data['directorate_id']) . '
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6"  id="maaif_department">
                            <div class="form-group">
                                <label class="control-label">Select Department</label>
                                <select class="form-control custom-select" name="department_id" id="select_department">
                                <option value="">--Select department--</option>
                                ' . self::getSelectedDepartments($data['department_id']) . '
                                </select>
                            </div>
                        </div>
                    </div>';
        } else {
            $content .= '<div class="row">
                    <div class="col-md-6" style="display:none;" id="maaif_directorate">
                        <div class="form-group">
                            <label class="control-label">Select Directorate</label>
                            <select class="form-control custom-select" name="directorate_id" id="select_directorate">
                                <option value="">--Select directorate--</option> 
                                ' . self::getDirectorates() . '
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" style="display:none;" id="maaif_department">
                        <div class="form-group">
                            <label class="control-label">Select Department</label>
                            <select class="form-control custom-select" name="department_id" id="select_department">
                            
                            </select>
                        </div>
                    </div>
                </div>';
        }




        $content .= ' </div>
                                <hr>
                                <div class="form-actions">
                                    <div class="card-body">
                                        <input type ="hidden" name ="user_id" value="' . $data['id'] . '" />
                                        <input type="hidden" name="action" value="processEditUserDetails"/>
                                        <button type="submit" id="confirmButton" class="btn btn-success"> <i class="fa fa-check"></i>Submit changes</button>
                                        <button type="reset" class="btn btn-dark">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>';

        return $content;
    }


    public static function getSelectedDistricts($id)
    {
        $sql = database::performQuery("SELECT district.name,district.id FROM district
                                            ORDER BY name ASC
                                             ");
        $content = '';
        while ($data = $sql->fetch_assoc()) {
            if ($id == $data['id'])
                $content .= '<option value="' . $data['id'] . '" SELECTED>' . ucwords(strtolower($data['name'])) . ' District</option>';
            else
                $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . ' District</option>';
        }
        return $content;
    }

    public static function getSelectedSubCounties($district_id, $subcounty_id)
    {

        $sql = database::performQuery("SELECT subcounty.name,subcounty.id FROM subcounty,county,district
                                              WHERE district.id =county.district_id
                                              AND county.id = subcounty.county_id
                                              AND district_id=$district_id
                                              ORDER BY subcounty.name ASC");
        $content = '';
        while ($data = $sql->fetch_assoc()) {
            if ($subcounty_id == $data['id'])
                $content .= '<option value="' . $data['id'] . '" SELECTED>' . ucwords(strtolower($data['name'])) . ' Subcounty</option>';
            else
                $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . ' Subcounty</option>';
        }
        return $content;
    }

    public static function getSubcountiesFromDistrict($district_id)
    {
        $sql = database::performQuery("SELECT subcounty.name,subcounty.id FROM subcounty,county,district
                                              WHERE district.id =county.district_id
                                              AND county.id = subcounty.county_id
                                              AND district_id=$district_id
                                              ORDER BY subcounty.name ASC");
        $content = '';
        while ($data = $sql->fetch_assoc()) {
            $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['name'])) . ' Subcounty</option>';
        }
        return $content;
    }


    public static function processEditUserDetails()
    {

        $reponse =  array();

        $firstname = database::prepData($_REQUEST['firstname']);
        $lastname = database::prepData($_REQUEST['lastname']);
        $username = database::prepData($_REQUEST['username']);
        $phone = database::prepData($_REQUEST['phone']);
        $email = database::prepData($_REQUEST['email']);
        $gender = database::prepData($_REQUEST['gender']);
        $location = database::prepData($_REQUEST['location_id']) ?? NULL;
        $district = (int)database::prepData($_REQUEST['district_id']) ?? NULL;
        $password = database::prepData($_REQUEST['password']);
        $user_cat = database::prepData($_REQUEST['user_cat']);
        $directorate_id = (int)database::prepData($_REQUEST['directorate_id']) ?? NULL;
        $department_id = (int)database::prepData($_REQUEST['department_id']) ?? NULL;
        $division_id =  (int)database::prepData($_REQUEST['division_id']) ?? NULL;
        $user_id = database::prepData($_REQUEST['user_id']);

        if (empty($district)) {

            $district = 'NULL';
        }

        if (empty($location)) {
            $location = 'NULL';
        }
        if (empty($directorate_id)) {
            $directorate_id = 'NULL';
        }
        if (empty($department_id)) {
            $department_id = 'NULL';
        }
        if (empty($division_id)) {
            $division_id = 'NULL';
        }



        $sql = database::performQuery("UPDATE `user` SET 
        `first_name` = '$firstname', 
        `last_name` = '$lastname', 
        `username` = '$username', 
        `email` = '$email',
        `password` = '$password', 
        `phone` = '$phone', 
        `gender` = '$gender',
        `location_id` = $location,
        `district_id` = $district,
        `user_category_id` = $user_cat,
        `directorate_id` = $directorate_id,
        `department_id` = $department_id,
        `division_id` = $division_id
        WHERE id = $user_id ");


        $response['message'] =  "Data inserted successfully";
        http_response_code(200);
        echo json_encode($response);
    }

    public static function getSelectedDirectorates($id)
    {

        $sql = database::performQuery("SELECT directorate,id FROM directorates
        ORDER BY directorate ASC");

        $content = '';
        while ($data = $sql->fetch_assoc()) {
            if ($id == $data['id'])
                $content .= '<option value="' . $data['id'] . '" SELECTED>' . ucwords(strtolower($data['directorate'])) . ' Directorate</option>';
            else
                $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['directorate'])) . ' Directorate</option>';
        }
        return $content;
    }

    public static function getSelectedDepartments($id)
    {

        $sql = database::performQuery("SELECT department,id FROM departments
        ORDER BY department ASC");

        $content = '';
        while ($data = $sql->fetch_assoc()) {
            if ($id == $data['id'])
                $content .= '<option value="' . $data['id'] . '" SELECTED>' . ucwords(strtolower($data['department'])) . ' Department</option>';
            else
                $content .= '<option value="' . $data['id'] . '">' . ucwords(strtolower($data['department'])) . ' Department</option>';
        }
        return $content;
    }


    public static function verifyAccount($id)
    {

        $content = [
            'content' => '
                    <div class="container py-4">

                        <div class="row mb-2">
                            <div class="col">

                                <div class="card">
                                    <div class="card-body">
                                    
                                        <div class="row">
                                            <div class="col">

                                                <p class="mb-4"><strong>Enter The Verification Code</strong></p>
                                                <!-- form -->
                                                
                                                    <form action="#" id="verify-account" method="POST">

                                                    <div class="row"> 
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Verification Code</label>
                                                            <input type="text" class="form-control text-3 h-auto py-2" name="verification_code" placeholder="Enter verification code" required>
                                                        </div>
                                                        
                                                    </div>

                                                   
                                                    <div class="row">
                                                        <div class="form-group col">
                                                            <input type="hidden" name="user_id" value="' . $id . '"/>
                                                            <input type="hidden" name="action" value="processVerifyAccount">
                                                            <input type="submit" value="Verify Account" class="btn btn-primary btn-modern button-prevent-multiple-submits"  id="confirmButton" data-loading-text="Loading...">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>',
            'styles' => null,
            'scripts' => null
        ];

        return $content;
    }


    public static function processVerifyAccount()
    {

        $verification_code = database::prepData($_REQUEST['verification_code']);
        $user_id = database::prepData($_REQUEST['user_id']);



        $check_verification = database::performQuery("SELECT * FROM `user_verification`
        WHERE verification_code='" . $verification_code . "'
        AND user_id='" . $user_id . "' AND is_active=1");



        if ($check_verification->num_rows == 1) {

            $verification = database::performQuery("UPDATE `user_verification` SET
            `is_active` = 0
            WHERE verification_code='" . $verification_code . "'
            AND user_id='" . $user_id . "' AND is_active=1");



            $user = database::performQuery("UPDATE `user` SET
            `is_verified` = 1
            WHERE id='" . $user_id . "'");



            redirect_to(ROOT . '/');
        } else {
        }
    }
    public static function syncAllDistricts()
    {

        $sql =  database::performQuery("SELECT `id`, `name`, `district_status`, `region_id`, `subregion_id` FROM `district`");

        $districts = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $districts[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["districts"] = $districts;
        echo json_encode($response);
    }

    public static function syncAllCounties()
    {

        $sql =  database::performQuery("SELECT `id`, `name`, `district_id` FROM `county`");

        $counties = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $counties[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["counties"] = $counties;
        echo json_encode($response);
    }

    public static function syncAllSubcounties()
    {

        $sql =  database::performQuery("SELECT `id`, `name`, `county_id` FROM `subcounty`");

        $sub_counties = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $sub_counties[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["sub_counties"] = $sub_counties;
        echo json_encode($response);
    }

    public static function syncAllParishes()
    {

        $sql =  database::performQuery("SELECT `id`, `name`, `subcounty_id` FROM `parish`");

        $parishes = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $parishes[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["parishes"] = $parishes;
        echo json_encode($response);
    }

    public static function syncAllVillages()
    {

        $sql =  database::performQuery("SELECT `id`, `name`, `parish_id` FROM `village`");

        $villages = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $villages[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["villages"] = $villages;
        echo json_encode($response);
    }

    public static function syncParishesByDistrict($id)
    {

        $sql =  database::performQuery("SELECT parish.id, parish.name, parish.subcounty_id FROM parish 
        INNER JOIN subcounty ON parish.subcounty_id = subcounty.id
        INNER JOIN county ON subcounty.county_id = county.id
        INNER JOIN district ON county.district_id = district.id
        WHERE district.id = $id");

        $parishes = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $parishes[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["parishes"] = $parishes;
        echo json_encode($response);
    }
    public static function syncVillagesByDistrict($id)
    {

        $sql =  database::performQuery("SELECT village.id, village.name, village.parish_id FROM village 
        INNER JOIN parish ON village.parish_id = parish.id
        INNER JOIN subcounty ON parish.subcounty_id = subcounty.id
        INNER JOIN county ON subcounty.county_id = county.id
        INNER JOIN district ON county.district_id = district.id
        WHERE district.id = $id");

        $villages = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $villages[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["villages"] = $villages;
        echo json_encode($response);
    }
    public static function syncSubcountiesByDistrict($id)
    {

        $sql =  database::performQuery("SELECT subcounty.id, subcounty.name, subcounty.county_id FROM subcounty 
        INNER JOIN county ON subcounty.county_id = county.id
        INNER JOIN district ON county.district_id = district.id
        WHERE district.id = $id");

        $sub_counties = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $sub_counties[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["sub_counties"] = $sub_counties;
        echo json_encode($response);
    }

    public static function syncCountiesByDistrict($id)
    {

        $sql =  database::performQuery("SELECT county.id, county.name, county.district_id FROM county
        INNER JOIN district ON county.district_id = district.id
        WHERE district.id = $id");

        $counties = [];


        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_assoc()) {

                $counties[] = $data;
            }
        }

        // user farmers are known
        $response["error"] = FALSE;
        $response["counties"] = $counties;
        echo json_encode($response);
    }
}
