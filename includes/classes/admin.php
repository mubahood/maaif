<?php

class admin
{

    public static $widgetColors = [
   'dark','blue','blue-madison','blue-chambray','blue-ebonyclay','blue-hoki','blue-steel','blue-soft','blue-dark','blue-sharp','blue-oleo',
          'green','green-meadow','green-seagreen','green-turquoise','green-haze','green-jungle','green-soft','green-dark','green-sharp','green-steel',
          'grey','grey-steel','grey-cararra','grey-gallery','grey-cascade','grey-silver','grey-salsa','grey-salt','grey-mint',
          'red','red-pink','red-sunglo','red-intense','red-thunderbird','red-flamingo','red-soft','red-haze','red-mint',
          'yellow','yellow-gold','yellow-casablanca','yellow-crusta','yellow-lemon','yellow-saffron','yellow-soft','yellow-haze','yellow-mint',
          'purple','purple-plum','purple-medium','purple-studio','purple-wisteria','purple-seance','purple-intense','purple-sharp','purple-soft'
    ];

    public static function menuSwitch($action){
      $menu = [];
        switch($action){
            case 'admin':
            case 'home':
                $menu[] = ['name'=>'Users','link'=>'manageUsers'];
                $menu[] = ['name'=>'NGOs','link'=>'manageNGOs'];
                $menu[] = ['name'=>'Schools','link'=>'manageSchools'];
                $menu[] = ['name'=>'Suppliers','link'=>'manageSuppiers'];
                $menu[] = ['name'=>'Tutors','link'=>'manageTutors'];
                $menu[] = ['name'=>'Scholarships','link'=>'manageScholarships'];
                $menu[] = ['name'=>'Past Papers','link'=>'managePastPapers'];
                $menu[] = ['name'=>'News','link'=>'manageNews'];
                $menu[] = ['name'=>'Events','link'=>'manageEvents'];


                break;
            case'manageUsers':
                $menu[] = ['name'=>'Add User','link'=>'addUser'];
                $menu[] = ['name'=>'Manage Users','link'=>'manageUsers'];
                $menu[] = ['name'=>'Latest Logins','link'=>'latestLogins'];
                $menu[] = ['name'=>'Most Active Users','link'=>'mostActiveUsers'];
                $menu[] = ['name'=>'Top User Searches','link'=>'topUserSearches'];
                break;
            case'manageSchools':
                $menu[] = ['name'=>'Add School','link'=>'addSchool'];
                $menu[] = ['name'=>'Manage Schools','link'=>'manageSchools'];
                $menu[] = ['name'=>'Edit Schools with ID','link'=>'editSchoolId'];
                $menu[] = ['name'=>'Manage Featured Schools','link'=>'manageFeaturedSchools'];
                $menu[] = ['name'=>'Move Old Schools','link'=>'moveOldSchools'];
                break;
            case'manageNGOs':
                $menu[] = ['name'=>'Add NGO','link'=>'addNGO'];
                $menu[] = ['name'=>'Manage NGOs','link'=>'manageNGOs'];
                $menu[] = ['name'=>'Edit NGOs with ID','link'=>'editNGOId'];
                $menu[] = ['name'=>'Manage Featured NGOs','link'=>'manageFeaturedNGOs'];
                break;
            default:
                break;

        }

     return $menu;

    }
    public static function panel(){

        $content = '
        
            <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN PROFILE SIDEBAR -->
                                                <div class="profile-sidebar">
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light profile-sidebar-portlet ">
                                                        <!-- SIDEBAR USERPIC -->
                                                        <div class="profile-userpic">
                                                            <img src="'.ROOT.'/images/user/'.$_SESSION['user']['photo'].'" class="img-responsive" alt=""> </div>
                                                        <!-- END SIDEBAR USERPIC -->
                                                        <!-- SIDEBAR USER TITLE -->
                                                        <div class="profile-usertitle">
                                                            <div class="profile-usertitle-name"> '.$_SESSION['user']['name'].' (@'.$_SESSION['user']['username'].')</div>
                                                            <div class="profile-usertitle-job"> '.$_SESSION['user']['occupation'].' </div>
                                                        </div>
                                                        <!-- END SIDEBAR USER TITLE -->
                                                        <!-- SIDEBAR BUTTONS -->
                                                        <div class="profile-userbuttons">
                                                            '.user::getUserCategory($_SESSION['user']['id']).'
                                                        </div>
                                                        <!-- END SIDEBAR BUTTONS -->
                                                        <!-- SIDEBAR MENU -->
                                                        <div class="profile-usermenu">
                                                            <ul class="nav">
                                                                <li>
                                                                    <a href="'.ROOT.'/my-profile">
                                                                        <i class="icon-home"></i> Overview </a>
                                                                </li>
                                                                <li class="active">
                                                                    <a href="'.ROOT.'/my-profile/settings">
                                                                        <i class="icon-settings"></i> Admin Panel </a>
                                                                </li>
                                                                 <li>
                                                                    <a href="'.ROOT.'/my-profile/settings">
                                                                        <i class="icon-settings"></i> Account Settings </a>
                                                                </li>
                                                                <li>
                                                                    <a href="'.ROOT.'/my-profile/help">
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
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 5 </div>
                                                                <div class="uppercase profile-stat-text"> Schools Attended </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 10 </div>
                                                                <div class="uppercase profile-stat-text"> Schools Managed </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <!-- END STAT -->
                                                        <div>
                                                            <h4 class="profile-desc-title">About '.$_SESSION['user']['name'].'</h4>
                                                            <span class="profile-desc-text">  '.$_SESSION['user']['bio'].' </span>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-envelope"></i>
                                                                <a href="#">'.$_SESSION['user']['email'].'</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-twitter"></i>
                                                                <a href="'.$_SESSION['user']['twitter'].'/">@'.$_SESSION['user']['twitter'].'</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-facebook"></i>
                                                                <a href="'.$_SESSION['user']['fb'].'/">'.$_SESSION['user']['fb'].'</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                </div>
                                                <!-- END BEGIN PROFILE SIDEBAR -->
                                                <!-- BEGIN PROFILE CONTENT -->
                                                <div class="profile-content">
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                        <div class="row">
                                            ';


                  $count = 0;
                   $use = self::menuSwitch($_SESSION['action']);
                  while($count < count($use))
                  {
                      ($count==0? $color=self::$widgetColors[rand(0,10)]:'');
                      ($count==1? $color=self::$widgetColors[rand(11,20)]:'');
                      ($count==2? $color=self::$widgetColors[rand(21,29)]:'');
                      ($count==3? $color=self::$widgetColors[rand(30,38)]:'');
                      ($count==4? $color=self::$widgetColors[rand(39,46)]:'');
                      ($count==5? $color=self::$widgetColors[rand(47,56)]:'');
                      ($count==6? $color=self::$widgetColors[rand(0,10)]:'');
                      ($count==7? $color=self::$widgetColors[rand(11,20)]:'');
                      ($count==8? $color=self::$widgetColors[rand(21,29)]:'');

                      $content .='<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="dashboard-stat '.$color.'">
                                                    <div class="visual">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number"> '.count(self::$widgetColors).' </div>
                                                        <div class="desc"> '.$use[$count]['name'].'</div>
                                                    </div>
                                                    <a class="more" href="'.ROOT.'/admin/?action='.$use[$count]['link'].'"> View more
                                                        <i class="m-icon-swapright m-icon-white"></i>
                                                    </a>
                                                </div>
                                            </div>';
                      $count++;
                  }


            $content .='
                                        </div>
                                         
                                                    
                                                    
                                                    
                                                    
                                                    
                                                </div>
                                                <!-- END PROFILE CONTENT -->
                                            </div>
                                        </div>
                                    
        
        ';

        return $content;

    }



    public static function countAllUsers(){
        $sql = database::performQuery("SELECT * FROM user WHERE user_cat < 7 ");
        $ret = $sql->fetch_assoc();
        return $ret->num_rows;
    }


    public static function countAllSchools(){
        $sql = database::performQuery("SELECT * FROM school ");
        $ret = $sql->fetch_assoc();
        return $ret->num_rows;
    }


    public static function countAllNews(){
        $sql = database::performQuery("SELECT * FROM article ");
        $ret = $sql->fetch_assoc();
        return $ret->num_rows;
    }


    public static function countAllEvents(){
        $sql = database::performQuery("SELECT * FROM event");
        $ret = $sql->fetch_assoc();
        return $ret->num_rows;
    }



    public static function countAllNGOs(){
        $sql = database::performQuery("SELECT * FROM ngo");
        $ret = $sql->fetch_assoc();
        return $ret->num_rows;
    }



    public static function countAllSuppliers(){
        return 1;
    }


    public static function countAllTutors(){
        return 1;
    }


    public static function countAllScholarships(){
        return 1;
    }

    public static function countAllPastPapers(){
         return 1;
    }








}