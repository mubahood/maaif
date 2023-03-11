<?php
require_once './includes/init.php';


// load basic functions next so that everything after can use them
require_once('./includes/functions.php');

//load core classes using dynamic links
require_once('./includes/classes/session.php');
require_once('./includes/classes/database.php');
require_once('./includes/classes/pagination.php');
require_once('./includes/classes/dashboard.php');
require_once('./includes/classes/content.php');
require_once('./includes/classes/region.php');
require_once('./includes/classes/subregion.php');
require_once('./includes/classes/district.php');
require_once('./includes/classes/subcounty.php');
require_once('./includes/classes/school.php');
require_once('./includes/classes/map.php');
require_once('./includes/classes/user.php');
require_once('./includes/classes/gender.php');
require_once('./includes/classes/list.php');
require_once('./includes/classes/dmplist.php');
require_once('./includes/classes/js.php');
require_once('./includes/classes/foundingbody.php');
require_once('./includes/classes/boarding.php');
require_once('./includes/classes/ownership.php');
require_once('./includes/classes/category.php');
require_once('./includes/classes/ownership.php');
require_once('./includes/classes/admin.php');
require_once('./includes/classes/produce.php');
require_once('./includes/classes/charts.php');
require_once('./includes/classes/RESTAPI.php');
require_once('./includes/classes/weather.php');
require_once('./includes/classes/kmu.php');
require_once('./includes/classes/outbreakscrises.php');
require_once('./includes/classes/imageManipulator.php');
require_once('./includes/classes/questions.php');
require_once('./includes/classes/alerts.php');
require_once('./includes/classes/farmergroup.php');
require_once('./includes/classes/farmer.php');
require_once('./includes/classes/report.php');
require_once('./includes/classes/reportZonal.php');
require_once('./includes/classes/seedData.php');
require_once('./includes/classes/userMgmt.php');



require './includes/classes/PHPMailer/Exception.php';
require './includes/classes/PHPMailer/PHPMailer.php';
require './includes/classes/PHPMailer/SMTP.php';
