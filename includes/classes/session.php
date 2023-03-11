<?php

// A class to help work with Sessions
// In our case, primarily to manage logging users in and out using Twitter Oauth 2.0
class Session
{

    // Contructor
    function __construct()
    {

        if (isset($_REQUEST['action']))
            $_SESSION['action'] = $_REQUEST['action'];
        else
            $_SESSION['action'] = 'home';

        if (!isset($_SESSION['live']))
            $_SESSION['live'] = false;

        if (!isset($_SESSION['main_link']))
            $_SESSION['main_link'] = 1;
        if (!isset($_SESSION['child_link']))
            $_SESSION['child_link'] = 100;

        //Weather Stuff
        if (!isset($_SESSION['location_title']))
            $_SESSION['location_title'] = '';
        if (!isset($_SESSION['next7daysprecamount']))
            $_SESSION['next7daysprecamount'] = '';
        if (!isset($_SESSION['next7daysprecchance']))
            $_SESSION['next7daysprecchance'] = '';
        if (!isset($_SESSION['next7daystempmin']))
            $_SESSION['next7daystempmin'] = '';
        if (!isset($_SESSION['next7daystempmax']))
            $_SESSION['next7daystempmax'] = '';
        if (!isset($_SESSION['next7daysdates']))
            $_SESSION['next7daysdates'] = '';
        if (!isset($_SESSION['weather_title']))
            $_SESSION['weather_title'] = '';
        if (!isset($_SESSION['weather_dates']))
            $_SESSION['weather_dates'] = '';
        if (!isset($_SESSION['weather_crises']))
            $_SESSION['weather_crises'] = '';

  //End weather stuff
if (!isset($_SESSION['outbreak_datefrom']))
            $_SESSION['outbreak_datefrom'] = date("Y-m-d",strtotime("-30 day", strtotime(makeMySQLDate())));
if (!isset($_SESSION['outbreak_dateto']))
            $_SESSION['outbreak_dateto'] = makeMySQLDate();
        if (!isset($_SESSION['outbreaks_title']))
            $_SESSION['outbreaks_title'] = '';
 if (!isset($_SESSION['outbreaks_dates']))
            $_SESSION['outbreaks_dates'] = '';
 if (!isset($_SESSION['outbreaks_outbreaks']))
            $_SESSION['outbreaks_outbreaks'] = '';
 if (!isset($_SESSION['outbreaks_crises']))
            $_SESSION['outbreaks_crises'] = '';
 if (!isset($_SESSION['outbreaks_all']))
            $_SESSION['outbreaks_all'] = 0;
if (!isset($_SESSION['crises_all']))
            $_SESSION['crises_all'] = 0;

//Date Range
        if (!isset($_SESSION['date_from']))
            $_SESSION['date_from'] = '2022-01-01';
        if (!isset($_SESSION['date_to']))
            $_SESSION['date_to'] = '2040-12-31';
//Financial year
        if (!isset($_SESSION['financial_year']))
            $_SESSION['financial_year'] = get_finacial_year_range()['year_range'];

//Quarter
        if (!isset($_SESSION['quarter']))
            $_SESSION['quarter'] = 1;





//         echo'<pre>';
//         print_r($_SESSION);
//         echo'</pre>';

    }


    // Method to logout users
    public static function logOut()
    {
        session_destroy();
        redirect_to(ROOT);
    }


    // Method to add new login
    public function logLogin($user)
    {
        $id = $user->id_str;
        $created = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $ref = $_SERVER['HTTP_REFERER'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $name = database::prepData($user->name);
        $protected = $user->protected;
        $description = database::prepData($user->description);
        $username = $user->screen_name;
        $location = database::prepData($user->location);
        $profile_image_url = $user->profile_image_url;

        $sql = "INSERT INTO `user_login_activity`(`oauth_uid`, `username`, `name`, `bio`, `location`, `protected`, `profile_image_url`, `created`, `ipaddress`, `referer`, `browser`) 
                VALUES ($id,'$username','$name','$description','$location','$protected','$profile_image_url','$created','$ip','$ref','$browser')";
        databaseSec::performQuery($sql);
    }


    public static function login()
    {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login - IgenoSMS.com </title>

  <link href="https%40fonts.googleapis.com/css%40family%3dMontserrat_3A400%2c700.html" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/animate.min.css" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/vendor-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="'.ROOT.'/includes/theme/assets/css/styles.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style=\'background: url("'.ROOT.'/includes/theme/bg.png");\'>
<div class="main-wrapper">
  <div class="an-loader-container">
    <img src="'.ROOT.'/includes/theme/assets/img/loader.png" alt="">
  </div>
  <div class="an-page-content">
    <div class="an-flex-center-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="an-login-container">
              <div class="back-to-home">
                <h3 class="an-logo-heading text-center wow fadeInDown">
                  <a class="an-logo-link" href="'.ROOT.'"><img src="'.ROOT.'/includes/theme/Logo-03.png" width="200"/>
                    <span style="color:#fff">Send SMS Across the World</span>
                  </a>
                </h3>
              </div>
              <div class="an-single-component with-shadow">
                <div class="an-component-header">
                  <h6>Login</h6>
                  <div class="component-header-right">
                    <p class="sign-up-link">Don\'t have account? <a href="'.ROOT.'/?action=register">Sign Up</a></p>
                  </div>
                </div>
                <div class="an-component-body">
                  <form action="#" method="POST">
                    <label>Email</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-ios-email-outline"></i></div>
                      <input type="email" name="email" class="an-form-control">
                    </div>

                    <label>Password</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-key"></i></div>
                      <input type="password" name="password" class="an-form-control">
                    </div>

                    <div class="remembered-section">
                          <span class="an-custom-checkbox">
                            <input type="checkbox" id="check-1">
                            <label for="check-1">Remember me</label>
                          </span>
                      <a href="'.ROOT.'/?action=forgotpasswd">Forgot password?</a>
                    </div>
                    <input type="hidden" name="action" value="doLogin" />
                    <button class="an-btn an-btn-default fluid" style="background-color:#18457B">Log In</button>
                  </form>

                </div> <!-- end .AN-COMPONENT-BODY -->
              </div> <!-- end .AN-SINGLE-COMPONENT -->
            </div> <!-- end an-login-container -->
          </div>
        </div> <!-- end row -->
      </div>
    </div> <!-- end an-flex-center-center -->
  </div> <!-- end .AN-PAGE-CONTENT -->
  <footer class="an-footer">
    <p>COPYRIGHT '.date('Y',time()).'  &copy IGENO LTD. ALL RIGHTS RESERVED</p>
  </footer> <!-- end an-footer -->

</div> <!-- end .MAIN-WRAPPER -->
<script src="'.ROOT.'/includes/theme/assets/js-plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/bootstrap.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/wow.min.js" type="text/javascript"></script>

<!--  MAIN SCRIPTS START FROM HERE  above scripts from plugin   -->
<script src="'.ROOT.'/includes/theme/assets/js/scripts.js" type="text/javascript"></script>
</body>

</html>
';
    }



    public static function wrongLogin()
    {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wrong Login - IgenoSMS.com </title>

  <link href="https%40fonts.googleapis.com/css%40family%3dMontserrat_3A400%2c700.html" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/animate.min.css" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/vendor-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="'.ROOT.'/includes/theme/assets/css/styles.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style=\'background: url("'.ROOT.'/includes/theme/bg.png");\'>
<div class="main-wrapper">
  <div class="an-loader-container">
    <img src="'.ROOT.'/includes/theme/assets/img/loader.png" alt="">
  </div>
  <div class="an-page-content">
    <div class="an-flex-center-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="an-login-container">
              <div class="back-to-home">
                <h3 class="an-logo-heading text-center wow fadeInDown">
                  <a class="an-logo-link" href="'.ROOT.'"><img src="'.ROOT.'/includes/theme/Logo-03.png" width="200"/>
                    <span style="color:#fff">Send SMS Across the World</span>
                  </a>
                </h3>
              </div>
              <div class="an-single-component with-shadow">
                <div class="an-component-header">
                  <h6>Login</h6>
                  <div class="component-header-right">
                    <p class="sign-up-link">Don\'t have account? <a href="'.ROOT.'/?action=register">Sign Up</a></p>
                  </div>
                </div>
                <div class="an-component-body">
                
                 <div class="an-helper-block">
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <strong>Error!</strong> Wrong Email or Password. Login Failed. Try to login again below.
                  </div>
                  </div>
                  
                  <br />
                  <br />
             
                  <form action="#" method="POST">
                    <label>Email</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-ios-email-outline"></i></div>
                      <input type="email" name="email" class="an-form-control">
                    </div>

                    <label>Password</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-key"></i></div>
                      <input type="password" name="password" class="an-form-control">
                    </div>

                    <div class="remembered-section">
                          <span class="an-custom-checkbox">
                            <input type="checkbox" id="check-1">
                            <label for="check-1">Remember me</label>
                          </span>
                      <a href="'.ROOT.'/?action=forgotpasswd">Forgot password?</a>
                    </div>
                    <input type="hidden" name="action" value="doLogin" />
                    <button class="an-btn an-btn-default fluid" style="background-color:#18457B">Log In</button>
                  </form>

                </div> <!-- end .AN-COMPONENT-BODY -->
              </div> <!-- end .AN-SINGLE-COMPONENT -->
            </div> <!-- end an-login-container -->
          </div>
        </div> <!-- end row -->
      </div>
    </div> <!-- end an-flex-center-center -->
  </div> <!-- end .AN-PAGE-CONTENT -->
  <footer class="an-footer">
    <p>COPYRIGHT '.date('Y',time()).'  &copy IGENO LTD. ALL RIGHTS RESERVED</p>
  </footer> <!-- end an-footer -->

</div> <!-- end .MAIN-WRAPPER -->
<script src="'.ROOT.'/includes/theme/assets/js-plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/bootstrap.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/wow.min.js" type="text/javascript"></script>

<!--  MAIN SCRIPTS START FROM HERE  above scripts from plugin   -->
<script src="'.ROOT.'/includes/theme/assets/js/scripts.js" type="text/javascript"></script>
</body>

</html>
';
    }


    public static function forgotpass()
    {
        echo '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password - IgenoSMS.com </title>

  <link href="https%40fonts.googleapis.com/css%40family%3dMontserrat_3A400%2c700.html" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/animate.min.css" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/vendor-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="'.ROOT.'/includes/theme/assets/css/styles.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style=\'background: url("'.ROOT.'/includes/theme/bg.png");\'>
<div class="main-wrapper">
  <div class="an-loader-container">
    <img src="'.ROOT.'/includes/theme/assets/img/loader.png" alt="">
  </div>
  <div class="an-page-content">
    <div class="an-flex-center-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="an-login-container">
              <div class="back-to-home">
                <h3 class="an-logo-heading text-center wow fadeInDown">
                  <a class="an-logo-link" href="'.ROOT.'"><img src="'.ROOT.'/includes/theme/Logo-03.png" width="200"/>
                    <span style="color:#fff">Send SMS Across the World</span>
                  </a>
                </h3>
              </div>
              <div class="an-single-component with-shadow">
                <div class="an-component-header">
                  <h6>Forgot Password</h6>
                  <div class="component-header-right">
                    <p class="sign-up-link">Have account? <a href="'.ROOT.'/?action=login">Login</a></p>
                  </div>
                </div>
                <div class="an-component-body">
              
                  <form action="#">
                    <label>Email</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-ios-email-outline"></i></div>
                      <input type="email" name="email" class="an-form-control">
                    </div>

                    <input type="hidden" name="action" value="doForgotPassword" />
                    <button class="an-btn an-btn-default fluid"  style="background-color:#18457B">Send Password</button>
                  </form>

                </div> <!-- end .AN-COMPONENT-BODY -->
              </div> <!-- end .AN-SINGLE-COMPONENT -->
            </div> <!-- end an-login-container -->
          </div>
        </div> <!-- end row -->
      </div>
    </div> <!-- end an-flex-center-center -->
  </div> <!-- end .AN-PAGE-CONTENT -->
  <footer class="an-footer">
    <p>COPYRIGHT '.date('Y',time()).'  &copy IGENO LTD. ALL RIGHTS RESERVED</p>
  </footer> <!-- end an-footer -->

</div> <!-- end .MAIN-WRAPPER -->
<script src="'.ROOT.'/includes/theme/assets/js-plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/bootstrap.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/wow.min.js" type="text/javascript"></script>

<!--  MAIN SCRIPTS START FROM HERE  above scripts from plugin   -->
<script src="'.ROOT.'/includes/theme/assets/js/scripts.js" type="text/javascript"></script>
</body>

</html>
';
    }


    public static function successSentPasswd()
    {
        echo '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password - IgenoSMS.com </title>

  <link href="https%40fonts.googleapis.com/css%40family%3dMontserrat_3A400%2c700.html" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/animate.min.css" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/vendor-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="'.ROOT.'/includes/theme/assets/css/styles.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style=\'background: url("'.ROOT.'/includes/theme/bg.png");\'>
<div class="main-wrapper">
  <div class="an-loader-container">
    <img src="'.ROOT.'/includes/theme/assets/img/loader.png" alt="">
  </div>
  <div class="an-page-content">
    <div class="an-flex-center-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="an-login-container">
              <div class="back-to-home">
                <h3 class="an-logo-heading text-center wow fadeInDown">
                  <a class="an-logo-link" href="'.ROOT.'"><img src="'.ROOT.'/includes/theme/Logo-03.png" width="200"/>
                    <span style="color:#fff">Send SMS Across the World</span>
                  </a>
                </h3>
              </div>
              <div class="an-single-component with-shadow">
                <div class="an-component-header">
                  <h6>Successfully Sent Password</h6>
                 
                </div>
                <div class="an-component-body">
              
                 <div class="an-helper-block">
                 
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <strong>Success!</strong> We have emailed you your password at '.$_REQUEST['email'].'.
                  <br />
                  Follow this link to <a href="'.ROOT.'?action=login">LOGIN</a>.
                  
                </div>

              </div>

                </div> <!-- end .AN-COMPONENT-BODY -->
              </div> <!-- end .AN-SINGLE-COMPONENT -->
            </div> <!-- end an-login-container -->
          </div>
        </div> <!-- end row -->
      </div>
    </div> <!-- end an-flex-center-center -->
  </div> <!-- end .AN-PAGE-CONTENT -->
  <footer class="an-footer">
    <p>COPYRIGHT '.date('Y',time()).'  &copy IGENO LTD. ALL RIGHTS RESERVED</p>
  </footer> <!-- end an-footer -->

</div> <!-- end .MAIN-WRAPPER -->
<script src="'.ROOT.'/includes/theme/assets/js-plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/bootstrap.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/wow.min.js" type="text/javascript"></script>

<!--  MAIN SCRIPTS START FROM HERE  above scripts from plugin   -->
<script src="'.ROOT.'/includes/theme/assets/js/scripts.js" type="text/javascript"></script>
</body>

</html>
';
    }


    public static function unknownAccount()
    {
        echo '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password - IgenoSMS.com </title>

  <link href="https%40fonts.googleapis.com/css%40family%3dMontserrat_3A400%2c700.html" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/animate.min.css" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/vendor-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="'.ROOT.'/includes/theme/assets/css/styles.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style=\'background: url("'.ROOT.'/includes/theme/bg.png");\'>
<div class="main-wrapper">
  <div class="an-loader-container">
    <img src="'.ROOT.'/includes/theme/assets/img/loader.png" alt="">
  </div>
  <div class="an-page-content">
    <div class="an-flex-center-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="an-login-container">
              <div class="back-to-home">
                <h3 class="an-logo-heading text-center wow fadeInDown">
                  <a class="an-logo-link" href="'.ROOT.'"><img src="'.ROOT.'/includes/theme/Logo-03.png" width="200"/>
                    <span style="color:#fff">Send SMS Across the World</span>
                  </a>
                </h3>
              </div>
              <div class="an-single-component with-shadow">
                <div class="an-component-header">
                  <h6>Forgot Password</h6>
                  <div class="component-header-right">
                    <p class="sign-up-link">Have account? <a href="'.ROOT.'/?action=login">Login</a></p>
                  </div>
                </div>
                <div class="an-component-body">
              
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <strong>Error!</strong> We have no account associated with '.$_REQUEST['email'].' email. <br /><br /> Try too reset your account password with the link below.
                  <br />
                  <br />
                  Follow this link to <a href="'.ROOT.'?action=forgotpasswd"> RESET YOUR PASSWORD</a>.
                  
                </div>

                </div> <!-- end .AN-COMPONENT-BODY -->
              </div> <!-- end .AN-SINGLE-COMPONENT -->
            </div> <!-- end an-login-container -->
          </div>
        </div> <!-- end row -->
      </div>
    </div> <!-- end an-flex-center-center -->
  </div> <!-- end .AN-PAGE-CONTENT -->
  <footer class="an-footer">
    <p>COPYRIGHT '.date('Y',time()).'  &copy IGENO LTD. ALL RIGHTS RESERVED</p>
  </footer> <!-- end an-footer -->

</div> <!-- end .MAIN-WRAPPER -->
<script src="'.ROOT.'/includes/theme/assets/js-plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/bootstrap.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/wow.min.js" type="text/javascript"></script>

<!--  MAIN SCRIPTS START FROM HERE  above scripts from plugin   -->
<script src="'.ROOT.'/includes/theme/assets/js/scripts.js" type="text/javascript"></script>
</body>

</html>
';
    }


    public static function register()
    {
        echo '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account - IgenoSMS.com </title>

  <link href="https%40fonts.googleapis.com/css%40family%3dMontserrat_3A400%2c700.html" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/animate.min.css" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/vendor-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="'.ROOT.'/includes/theme/assets/css/styles.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style=\'background: url("'.ROOT.'/includes/theme/bg.png");\'>
<div class="main-wrapper">
  <div class="an-loader-container">
    <img src="'.ROOT.'/includes/theme/assets/img/loader.png" alt="">
  </div>
  <div class="an-page-content">
    <div class="an-flex-center-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="an-login-container">
              <div class="back-to-home">
                <h3 class="an-logo-heading text-center wow fadeInDown">
                  <a class="an-logo-link" href="'.ROOT.'"><img src="'.ROOT.'/includes/theme/Logo-03.png" width="200"/>
                    <span style="color:#fff">Send SMS Across the World</span>
                  </a>
                </h3>
              </div>
              <div class="an-single-component with-shadow">
                <div class="an-component-header">
                  <h6>Sign Up</h6>
                  <div class="component-header-right">
                    <p class="sign-up-link">Already member? <a href="'.ROOT.'/?action=login">Log In</a></p>
                  </div>
                </div>
                <div class="an-component-body">
                  <form action="#" method="GET">
                    <label>Which Country are you located in?</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-flag"></i></div>
                     
                     <select class="an-form-control" name="country_id">
                  
                </select>
                     
                    </div>
                    
                    <label>First Name</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-person"></i></div>
                      <input type="text" name="firstname" class="an-form-control">
                    </div>

                    <label>Last Name</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-person"></i></div>
                      <input type="text" name="lastname" class="an-form-control">
                    </div>

                    <label>Email</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-ios-email-outline"></i></div>
                      <input type="email" name="email" class="an-form-control">
                    </div>

                    <label>Password</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-key"></i></div>
                      <input type="password" name="password" class="an-form-control">
                    </div>

                    <div class="remembered-section no-flex">
                          <span class="an-custom-radiobox">
                            <input type="radio" name="gender" value="M" id="radio-1" checked>
                            <label for="radio-1">Male</label>
                          </span>
                      <span class="an-custom-radiobox">
                            <input type="radio" name="gender" value="F" id="radio-2">
                            <label for="radio-2">Female</label>
                          </span>
                    </div>
                    <input type="hidden" name="action" value="doRegister" />

                    <button type="submit" class="an-btn an-btn-default fluid"  style="background-color:#18457B">Sign Up</button>
                  </form>

                </div> <!-- end .AN-COMPONENT-BODY -->
              </div> <!-- end .AN-SINGLE-COMPONENT -->
            </div> <!-- end an-login-container -->
          </div>
        </div> <!-- end row -->
      </div>
    </div>
  </div> <!-- end .AN-PAGE-CONTENT -->
  <footer class="an-footer">
    <p>COPYRIGHT '.date('Y',time()).'  &copy IGENO LTD. ALL RIGHTS RESERVED</p>
  </footer> <!-- end an-footer -->

</div> <!-- end .MAIN-WRAPPER -->
<script src="'.ROOT.'/includes/theme/assets/js-plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/bootstrap.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/wow.min.js" type="text/javascript"></script>

<!--  MAIN SCRIPTS START FROM HERE  above scripts from plugin   -->
<script src="'.ROOT.'/includes/theme/assets/js/scripts.js" type="text/javascript"></script>
</body>

</html>
';
    }



    public static function emailExistsErr()
    {
        echo '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account - IgenoSMS.com </title>

  <link href="https%40fonts.googleapis.com/css%40family%3dMontserrat_3A400%2c700.html" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/animate.min.css" rel="stylesheet">
  <link href="'.ROOT.'/includes/theme/assets/css/vendor-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="'.ROOT.'/includes/theme/assets/css/styles.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style=\'background: url("'.ROOT.'/includes/theme/bg.png");\'>
<div class="main-wrapper">
  <div class="an-loader-container">
    <img src="'.ROOT.'/includes/theme/assets/img/loader.png" alt="">
  </div>
  <div class="an-page-content">
    <div class="an-flex-center-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="an-login-container">
              <div class="back-to-home">
                <h3 class="an-logo-heading text-center wow fadeInDown">
                  <a class="an-logo-link" href="'.ROOT.'"><img src="'.ROOT.'/includes/theme/Logo-03.png" width="200"/>
                    <span style="color:#fff">Send SMS Across the World</span>
                  </a>
                </h3>
              </div>
              <div class="an-single-component with-shadow">
                <div class="an-component-header">
                  <h6>Sign Up</h6>
                  <div class="component-header-right">
                    <p class="sign-up-link">Already member? <a href="'.ROOT.'/?action=login">Log In</a></p>
                  </div>
                </div>
                <div class="an-component-body">
                
                
                 <div class="alert alert-warning alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <strong>warning!</strong> The email '.$_REQUEST['email'].' you\'re trying to signup with is already associated with an account.
                  <br />
                  <br />
                  Follow this link to  <a href="'.ROOT.'?action=forgotpasswd">RESET YOUR PASSWORD</a> or <a href="'.ROOT.'?action=login">LOGIN</a>. 
                  <br />
                  <br />
                  You can also create an account with the form below.
                  
                </div>
                
                
                <br />
                
                
                  <form action="#" method="GET">
                    <label>Which Country are you located in?</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-flag"></i></div>
                     
                     <select class="an-form-control" name="country_id">
                  
                </select>
                     
                    </div>
                    
                    <label>First Name</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-person"></i></div>
                      <input type="text" name="firstname" class="an-form-control">
                    </div>

                    <label>Last Name</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-person"></i></div>
                      <input type="text" name="lastname" class="an-form-control">
                    </div>

                    <label>Email</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-ios-email-outline"></i></div>
                      <input type="email" name="email" class="an-form-control">
                    </div>

                    <label>Password</label>
                    <div class="an-input-group">
                      <div class="an-input-group-addon"><i class="ion-key"></i></div>
                      <input type="password" name="password" class="an-form-control">
                    </div>

                    <div class="remembered-section no-flex">
                          <span class="an-custom-radiobox">
                            <input type="radio" name="gender" value="M" id="radio-1" checked>
                            <label for="radio-1">Male</label>
                          </span>
                      <span class="an-custom-radiobox">
                            <input type="radio" name="gender" value="F" id="radio-2">
                            <label for="radio-2">Female</label>
                          </span>
                    </div>
                    <input type="hidden" name="action" value="doRegister" />

                    <button type="submit" class="an-btn an-btn-default fluid"  style="background-color:#18457B">Sign Up</button>
                  </form>

                </div> <!-- end .AN-COMPONENT-BODY -->
              </div> <!-- end .AN-SINGLE-COMPONENT -->
            </div> <!-- end an-login-container -->
          </div>
        </div> <!-- end row -->
      </div>
    </div>
  </div> <!-- end .AN-PAGE-CONTENT -->
  <footer class="an-footer">
    <p>COPYRIGHT '.date('Y',time()).'  &copy IGENO LTD. ALL RIGHTS RESERVED</p>
  </footer> <!-- end an-footer -->

</div> <!-- end .MAIN-WRAPPER -->
<script src="'.ROOT.'/includes/theme/assets/js-plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/bootstrap.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="'.ROOT.'/includes/theme/assets/js-plugins/wow.min.js" type="text/javascript"></script>

<!--  MAIN SCRIPTS START FROM HERE  above scripts from plugin   -->
<script src="'.ROOT.'/includes/theme/assets/js/scripts.js" type="text/javascript"></script>
</body>

</html>
';
    }

    //Handle Login of Users
    public static function doLogin()
    {

        $email = database::prepData($_REQUEST['username']);
        $password = database::prepData($_REQUEST['password']);
        $sql = "SELECT * 
        FROM user
        WHERE (username LIKE '$email' OR email='$email')  AND `password`='$password' 
        LIMIT 0,1";
        $result = Database::performQuery($sql); 
        if ($result->num_rows == 1) {
       
            while ($data = $result->fetch_assoc()) {

              if($data['is_verified'] == 0){
                redirect_to(ROOT . '/?action=verifyAccount&verification='.$data['id']);
              }
              else{
                $_SESSION['live'] = true;
                $_SESSION['user'] = $data;
                redirect_to(ROOT.'/?action=home');
              }
              
            }

            
        } else {
            redirect_to(ROOT . '/');
        }


    }

    //Handle Login of Users
    public static function auth()
    {

        $id = database::prepData($_REQUEST['uid']);
       $sql = "SELECT * 
        FROM user
        WHERE id=$id
        LIMIT 0,1";
        $result = Database::performQuery($sql);
        if ($result->num_rows == 1) {
            while ($data = $result->fetch_assoc()) {
                $_SESSION['live'] = true;
                $_SESSION['user'] = $data;
                redirect_to(ROOT.'/?action=home');
            }
        } else {
            redirect_to(ROOT . '/');
        }


    }

    public static function getUserFromDB($email,$password){



        // get the user by email and password
        $sql = "SELECT * 
                    FROM user
                    WHERE (username LIKE '$email' OR email='$email')  AND `password`='$password'
                    LIMIT 0,1";
        $result = Database::performQuery($sql);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();

        }
        else
            return NULL;
    }

    public static function getDistrictName($id){

        $sql = database::performQuery("SELECT name FROM district WHERE id=$id");
        $ret = $sql->fetch_assoc();

        return $ret['name'];
    }

    //Handle Login of Users
    public static function doLoginApi()
    {


        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {

            // receiving the REQUEST params
            $email = database::prepData($_REQUEST['email']);
            $password = database::prepData($_REQUEST['password']);

            $user = self::getUserFromDB($email,$password);

//            echo'<pre>';
//            print_r($user);

            if ($user != false) {

                // echo json_encode($user);
                // use is found
                $response["error"] = FALSE;
                $response["user"]["first_name"] = ucwords(strtolower($user["first_name"]));
                $response["user"]["last_name"] = ucwords(strtolower($user["last_name"]));
                $response["user"]["username"] = $user["username"];
                $response["user"]["phone"] = $user["phone"];
                $response["user"]["subcounty"] = ucwords(strtolower(subcounty::getSubcountyName($user["location_id"])));
                $response["user"]["district_id"] = $user["district_id"];
                $response["user"]["district"] = ucwords(strtolower(self::getDistrictName($user["district_id"])));
                $response["user"]["email"] = $user["email"];
                $response["user"]["password"] = md5($user["password"]);
                $response["user"]["created"] = $user["created"];
                $response["user"]["gender"] = $user["gender"];
                $response["user"]["photo"] = $user["photo"];
                $response["user"]["user_category"] = ucwords(strtolower(user::getUserCategory($user["user_category_id"])));
                $response["user"]["user_category_id"] = $user["user_category_id"];
                $response["user"]["uid"] = $user["id"];

                echo json_encode($response);
            } else {
                // user is not found with the credentials
                $response["error"] = TRUE;
                $response["error_msg"] = "Login credentials are wrong. Please try again!";
                echo json_encode($response);
            }
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters email or password is missing!";
            echo json_encode($response);
        }


    }





    public static function getUserFromDB2($email,$password){

        $con  =new mysqli('localhost','root','','acdp.grm');

        // get the user by email and password
        $sql = "SELECT * 
                    FROM user
                    WHERE username LIKE '$email' AND password LIKE '$password'
                    LIMIT 0,1";
        $result = $con->query($sql);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();

        }
        else
            return NULL;
    }

    //Handle Login of Users
    public static function doLoginApi2()
    {


        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {

            // receiving the REQUEST params
            $email = database2::prepData($_REQUEST['email']);
            $password = md5(database2::prepData($_REQUEST['password']));


            $user = self::getUserFromDB2($email,$password);

//         echo'<pre>';
//         print_r($user);
//         print_r($_REQUEST);

            if ($user != false) {

                // echo json_encode($user);
                // use is found
                $response["error"] = FALSE;
                $response["user"]["name"] = ucwords(strtolower($user["name"]));
                $response["user"]["position"] = ucwords(strtolower($user["position"]));
                $response["user"]["username"] = $user["username"];
                $response["user"]["phone"] = $user["phone"];
                $response["user"]["parish"] = ucwords(strtolower(self::getLocationByParish($user["parish_id"])['parish']));
                $response["user"]["parish_id"] = $user["parish_id"];
                $response["user"]["subcounty"] = ucwords(strtolower(self::getLocationByParish($user["parish_id"])['subcounty']));
                $response["user"]["district"] = ucwords(strtolower(self::getLocationByParish($user["parish_id"])['district']));
                $response["user"]["village"] = $user["village"];
                $response["user"]["pic"] = $user["pic"];
                $response["user"]["user_category"] = ucwords(strtolower(user::getUserCategory($user["user_category_id"])));
                $response["user"]["user_category_id"] = $user["user_category_id"];
                $response["user"]["uid"] = $user["id"];

                echo json_encode(json_decode(json_encode($response)));
            } else {
                // user is not found with the credentials
                $response["error"] = TRUE;
                $response["error_msg"] = "Login credentials are wrong. Please try again!";
                echo json_encode($response);
            }
        } else {
            // required REQUEST params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters email or password is missing!";
            echo json_encode($response);
        }


    }

    public static function getLocationByParish($id){
        $sql = database2::performQuery("SELECT district.name as district, subcounty.name as subcounty, parish.name as parish FROM
                                            district,county,subcounty,parish WHERE
                                            district.id = county.district_id AND 
                                            county.id = subcounty.county_id AND 
                                            subcounty.id = parish.subcounty_id AND 
                                            parish.id = $id ");

        return $sql->fetch_assoc();

    }


    //Handle Login of Users
    public static function doForgotPassword()
    {

        $email = database::prepData($_REQUEST['email']);
         $sql = "SELECT * 
        FROM user
        WHERE email='$email'
        LIMIT 0,1";
        $result = Database::performQuery($sql);
        if ($result->num_rows == 1) {
            while ($data = $result->fetch_assoc()) {
               //TODO Send email with Password here

                //Go to successfully sent password dialogue
                 redirect_to(ROOT.'/?action=successSentPasswd&email='.$email);
            }
        } else {
            redirect_to(ROOT . '/?action=nonExistantAccount&email='.$email);
        }


    }

    //Check if email exists
    public static function emailExists($email){
        $email = database::prepData($_REQUEST['email']);
        $sql = database::performQuery("SELECT email FROM user WHERE email='$email'");
        if($sql->num_rows > 0)
            redirect_to(ROOT.'/?action=emailExists&email='.$email);
    }

    //Handle Registration of Users
    public static function doRegistration()
    {

        // Prep Values
        $firstname = database::prepData($_REQUEST['firstname']);
        $lastname = database::prepData($_REQUEST['lastname']);
        $gender = database::prepData($_REQUEST['gender']);
        $email = database::prepData($_REQUEST['email']);
        $country_id = database::prepData($_REQUEST['country_id']);
        $password = database::prepData($_REQUEST['password']);
        $joined = makeMySQLDateTime();
        $usercategory_id = 1;

        //Check if email exists and redirect to failed registration if it exists.
        self::emailExists($email);


        $sql = "
        INSERT INTO `user`(`id`, `usercategory_id`, `firstname`, `lastname`, `email`, `password`, `gender`, `isBanned`,country_id)
        VALUES('','$usercategory_id','$firstname','$lastname','$email','$password','$gender',0,'$country_id')";
        echo $sql;
        $result = Database::performQuery($sql);
        $id = database::getLastInsertID();
        $sql = database::performQuery("SELECT * FROM user WHERE id=$id");
        while ($data = $sql->fetch_assoc()) {
            $_SESSION['live'] = true;
            $_SESSION['user'] = $data;
            redirect_to(ROOT.'/dashboard?action=completeRegistration&id='.$id);
        }


    }


    //Handle Registration of Users
    public static function completeReg()
    {

        // Prep Values
        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $username = database::prepData($_REQUEST['username']);
        $dob = database::prepData($_REQUEST['year']).'-'.database::prepData($_REQUEST['month']).'-'.database::prepData($_REQUEST['day']);
        $country = database::prepData($_REQUEST['country']);
        $city = database::prepData($_REQUEST['city']);
        $phone = '+'.database::prepData($_REQUEST['code']).'-'.database::prepData($_REQUEST['phone']);
        $bio = database::prepData($_REQUEST['bio']);
        $occupation = database::prepData($_REQUEST['occupation']);
        $twitter = database::prepData($_REQUEST['tw']);
        $facebook = database::prepData($_REQUEST['fb']);


        $sql = "
        UPDATE `user` 
        SET 
        `name`='$name',
        `username`='$username',
        `dob`='$dob',
        `country_short_code`='$country',
        `city`='$city',
        `phone`='$phone',
        `bio`='$bio',
        `occupation`='$occupation',
        `fb`='$facebook',
        `twitter`='$twitter'
        WHERE
        id=$id
        ";
        $result = Database::performQuery($sql);
        $sql = database::performQuery("SELECT * FROM user WHERE id=$id");
        while ($data = $sql->fetch_assoc()) {
            $_SESSION['live'] = true;
            $_SESSION['user'] = $data;
            redirect_to(ROOT.'?action=profile');
        }


    }

    //Handle PasswordReset of Users
    public static function doResetPassword()
    {


    }


}

// Create New Session Here
$session = new Session();


