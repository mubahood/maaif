
<?php

$title = "Agricultural Extension and Advisory System";

$sub = "";

$content = "";

$dashboard = new dashboard();

switch ($_SESSION['action']) {

    // Show front end home page/ Site's Home page



    case 'home':

        $content = content::home();

        $dashboard->template($title, $sub, $content);

        break;

    case 'newhome':

        dashboard::LetsLogin();

        break;


    case 'NoActivityYet':

        $content = content::NoActivityYet();

        $dashboard->template($title, $sub, $content);

        break;

    case 'addUsers':
        $content = user::addNewUsers();
        $title = "Add New Users";
        $dashboard->template($title, $sub, $content);
        break;

      case 'prepGRMReport':
        $content = user::prepGRMReport();
        $title = "Prep New GRM Report";
        $dashboard->template($title, $sub, $content);
        break;
  case 'processNewGRMReport':
        $content = user::processNewGRMReport();
        $title = "GRM Report";
        $dashboard->template($title, $sub, $content);
        break;
  case 'addMeeting':
        $content = user::addNewMeeting();
        $title = "Add New Meetings";
        $dashboard->template($title, $sub, $content);
        break;

case 'addNewWorkplan':
        $content = user::addNewWorkplan();
        $title = "Add New Annual Workplan";
        $dashboard->template($title, $sub, $content);
        break;


    case 'processNewUser':
        user::processNewUser();

        break;

    case 'processNewMeeting':
        user::processNewMeeting();

        break;


    case 'sendUserLogin':
        user::sendUserLogins();

    break;
  case 'processNewAnnualKO':
        user::processNewAnnualKO();

        break;

  case 'processAnnualObjectives':
        user::processAnnualObjectives();

        break;
 case 'processAnnualActivities':
        user::processAnnualActivities();

        break;

    case 'manageUsers':
        $content = user::manageUsers();
        $title = "Manage Users";
        $dashboard->template($title, $sub, $content);
        break;

    case 'manageMeetings':
        $content = user::manageMeetings();
        $title = "Manage Meetings";
        $dashboard->template($title, $sub, $content);
        break;

    case'viewEOReport';

        $content = reportList::prepeExtensionofficerReport($_REQUEST['id']);
        $title = "View Report";
        $dashboard->template($title, $sub, $content);
    break;


    case 'viewaGRMGrievance':
        $content = user::manageGrievances();
        $title = "Manage Grievances in my location";
        $dashboard->template($title, $sub, $content);
        break;

    case 'escalateGrievance':
        user::escalateGrievance();
        break;


    case 'responseGrievance':
        user::responseGrievance();
        break;


    case 'fileGrievance':
        user::fileGrievance();
        break;

    case 'viewaGRMReport':
        $content = user::viewGRMReport();
        $title = "View Grievance Redress Mechanism Report in my location";
        $dashboard->template($title, $sub, $content);
        break;

    case 'manageWorkplans':
        $content = user::manageUsersWorkplan();
        $title = "Manage Extension Officers  Workplans";
        $dashboard->template($title, $sub, $content);
        break;

    case 'manageWorkplans2':
        $content = user::manageUsersWorkplanSMS();
        $title = "Manage Subject Matter Specialists Workplans";
        $dashboard->template($title, $sub, $content);
        break;

    case 'manageWorkplansButtons':
        $content = user::manageUsersWorkplanButtons();
        $title = "Manage User Workplans";
        $dashboard->template($title, $sub, $content);
        break;


    case 'manageUsersButtons':
        $content = user::manageUsersButtons();
        $title = "Manage Users";
        $dashboard->template($title, $sub, $content);
        break;



    case 'manageDistrictReportingButtons':
        $content = user::manageDistrictReportsButtons();
        $title = "View Districts Reports";
        $dashboard->template($title, $sub, $content);
        break;


    case 'manageZonalReportingButtons':
        $content = user::manageZonalReportsButtons();
        $title = "View Districts Reports";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editUserActivityQuarterly';
    $content = user::editUserActivityQuarterly($_REQUEST['id'], $_REQUEST['user_id']);
    $title = "Edit User Quarterly Activities";
    $dashboard->template($title, $sub, $content);
    break;

    case 'processingEditQuarterlyActivities':

    user::processingEditQuarterlyActivities();

    break;


    case 'addAnnualObjectives':
        $content = user::addAnnualObjectives();
        $title = "Add Annual Output";
        $dashboard->template($title, $sub, $content);
        break;
   case 'viewUserObjectives':
        $content = user::viewUserObjectives($_REQUEST['id']);
        $title = "View User Annual Output";
        $dashboard->template($title, $sub, $content);
        break;
  case 'viewUserWorkplan':
        $content = user::viewUserWorkplan($_REQUEST['id']);
        $title = "View User workplan";
        $dashboard->template($title, $sub, $content);
        break;
        case 'viewAnnualActivities':
        $content = user::viewAnnualActivities($_REQUEST['id']);
        $title = "View User Annual Activities";
        $dashboard->template($title, $sub, $content);
        break;
     case 'viewQuarterlyActivities':
        $content = user::viewQuarterlyActivities($_REQUEST['id']);
        $title = "View User Quarterly Activities";
        $dashboard->template($title, $sub, $content);
        break;
 case 'manageAnnualObjectives':
        $content = user::manageAnnualObjectivesNew();
        $title = "Manage Annual Objectives";
        $dashboard->template($title, $sub, $content);
        break;

    case 'manageAnnualActivities':
        $content = user::addAnnualActivities();
        $title = "Add Annual Activities";
        $dashboard->template($title, $sub, $content);
        break;


    case 'manageQuarterlyActivities':
        $content = user::manageQuaterlyActivities();
        $title = "Add Quarterly Activities";
        $dashboard->template($title, $sub, $content);
        break;
  case 'manageAnnualActivitiesNew':
        $content = user::manageUsersAnnualActivitiesNew();
        $title = "Manage Users Annual Activities";
        $dashboard->template($title, $sub, $content);
        break;


    case 'manageQuarterlyActivitiesNew':
        $content = user::manageUsersQuarterlyActivitiesNew();
        $title = "Manage Users Quarterly Activities";
        $dashboard->template($title, $sub, $content);
        break; 


    case 'manageQuarterlyActivitiesNew2':
        $content = user::manageUsersQuarterlyActivitiesNew2();
        $title = "Manage Users Quarterly Activities";
        $dashboard->template($title, $sub, $content);
        break;

    case 'manageQuarterlyActivitiesNewButtons':
        $content = user::manageQuarterlyActivitiesNewButtons();
        $title = "Manage Users Quarterly Activities";
        $dashboard->template($title, $sub, $content);
        break;

    case 'deleteUser':

        user::deleteUserProfile($_REQUEST['id']);
        break;

    case 'deleteKMU':

        user::deleteUserKMU($_REQUEST['id']);
        break;
  case 'deleteUserObjective':

        user::deleteUserObjective($_REQUEST['id']);
        break;
 case 'deleteUserWorkplan':

        user::deleteUserWorkplan($_REQUEST['id']);
        break;
 case 'deleteUserActivity':
        user::deleteUserActivity($_REQUEST['id']);
        break;

    case 'editUserWorkplan':
        $content = user::editUserWorkplan($_REQUEST['id']);
        $title = "Edit Annual Workplan";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewAnnualKO':
        user::processNewAnnualKO();

        break;

    case 'editAnnualKO':
        user::editAnnualKO();

        break;

    case 'deleteDailyActivity':
        user::deleteDailyActivity();
        break;

    case 'deleteDailyActivityReport':
        content::deleteDailyActivities();
        break;

 case 'deleteUserActivityQuarterly':

        user::deleteUserActivityQuarterly($_REQUEST['id'],$_REQUEST['user_id']);
        //user::viewaDailyActivities($_REQUEST['id'],$_REQUEST['user_id']);
        break;

 case 'manageQurterlyOutputs':
        $content = user::manageQuarterlyOutputs();
        $title = "Manage Qurterly Outputs";
        $dashboard->template($title, $sub, $content);
        break;

  case 'viewEvaluaton':
        $content = user::manageUsersEvaluation();
        $title = "Manage User Evaluation";
        $dashboard->template($title, $sub, $content);
        break;

  case 'viewEvaluaton2':
        $content = user::manageUsersEvaluation2();
        $title = "Manage User Evaluation";
        $dashboard->template($title, $sub, $content);
        break;

 case 'viewEvaluatonButtons':
        $content = user::manageUsersEvaluationButtons();
        $title = "Manage User Evaluation";
        $dashboard->template($title, $sub, $content);
        break;

 case 'processEditQuarterlyActivities':
        $content = user::processEditQuarterlyActivities();
        $title = "Add New Qurterly Activity";
        $dashboard->template($title, $sub, $content);
        break;

 case 'addKMU':
        $content = user::addKMU();
        $title = "Add New Knowledge Management COntent";
        $dashboard->template($title, $sub, $content);
        break;

 case 'addDailyActivity':
        $content = user::addNewDailyActivity();
        $title = "Add New Daily Activity";
        $dashboard->template($title, $sub, $content);
        break;


    case 'getSubRegionByRegion':
        region::getSubRegionByRegion($_REQUEST['id']);
        break;

    case 'getDistrictBySubRegion':
        region::getDistrictBySubRegion($_REQUEST['id']);
        break;

    case 'getCountyByDistrict':
        region::getCountyByDistrict($_REQUEST['id']);
        break;

    case 'getSubcountyByCounty':
        region::getSubcountyByCounty($_REQUEST['id']);
        break;


    case 'getParishBySubcounty':
        region::getParishBySubcounty($_REQUEST['id']);
        break;


    case 'getVillageByParish':
        region::getVillageByParish($_REQUEST['id']);
        break;

    case 'doLoginAPI':
        session::doLoginApi();
        break;

 case 'doLoginAPZ':
        session::doLoginApi2();
        break;


    case 'syncQuarterlyActivitiesAPI':
        user::syncQuarterlyActivitiesAPI();
        break;


    case 'syncDailyActivitiesAPI':
        user::syncDailyActivitiesAPI();
        break;


    case 'syncAllSeedData':
        user::syncSeedDataAPI();
        break;

    case 'syncAllActivities':
        user::syncActivitiesAPI();
        break;

    case 'syncAllEntreprises':
        user::syncEntreprisesAPI();
        break;


    case 'syncGRMNatureAPI':
        user::syncGRMNatureAPI();
        break;

    case 'syncGRMTypesAPI':
        user::syncGRMTypesAPI();
        break;

    case 'syncGRMSettlementAPI':
        user::syncGRMSettlementAPI();
        break;

    case 'syncGRMFeedbackModeAPI':
        user::syncGRMFeedbackModeAPI();
        break;

    case 'syncGRMModeOfReceiptAPI':
        user::syncGRMModeOfReceiptAPI();
        break;

    case 'getWeatherSubcountyByDistrict':
        weather::getSubcountyByDistrict($_REQUEST['id']);
        break;


    case 'getWeatherParishBySubcounty':
        weather::getParishBySubcounty($_REQUEST['district'],$_REQUEST['subcounty']);
        break;


    case 'syncWeatherInfo':
        user::syncWeatherInfo();
        break;

    case 'getWeatherAdvisory':
        $content = weather::getWeatherContent7Days();
        $title = "Get Agro Advisory";
        $dashboard->templateFrontEnd($title,$content);
        break;


 case 'addUnplannedActivity':
        $content = user::addUnplannedActivity();
        $title = "Add New Unplanned Activity";
        $dashboard->template($title, $sub, $content);
        break;

    case'processMsg':
        user::processMsg();
        break;

    case 'processPotentialEnt':

        user::processPotentialEnt();
        break;
     case 'processPopularEnt':

        user::processPopularEnt();
        break;
    case 'processQuarterlyActivities':
        user::processQuarterlyActivities();
        break;


        case 'processAddKMU':
        user::processAddKMU();
        break;

    case 'processAddNewDailyActivity':
        user::processAddNewDailyActivity();
        break;

    case 'myarea':

        $content = content::myArea();

        $dashboard->template($title, $sub, $content);

        break;



    case 'crops':

        $content = content::crops();

        $dashboard->template($title, $sub, $content);

        break;


    case 'livestock':

        $content = content::livestock();

        $dashboard->template($title, $sub, $content);

        break;


    case 'fish':

        $content = content::fish();

        $dashboard->template($title, $sub, $content);

        break;


    //Logout

    case 'logout':

        Session::logOut();

        break;

    //Logout

    case 'login':

        dashboard::login();

        break;

    case 'doLogin':

        session::doLogin();

        break;


    case 'completeRegistration':

        $title = "Complete your profile setup";

        $content = user::profileComplete();

        $dashboard->template($title, $sub, $content);

        break;


    case 'editProfile':

        $title = "Edit your profile";

        $content = user::profileComplete();

        $dashboard->template($title, $sub, $content);

        break;


    case 'profile':

        $title = "View your diary";

        $content = user::profile();

        $dashboard->template($title, $sub, $content);

        break;


    case 'mapsDistrict':
        map::countDistrictSchools();
        break;

        case 'countAllDistrictOutbreaks':
        map::countAllDistrictOutbreaks();
        break;
    case'districtSchoolDetails':
        map::viewDistrictActivitiesByOfficers();
        break;

    case'districtOubreaksDetails':
        map::viewDistrictOutbreaksByOfficers();
        break;




    case 'q':

        $title = 'Search AAIS: ';

        $list = new kmuList(

            $_SESSION['search']['region'],
            $_SESSION['search']['subregion'],
            $_SESSION['search']['district'],
            $_SESSION['search']['name'],
            $results_view = 'list',
            $results_order = 'nameASC'

        );

        $content = $list->doSearchAll();

        $dashboard->template($title, $sub, $content);

        break;


    case 'editUserProfile':

       user::editUserProfile();

        break;


    case 'editMyProfile':

       user::editMyProfile();

        break;


    case 'viewProfile':
        $content = user::getUserProfile();
        $title = "View My Profile";
        $dashboard->template($title, $sub, $content);
        break;

  case 'viewUserProfile':
        $content = user::viewUserProfile($_REQUEST['id']);
        $title = "View User Profile";
        $dashboard->template($title, $sub, $content);
        break;


    case 'popularCommodities':

        $title = "Popular Commodites";

        $content = content::popular();

        $dashboard->template($title, $sub, $content);

        break;



    case 'potenialCommodities':
        $title = "Potential Commodities";
        $content = content::potential();

        $dashboard->template($title, $sub, $content);

        break;


    case 'viewAnnualObjectives':
        $title = "My annual Outputs";
        $content = content::annualObjectives();

        $dashboard->template($title, $sub, $content);

        break;

    case 'addActivityImages':
        $title = "Add Activity Images";
        $content = content::addActivityImages();

        $dashboard->template($title, $sub, $content);

        break;


    case 'processDailyActivityImages':
        content::processDailyActivityImages();
        break;

    case 'viewDailyActivity':
        $title = "View Daily Activity";
        $content = content::viewDailyActivitys();

        $dashboard->template($title, $sub, $content);

        break;


    case 'trashDailyActivity':
        content::trashDailyActivity($_REQUEST['id']);
        break;

 case 'viewaAnnualActivities':
        $title = "My Annual Activities";
        $content = content::annualActivities();

        $dashboard->template($title, $sub, $content);

        break;

  case 'viewaQuaterlyActivities':
        $title = "My Quaterly Activities";
       // $content = content::quarterlyActivities();
        $content = user::viewUserQuaterlyAcitivitiesNew($_REQUEST['user_id']);

        $dashboard->template($title, $sub, $content);

        break;


    case 'processAreaProfileNew':

        user::processAreaProfileNew();
        break;


  case 'viewaEvaluationReport':

      if(isset($_GET['user_id']))
          $id = $_GET['user_id'];
      else
          $id = $_SESSION['user']['id'];

      $user = user::getUserDetails($id);

      $title = "$user[first_name] $user[last_name] Evaluation Report ". date("Y");
        $content = content::viewaEvaluationReport();

        $dashboard->template($title, $sub, $content);

        break;


case 'viewaDailyActivities':

        $id = $_REQUEST['user_id'];
        $user = user::getUserDetails($id);
        $title = "$user[first_name] $user[last_name]  Daily Activities ". date("Y");
        $content = content::latestDailyActivities(30,$id);
        $dashboard->template($title, $sub, $content);

        break;




case 'manageviewaDailyActivities':

        if(isset($_REQUEST['user_id']))
            $id = $_REQUEST['user_id'];


        $user = user::getUserDetails($id);

        $title = "$user[first_name] $user[last_name]  Daily Activities ". date("Y");
        $content = content::managelatestDailyActivities();
        //$content = content::dailyActivities();

        $dashboard->template($title, $sub, $content);

        break;






  case 'viewKeyQuartelyOutputs':
        $title = "My Key Quartely Outputs";
        $content = content::areaoutputs();

        $dashboard->template($title, $sub, $content);

        break;


    case 'areaProfile':


        $title = "Area Profile";
        $content = content::myArea();

        $dashboard->template($title, $sub, $content);

        break;



    case 'feedback':


        $title = "Feedback";
        $content = user::feedbackInbox();

        $dashboard->template($title, $sub, $content);

        break;




    case 'feedbackCompose':


        $title = "Feedback Compose";
        $content = user::feedbackNewMail();

        $dashboard->template($title, $sub, $content);

        break;




    case 'feedbackSent':


        $title = "Sent Messages";
        $content = user::feedbackSentMail();

        $dashboard->template($title, $sub, $content);

        break;


    case 'viewQuestions':
        $content = questions::viewQuestions();
        $title = "View Questions";
        $dashboard->template($title, $sub, $content);
        break;
    
    case 'viewQuestionDetails':
        $content = questions::viewQuestionDetails();
        $title = "View Question Details";
        $dashboard->template($title, $sub, $content);
        break;
    
    case 'viewFarmerQuestions':
    $content = questions::viewFarmerQuestions();
    $title = "View Farmer Specific Questions";
    $dashboard->template($title, $sub, $content);
    break;

    


    case 'viewResponses':
        $content = questions::viewResponses($_GET['question']);
        $title = "View Responses";
        $dashboard->template($title, $sub, $content);
        break;

    case 'replyQuestion':
        questions::sendQuestionResponse($_GET['id']);
        break;



    case 'viewAlerts':
        $content = alerts::viewAlerts();
        $title = "View Alerts";
        $dashboard->template($title, $sub, $content);
        break;

    case 'sendAlert':
        alerts::saveAlert();
        break;

    case 'sendUserAlert':
        alerts::saveUserAlert();
        break;    


    case 'getUserMarketData':

         RESTAPI::getUserMarketsData();
       
        break;

    case 'getOutbreaksCrises':
        $dashboard = new dashboard();
        $content = outbreak::getOutbreaksData2();
        $title = "Outbreaks and Crises";
        $dashboard->templateFrontEnd($title,$content);
        break;

case 'getKMUContentSearch':
        $dashboard = new dashboard();
        $cat = kmu::getKMUDetails($_REQUEST['entreprize']);
        $content = kmu::getKMUDataFEBySearch();
        $title = "Search Results - Knowledge Management Module";
        $dashboard->templateFrontEnd($title,$content);
        break;



    case 'getKMU_FE':
        $dashboard = new dashboard();
        $content = kmu::getKMUDataFE();
        $title = "Knowledge Management Module";
        $dashboard->templateFrontEnd($title,$content);
        break;

    case 'getKMUByCategory':
        $dashboard = new dashboard();
        $cat = kmu::getKMUDetails($_REQUEST['id']);
        $content = kmu::getKMUDataFEByCategory();
        $title = "Knowledge Management Module - $cat[name] ";
        $dashboard->templateFrontEnd($title,$content);
        break;



    case 'getKMUContentSearch':
        $dashboard = new dashboard();
        $cat = kmu::getKMUDetails($_REQUEST['entreprize']);
        $content = kmu::getKMUDataFEBySearch();
        $title = "Search Results - Knowledge Management Module";
        $dashboard->templateFrontEnd($title,$content);
        break;


    case 'manageKMU':
        $content = kmu::manageKMU();
        $title = "Manage Knowledge Management Unit";
        $dashboard->template($title, $sub, $content);
        break;

    case 'manageOutbreaksCrises':
        $content = outbreak::manageOutbreaksCrises();
        $title = "Manage Outbreaks &amp; Crises";
        $dashboard->template($title, $sub, $content);
        break;

    case 'viewFarmers':
        $content = farmer::viewFarmers($_GET['group']);
        $title = "Manage Farmers";
        $dashboard->template($title, $sub, $content);
        break; 
        
    case 'viewFarmerGroups':
        $content = farmergroup::viewFarmerGroups();
        $title = "Manage Farmer Groups";
        $dashboard->template($title, $sub, $content);
        break;
    
//Set session dates
    case 'setSessionDates':
         $_SESSION['date_from'] = $_REQUEST['date_from'];
         $_SESSION['date_to'] = $_REQUEST['date_to'];
         redirect_to($_SERVER['HTTP_REFERER']);
        break;

    case 'setQuarterlyActivityFilters':

        $_SESSION['financial_year'] = $_REQUEST['financial_year'];
        $_SESSION['quarter'] = $_REQUEST['quarter'];
        redirect_to($_SERVER['HTTP_REFERER']);
        break;

        case 'setSessionDatesYear':
         $_SESSION['date_from'] = $_REQUEST['date_from'];
         $_SESSION['date_to'] = $_REQUEST['date_to'];
         $_SESSION['financial_year'] = $_REQUEST['year'];
         redirect_to($_SERVER['HTTP_REFERER']);
        break;

        case 'setSessionYearQuarter':
          $_SESSION['quarter'] = $_REQUEST['quarter'];
         $_SESSION['financial_year'] = $_REQUEST['year'];
         redirect_to($_SERVER['HTTP_REFERER']);
        break;

 case 'viewEODistrictReport':
        $content = report::generateDistrictReport();
        $title = report::getDistrictDetailsbyId($_REQUEST['id'])." District Report";
        $dashboard->template($title, $sub, $content);
        break;


 case 'viewManageDistrictSectorReport':
        $content = report::generateDistrictSectorReport();
        $title = report::getDistrictDetailsbyId($_REQUEST['district_id'])." District Sector Report";
        $dashboard->template($title, $sub, $content);
        break;


 case 'viewEOZonalReport':
        $content = reportZonal::generateZonalReport();
        $title = reportZonal::getZoneDetailsbyId($_REQUEST['id'])." Zonal Report";
        $dashboard->template($title, $sub, $content);
        break;


 case 'viewManageZonalSectorReport':
        $content = reportZonal::generateZonalSectorReport();
        $title = reportZonal::getZoneDetailsbyId($_REQUEST['zone_id'])." Zonal Sector Report";
        $dashboard->template($title, $sub, $content);
        break;

    case 'getUserNotifications':
        user::getUserNotifications();
        break;


    case 'viewAllUserNotifications':
        $content = user::viewAllUserNotifications();
        $title = "View User Notifications";
        $dashboard->template($title, $sub, $content);
        break;

    case 'getAllUserNotifications':
        user::getAllUserNotifications();
        break;

    case 'markAllNotificationsAsRead':
        user::markAllNotificationsAsRead();
        break;

    case 'deleteAllUserNotifications':
        user::deleteAllUserNotifications();
        break;

    case 'deleteUserNotification':
        user::deleteUserNotification($_REQUEST['id']);
        break;

    case 'editUserDetails':
    $content = user::getEditUserDetails($_REQUEST['id']);
    $title = "Edit User Details";
    $dashboard->template($title, $sub, $content);
    break;

    case 'processEditUserDetails':
    user::processEditUserDetails();
    break;

    case 'getDepartmentsByDirectorate':
        user::getDepartmentsByDirectorate();
        break;

    case 'getDivisionsByDepartment':
    user::getDivisionsByDepartment();
    break;
    
    case 'adminGetParishesBySubcounty':
    user::adminGetParishesBySubcounty();
    break;


    case 'changeUserPassword':
    $content = user::getChangeUserPassword();
    $title = "Change User Password";
    $dashboard->template($title, $sub, $content);
    break;

    case 'processChangeUserPassword':
         user::processChangeUserPassword();
    
        break;








    /*
     * USER SEED DATA MANAGEMENT
     * For System Admins and Datamanagers
     */


    //Manage Districts/Cities
    case 'dmManageDistrict':
            $content = seedData::manageDistricts();
            $title = "Manage Districts/Cities";
            $dashboard->template($title, $sub, $content);
        break;

    case 'addNewDistrict':
            $content = seedData::addNewDistrict();
            $title = "Add New District/City";
            $dashboard->template($title, $sub, $content);
        break;

    case 'editDistrict':
            $content = seedData::editDistrict($_REQUEST['id']);
            $title = "Edit District/City";
            $dashboard->template($title, $sub, $content);
        break;

    case 'processNewDistrict':
           seedData::processNewDistrict();
        break;

    case 'processEditDistrict':
           seedData::processEditDistrict();
        break;

    case 'deleteDistrict':
           seedData::processDeleteDistrict();
        break;




    //Manage Counties/Municipalities
    case 'dmManageCounty':
        $content = seedData::manageCounties();
        $title = "Manage Counties/Municipalities";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewCounty':
        $content = seedData::addNewCounty();
        $title = "Add New County/Municipality";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editCounty':
        $content = seedData::editCounty($_REQUEST['id']);
        $title = "County/Municipality";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewCounty':
        seedData::processNewCounty();
        break;

    case 'processEditCounty':
        seedData::processEditCounty();
        break;

    case 'deleteCounty':
        seedData::processDeleteCounty();
        break;



    //Manage Subcounties/Towns
    case 'dmManageSubcounty':
        $content = seedData::manageSubcounties();
        $title = "Manage Subcounties/Town Councils";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewSubcounty':
        $content = seedData::addNewSubcounty();
        $title = "Add New Subcounty/Town Council";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editSubcounty':
        $content = seedData::editSubcounty($_REQUEST['id']);
        $title = "Edit Subcounty/Town Council";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewSubcounty':
        seedData::processNewSubcounty();
        break;

    case 'processEditSubcounty':
        seedData::processEditSubcounty();
        break;

    case 'deleteSubcounty':
        seedData::processDeleteSubcounty();
        break;



    //Manage Parishes/Wards
    case 'dmManageParishesAll':
        $content = seedData::manageParishesAll();
        $title = "Manage Parishes/Wards";
        $dashboard->template($title, $sub, $content);
        break;

 case 'dmManageParish':
        $content = seedData::manageParishes();
        $title = "Manage Parishes/Wards";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewParish':
        $content = seedData::addNewParish();
        $title = "Add New Parish/Ward";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editParish':
        $content = seedData::editParish($_REQUEST['id']);
        $title = "Edit Parish/Ward";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewParish':
        seedData::processNewParish();
        break;

    case 'processEditParish':
        seedData::processEditParish();
        break;

    case 'deleteParish':
        seedData::processDeleteParish();
        break;



    //Manage Villages/Zones
    case 'dmManageVillage':
        $content = seedData::manageVillages();
        $title = "Manage Villages/Zones";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewVillage':
        $content = seedData::addNewVillage();
        $title = "Add New Village/Zone";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editVillage':
        $content = seedData::editVillage($_REQUEST['id']);
        $title = "Edit Village/Zone";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewVillage':
        seedData::processNewVillage();
        break;

    case 'processEditVillage':
        seedData::processEditVillage();
        break;

    case 'deleteVillage':
        seedData::processDeleteVillage();
        break;




    //Manage Extension Officer Activities
    case 'dmManageActivities':
        $content = seedData::manageActivities();
        $title = "Manage Extension Officer Activities";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewActivity':
        $content = seedData::addNewActivity();
        $title = "Add New Activity";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editActivity':
        $content = seedData::editActivity($_REQUEST['id']);
        $title = "Edit Activity";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewActivity':
        seedData::processNewActivity();
        break;

    case 'processEditActivity':
        seedData::processEditActivity();
        break;

    case 'deleteActivity':
        seedData::processDeleteActivity();
        break;





    //Manage Extension Officer Topics
    case 'dmManageTopics':
        $content = seedData::manageTopics();
        $title = "Manage Extension Officer Topics";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewTopic':
        $content = seedData::addNewTopic();
        $title = "Add New Topic";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editTopic':
        $content = seedData::editTopic($_REQUEST['id']);
        $title = "Edit Topic";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewTopic':
        seedData::processNewTopic();
        break;

    case 'processEditTopic':
        seedData::processEditTopic();
        break;

    case 'deleteTopic':
        seedData::processDeleteTopic();
        break;


    //Manage Extension Officer Entreprizes and Approaches
    case 'dmManageEntreprizes':
        $content = seedData::manageEntreprizes();
        $title = "Manage Extension Officer Entreprizes and Approaches";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewEntreprize':
        $content = seedData::addNewEntreprize();
        $title = "Add New Entreprize";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editEntreprize':
        $content = seedData::editEntreprize($_REQUEST['id']);
        $title = "Edit Entreprize";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewEntreprize':
        seedData::processNewEntreprize();
        break;

    case 'processEditEntreprize':
        seedData::processEditEntreprize();
        break;

    case 'deleteEntreprize':
        seedData::processDeleteEntreprize();
        break;
    //Manage Extension Officer Entreprizes and Approaches



    //Manage Extension Officer User Associations
    case 'dmManageUserAssociations':
        $content = seedData::manageUserAssociations();
        $title = "Manage Extension Officer User Associations";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewUserAssociation':
        $content = seedData::addNewUserAssociation();
        $title = "Add New User Association";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editUserAssociation':
        $content = seedData::editUserAssociation($_REQUEST['id']);
        $title = "Edit User Association";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewUserAssociation':
        seedData::processNewUserAssociation();
        break;

    case 'processEditUserAssociation':
        seedData::processEditUserAssociation();
        break;

    case 'deleteUserAssociation':
        seedData::processDeleteUserAssociation();
        break;
    //End Manage Extension Officer User Associations


    //Manage Extension Officer User Transfers
    case 'dmManageUserTransfers':
        $content = seedData::manageUserTransfers();
        $title = "Manage Extension Officer User Transfers";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewUserTransfer':
        $content = seedData::addNewUserTransfer();
        $title = "Add New User Transfer";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editUserTransfer':
        $content = seedData::editUserTransfer($_REQUEST['id']);
        $title = "Edit User Transfer";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewUserTransfer':
        seedData::processNewUserTransfer();
        break;

    case 'processEditUserTransfer':
        seedData::processEditUserTransfer();
        break;

    //Reverse a User Transfer
    case 'deleteUserTransfer':
        seedData::processDeleteUserTransfer();
        break;
   //End Manage Extension Officer User Transfers

    //Manage Extension Officer User Permissions
    case 'dmManageUserPermissions':
        $content = seedData::manageUserPermissions();
        $title = "Manage Extension Officer User Permissions";
        $dashboard->template($title, $sub, $content);
        break;

    case 'addNewUserPermissions':
        $content = seedData::addNewUserPermissions();
        $title = "Add New User Permissions";
        $dashboard->template($title, $sub, $content);
        break;

    case 'editUserPermissions':
        $content = seedData::editUserPermissions($_REQUEST['id']);
        $title = "Edit User Permissions";
        $dashboard->template($title, $sub, $content);
        break;

    case 'processNewUserPermissions':
        seedData::processNewUserTransfer();
        break;

    case 'processEditUserPermissions':
        seedData::processEditUserPermissions();
        break;

    case 'deleteUserPermissions':
        seedData::processDeleteUserPermissions();
        break;


    case 'syncOutbreaksAPI':
        user::syncOutbreaksAPI();
        break;
    //End Manage Extension Officer User Permissions

    /*
     * END USER SEED DATA MANAGEMENT
     */




    /*
     * Default Page
     */

    default:

        $content = '';

        $dashboard->template($title, $sub, $content);

        break;

}

