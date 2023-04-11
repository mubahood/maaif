
<?php
header('Location: /admin');
die();
die("Something really cool is coming soon!");
//error_reporting(1);

// intialize App
require_once './includes/mainRouter.php';

if ($_SESSION['live']) {
    require_once './control.php';
} else {

    $title   = "Agricultural Extension and Advisory System";
    $sub     = "";
    $content = "";
    
    switch ($_SESSION['action']) {
        // Show front end home page/ Site's Home page
        case 'home':
            $dashboard = new dashboard();
            $data = $dashboard->newLetsLogin();
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;


            
        case 'newhome':
            $dashboard = new dashboard();
            $data = $dashboard->newLetsLogin();
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'logout':
            Session::logOut();
            break;

        //Logout
        case 'login':
            $dashboard = new dashboard();
            $data = $dashboard->newLetsLogin();
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'auth':
            session::auth();
            break;
            
        case 'doLoginAPI':
            session::doLoginApi();
            break;
            
        case 'syncQuarterlyActivitiesAPI':
            user::syncQuarterlyActivitiesAPI();
            break;
            
        case 'syncWeatherInfo':
            user::syncWeatherInfo();
            break;
            
        case 'getUserMarketData':
            RESTAPI::getUserMarketsData();
            break;
            
        case 'doLogin':
            session::doLogin();
            break;
            
        case 'getWeatherAdvisory':
            $dashboard = new dashboard();
            $data   = weather::getWeatherContent7Days();
            $title     = "Get Agro Advisory";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'getLanguages':
            user::getLanguages();
            break;
            
        case 'getCountiesByDistrict':
            region::getCountiesByDistrict();
            break;
            
        case 'getSubCountiesByCounty':
            region::getSubCountiesByCounty();
            break;
            
        case 'getParishesBySubCounty':
            region::getParishesBySubCounty();
            break;
            
        case 'villagesByParishID':
            region::getVillagesByParish();
            break;
            
        case 'getWeatherSubcountyByDistrict':
            weather::getSubcountyByDistrict($_REQUEST['id']);
            break;
            
        case 'getWeatherParishBySubcounty':
            weather::getParishBySubcounty($_REQUEST['district'], $_REQUEST['subcounty']);
            break;
            
        case 'getOutbreaksCrises':
            $dashboard = new dashboard();
            $title     = "Get Outbreaks and Crises";
            // $content   = outbreak::getOutbreaksData2();
            // $dashboard->templateFrontEnd($title,$content);
            $data   = outbreak::getOutbreaksData3();
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'reportOutbreaksCrises':
            $dashboard = new dashboard();
            $data      = outbreak::reportOutBreaksCrises();
            $title     = "Report Outbreaks and Crises";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'askQuestion';
            $dashboard = new dashboard();
            $data      = outbreak::askQuestion();
            $title     = "Ask a Question";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;

        case 'verifyAccount';
            $dashboard = new dashboard();
            $data      = user::verifyAccount($_REQUEST['verification']);
            $title     = "Verify Account";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;

        case 'processVerifyAccount';
            $account =  user::processVerifyAccount();
            break;

            
        case 'processQuestion';
            $content = outbreak::processQuestion();
            break;
            
        case 'saveCrisisOutbreaks':
            $content = outbreak::saveCrisisOutbreaks();
            break;
            
        case 'getKMU_FE':
            $dashboard = new dashboard();
            $data   = kmu::getKMUDataFE();
            $title     = "Knowledge Management Module";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'getKMUByCategory':
            $dashboard = new dashboard();
            $cat       = kmu::getKMUDetails($_REQUEST['id']);
            $data   = kmu::getKMUDataFEByCategory();
            $title     = "$cat[name] - Knowledge Management Module";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'getKMUContentSearch':
            $dashboard = new dashboard();
            $cat       = kmu::getKMUDetails($_REQUEST['entreprize']);
            $data      = kmu::getKMUDataFEBySearch();
            $title     = "Search Results - Knowledge Management Module";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'syncDailyActivitiesAPI':
            user::syncDailyActivitiesAPI();
            break;

        case 'syncAllDistricts':
                user::syncAllDistricts();
                break;

            case 'syncAllCounties':
                user::syncAllCounties();
                break;

            case 'syncAllSubcounties':
                user::syncAllSubcounties();
                break;
            

            case 'syncAllParishes':
                user::syncAllParishes();
                break;

            case 'syncAllVillages':
                user::syncAllVillages();
                break;

            case 'syncCountiesByDistrict':
                user::syncCountiesByDistrict($_REQUEST['district']);
                break;

            case 'syncSubcountiesByDistrict':
                user::syncSubcountiesByDistrict($_REQUEST['district']);
                break;

            case 'syncParishesByDistrict':
                user::syncParishesByDistrict($_REQUEST['district']);
                break;

            case 'syncVillagesByDistrict':
                user::syncVillagesByDistrict($_REQUEST['district']);
                break;


            case 'syncOutbreaksAPI':
            user::syncOutbreaksAPI();
            break;
        case 'syncAllTopics':
            user::syncSeedDataAPI();
            break;
case 'syncAllTopicsNew':
            user::syncTopicsNewAPI();
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
            
        case 'apiGetQuestions':
            questions::apiGetQuestions();
            break;
            
        case 'apiGetQuestion':
            questions::apiGetQuestion();
            break;
            
        case 'apiGetQuestionResponses':
            questions::apiGetResponses();
            break;
            
        case 'apiSaveQuestionResponse':
            questions::apiSendResponse();
            break;
            
        case 'apiSaveFarmerQuestion':
            questions::apiSaveFarmerQuestion();
            break;
            
        case 'mapsDistrict':
            map::countDistrictSchools();
            break;
            
        case 'countAllDistrictOutbreaks':
            map::countAllDistrictOutbreaks();
            break;
            
        case 'districtSchoolDetails':
            map::viewDistrictActivitiesByOfficers();
            break;
            
        case 'districtOubreaksDetails':
            map::viewDistrictOutbreaksByOfficers();
            break;
            
        case 'getGrievanceTypesByNature':
            user::getGrievanceTypesByNature();
            break;
            
        case 'saveGrievanceReport':
            user::saveGrievanceReport();
            break;
            
        case 'getGRMCountiesByDistrict':
            user::getGRMCountiesByDistrict();
            break;
            
        case 'getGRMSubCountiesByCounty':
            user::getGRMSubCountiesByCounty();
            break;
            
        case 'getGRMParishesBySubCounty':
            user::getGRMParishesBySubCounty();
            break;
            
        case 'forgotPassword':
            $dashboard = new dashboard();
            $data   = user::getForgotPassword();
            $title     = "Reset your password";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;

        case 'reportGrievance':
            $dashboard = new dashboard();
            $data      = user::getReportGrievance();
            $title     = "Report Grievance";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
            
        case 'processForgotPassword':
            user::processForgotPassword();
            break;
            
        case 'getSubCountiesByDistrict':
            region::getSubCountiesByDistrict();
            break;



       case 'syncAllSeedData':
            user::syncSeedDataAPI();
            break;

        case 'IrriTrackPrivacy':
            $dashboard = new dashboard();
            $data      = content::IrriTrackPrivacy();
            $title     = "DATA PROTECTION AND PRIVACY NOTICE";
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;

        default:
            $dashboard = new dashboard();
            $data = $dashboard->newLetsLogin();
            $dashboard->newTemplateFrontEnd($title, $data['content'], $data['styles'], $data['scripts']);
            break;
    }
}
?>
