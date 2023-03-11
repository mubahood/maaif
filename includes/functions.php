<?php

function notFound(){
    redirect_to(ROOT.'/error/404');
}


function letters() {
    return ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
}



function makeSeo($text, $limit=75)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if(strlen($text) > 70) {
        $text = substr($text, 0, 70);
    }

    if (empty($text))
    {
        //return 'n-a';
        return time();
    }

    return $text;
}


function redirect_to($location = NULL)
{
    if ($location != NULL) {
		
		echo'<html xmlns="http://www.w3.org/1999/xhtml">    
  <head>      
    <title>Processing...</title>      
    <meta http-equiv="refresh" content="0;URL=\''.$location.'\'" />    
  </head>    
  <body> 
    <p>&nbsp;</p> 
  </body> 
</html> ';		
      //  header("Location: {$location}");
        exit();
    }
}


function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}

// Count how many days between 2 days
function howManyDays($from, $to)
{
    $first_date = strtotime($from);
    $second_date = strtotime($to);
    $offset = $second_date - $first_date;
    return floor($offset / 60 / 60 / 24);
}

function howManyHours($from, $to)
{
    $first_date = strtotime($from);
    $second_date = strtotime($to);
    $offset = $second_date - $first_date;
    return floor($offset / 60 / 60);
}

// remove variable and return url
function removeVarsAndReturnUrl(&$url, $toRemove)
{
    $parsed = [];
    parse_str(substr($url, strpos($url, '?') + 1), $parsed);
    $removed = $parsed[$toRemove];
    unset($parsed[$toRemove]);
    $url = 'http://example.com/';
    if (! empty($parsed)) {
        $url .= '?' . http_build_query($parsed);
    }
    return $removed;
}

//Twitter like number formatter
function count_format($n, $point = '.', $sep = ',')
{
    if ($n < 0) {
        return 0;
    }

    if ($n < 10000) {
        return number_format($n, 0, $point, $sep);
    }

    $d = $n < 1000000 ? 1000 : 1000000;

    $f = round($n / $d, 1);

    return number_format($f, $f - intval($f) ? 1 : 0, $point, $sep) . ($d == 1000 ? 'K' : 'M');
}


//Get current URL for page
function getCurrentUrl()
{
    return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

//Calculate the time past from a spcified timestamp
function timeAgo($dateStr)
{
    $timestamp = strtotime($dateStr);
    $day = 60 * 60 * 24;
    $today = time(); // current unix time
    $since = $today - $timestamp;

    // If it's been less than 1 day since the tweet was posted, figure out how long ago in seconds/minutes/hours
    if (($since / $day) < 1) {

        $timeUnits = array(
            array(
                60 * 60,
                'h'
            ),
            array(
                60,
                'm'
            ),
            array(
                1,
                's'
            )
        );

        for ($i = 0, $n = count($timeUnits); $i < $n; $i ++) {
            $seconds = $timeUnits[$i][0];
            $unit = $timeUnits[$i][1];

            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }

        return "$count{$unit}";

        // If it's been a day or more, return the date: day (without leading 0) and 3-letter month
    } else {
        return date('j M', strtotime($dateStr));
    }
}


//1000s currecny formatter
function thousandsCurrencyFormat($num)
{
    $x = round($num);
    $x_number_format = number_format($x);
    $x_array = explode(',', $x_number_format);
    $x_parts = array(
        'k',
        'm',
        'b',
        't'
    );
    $x_count_parts = count($x_array) - 1;
    $x_display = $x;
    $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
    $x_display .= $x_parts[$x_count_parts - 1];
    return $x_display;
}



//Month range calculator
function rangeMonth($datestr)
{
    date_default_timezone_set(date_default_timezone_get());
    $dt = strtotime($datestr);
    $res['start'] = date('Y-m-d', strtotime('first day of this month', $dt));
    $res['end'] = date('Y-m-d', strtotime('last day of this month', $dt));
    return $res;
}


//Week Range calculator
function rangeWeek($datestr)
{
    date_default_timezone_set(date_default_timezone_get());
    $dt = strtotime($datestr);
    $res['start'] = date('N', $dt) == 1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt));
    $res['end'] = date('N', $dt) == 7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt));
    return $res;
}


// * This function calculates the number of days between now and a date specified
function getDays($start, $end)
{
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    $xyz = round($diff / 86400);
    return $xyz;
}


// function to create Twitter links
function linkfy($ret)
{
    $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
    $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
    $ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
    $ret = preg_replace("/#(\w+)/", "<a href=\"" . SITE_ROOT . "/dashboard/search/?q=\\1\" target=\"_blank\">#\\1</a>", $ret);
    return $ret;
}


/*
 * Shuffle associative and non-associative array while preserving key, value pairs.
 * Also returns the shuffled array instead of shuffling it in place.
 */
function shuffle_assoc($list)
{
    if (! is_array($list))
        return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key) {
        $random[$key] = $list[$key];
    }
    return $random;
}

function makeAgo($time1, $time2, $precision = 6)

{
    $time = time();
    // If not numeric then convert texts to unix timestamps
    if (! is_int($time1)) {
        $time1 = strtotime($time1);
    }
    if (! is_int($time2)) {
        $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array(
        'year',
        'month',
        'day',
        'hour',
        'minute',
        'second'
    );
    $diffs = array();

    // Loop thru all intervals
    foreach ($intervals as $interval) {
        // Set default diff to 0
        $diffs[$interval] = 0;
        // Create temp time from time1 and interval
        $ttime = strtotime("+1 " . $interval, $time1);
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
            $time1 = $ttime;
            $diffs[$interval] ++;
            // Create new temp time from time1 and interval
            $ttime = strtotime("+1 " . $interval, $time1);
        }
    }

    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
            break;
        }
        // Add value and interval
        // if value is bigger than 0
        if ($value > 0) {
            // Add s if value is not 1
            if ($value != 1) {
                $interval .= "s";
            }
            // Add value and interval to times array
            $times[] = $value . " " . $interval;
            $count ++;
        }
    }

    // Return string with times
    return implode(", ", $times);
}

/*
 * This function calculates the number of distinct words in a string given
 * The function returns an array of distinct words and their ranks
 * This function replaces the inbuilt PHP function to count words
 */
function wordCount($string)
{
    $words = "";
    $string = preg_replace(" +", " ", $string);
    $array = explode(" ", $string);
    for ($i = 0; $i < count($array); $i ++) {
        if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/", $array[$i]))
            $words[$i] = $array[$i];
    }
    return $words;
}

// Extract real URL from short URL
function GetRealURL($url)
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_USERAGENT => "spider",
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_MAXREDIRS => 10
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);
    return $header['url'];
}

function yesterday()
{
    $date = date('Y-m-d');
    $newdate = strtotime('-1 day', strtotime($date));
    $newdate = date('Y-m-d', $newdate);
    return $newdate;
}


function week()
{
    $date = date('Y-m-d');
    $newdate = strtotime('-7 day', strtotime($date));
    $newdate = date('Y-m-d', $newdate);
    return $newdate;
}



// filter $_GET[] params to the only ones you need
// usability $get_params = allowed_get_params(['username', 'password']);
function allowed_get_params($allowed_params = [])
{
    $allowed_array = [];
    foreach ($allowed_params as $param) {
        if (isset($_GET[$param])) {
            $allowed_array[$param] = $_GET[$param];
        } else {
            $allowed_array[$param] = NULL;
        }
    }
    return $allowed_array;
}

// filter $_POST[] params to the only ones you need
// usability $post_params = allowed_post_params(['username', 'password']);
function allowed_post_params($allowed_params = [])
{
    $allowed_array = [];
    foreach ($allowed_params as $param) {
        if (isset($_POST[$param])) {
            $allowed_array[$param] = $_POST[$param];
        } else {
            $allowed_array[$param] = NULL;
        }
    }
    return $allowed_array;
}

// Core validation functions
// These need to be called from another validation function which
// handles error reporting.
//
// For example:
//
// $errors = [];
// function validate_presence_on($required_fields) {
// global $errors;
// foreach($required_fields as $field) {
// if (!has_presence($_POST[$field])) {
// $errors[$field] = "'" . $field . "' can't be blank";
// }
// }
// }

// * validate value has presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value)
{
    $trimmed_value = trim($value);
    return isset($trimmed_value) && $trimmed_value !== "";
}

// * validate value has string length
// leading and trailing spaces will count
// options: exact, max, min
// has_length($first_name, ['exact' => 20])
// has_length($first_name, ['min' => 5, 'max' => 100])
function has_length($value, $options = [])
{
    if (isset($options['max']) && (strlen($value) > (int) $options['max'])) {
        return false;
    }
    if (isset($options['min']) && (strlen($value) < (int) $options['min'])) {
        return false;
    }
    if (isset($options['exact']) && (strlen($value) != (int) $options['exact'])) {
        return false;
    }
    return true;
}

// * validate value has a format matching a regular expression
// Be sure to use anchor expressions to match start and end of string.
// (Use \A and \Z, not ^ and $ which allow line returns.)
//
// Example:
// has_format_matching('1234', '/\d{4}/') is true
// has_format_matching('12345', '/\d{4}/') is also true
// has_format_matching('12345', '/\A\d{4}\Z/') is false
function has_format_matching($value, $regex = '//')
{
    return preg_match($regex, $value);
}

// * validate value is a number
// submitted values are strings, so use is_numeric instead of is_int
// options: max, min
// has_number($items_to_order, ['min' => 1, 'max' => 5])
function has_number($value, $options = [])
{
    if (! is_numeric($value)) {
        return false;
    }
    if (isset($options['max']) && ($value > (int) $options['max'])) {
        return false;
    }
    if (isset($options['min']) && ($value < (int) $options['min'])) {
        return false;
    }
    return true;
}

// * validate value is inclused in a set
function has_inclusion_in($value, $set = [])
{
    return in_array($value, $set);
}

// * validate value is excluded from a set
function has_exclusion_from($value, $set = [])
{
    return ! in_array($value, $set);
}

// * validate uniqueness
// A common validation, but not an easy one to write generically.
// Requires going to the database to check if value is already present.
// Implementation depends on your database set-up.
// Instead, here is a mock-up of the concept.
// Be sure to escape the user-provided value before sending it to the database.
// Table and column will be provided by us and escaping them is optional.
// Also consider whether you want to trim whitespace, or make the query
// case-sentitive or not.
//
// function has_uniqueness($value, $table, $column) {
// $escaped_value = mysql_escape($value);
// sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = '{$escaped_value}';"
// if count > 0 then value is already present and not unique
// }

// Sanitize functions
// Make sanitizing easy and you will do it often

// Sanitize for HTML output
function h($string)
{
    return htmlspecialchars($string);
}

// Sanitize for JavaScript output
function j($string)
{
    return json_encode($string);
}

// Sanitize for use in a URL
function u($string)
{
    return urlencode($string);
}

// Usage examples, leave commented out
// echo h("<h1>Test string</h1><br />");
// echo j("'}; alert('Gotcha!'); //");
// echo u("?title=Working? Or not?");

// Use with request_is_post() to block posting from off-site forms
function request_is_same_domain()
{
    if (! isset($_SERVER['HTTP_REFERER'])) {
        // No refererer sent, so can't be same domain
        return false;
    } else {
        $referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        $server_host = $_SERVER['HTTP_HOST'];

        // Uncomment for debugging
        // echo 'Request from: ' . $referer_host . "<br />";
        // echo 'Request to: ' . $server_host . "<br />";

        return ($referer_host == $server_host) ? true : false;
    }
}

// Uncomment for testing
// if(request_is_same_domain()) {
// echo 'Same domain. POST requests should be allowed.<br />';
// } else {
// echo 'Different domain. POST requests should be forbidden.<br />';
// }
// echo '<br />';
// echo '<a href="">Same domain link</a><br />';

// GET requests should not make changes
// Only POST requests should make changes
function request_is_get()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function request_is_post()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Usage:
// if(request_is_post()) {
// ... process form, update database, etc.
// } else {
// ... do something safe, redirect, error page, etc.
// }

// Must call session_start() before this loads

// Generate a token for use with CSRF protection.
// Does not store the token.
function csrf_token()
{
    return md5(uniqid(rand(), TRUE));
}

// Generate and store CSRF token in user session.
// Requires session to have been started already.
function create_csrf_token()
{
    $token = csrf_token();
    $_SESSION['csrf_token'] = $token;
    $_SESSION['csrf_token_time'] = time();
    return $token;
}

// Destroys a token by removing it from the session.
function destroy_csrf_token()
{
    $_SESSION['csrf_token'] = null;
    $_SESSION['csrf_token_time'] = null;
    return true;
}

// Return an HTML tag including the CSRF token
// for use in a form.
// Usage: echo csrf_token_tag();
function csrf_token_tag()
{
    $token = create_csrf_token();
    return "<input type=\"hidden\" name=\"csrf_token\" value=\"" . $token . "\">";
}

// Returns true if user-submitted POST token is
// identical to the previously stored SESSION token.
// Returns false otherwise.
function csrf_token_is_valid()
{
    if (isset($_POST['csrf_token'])) {
        $user_token = $_POST['csrf_token'];
        $stored_token = $_SESSION['csrf_token'];
        return $user_token === $stored_token;
    } else {
        return false;
    }
}

// You can simply check the token validity and
// handle the failure yourself, or you can use
// this "stop-everything-on-failure" function.
function die_on_csrf_token_failure()
{
    if (! csrf_token_is_valid()) {
        die("CSRF token validation failed.");
    }
}

// Optional check to see if token is also recent
function csrf_token_is_recent()
{
    $max_elapsed = 60 * 60 * 24; // 1 day
    if (isset($_SESSION['csrf_token_time'])) {
        $stored_time = $_SESSION['csrf_token_time'];
        return ($stored_time + $max_elapsed) >= time();
    } else {
        // Remove expired token
        destroy_csrf_token();
        return false;
    }
}

// Useful php.ini file settings:
// session.cookie_lifetime = 0
// session.cookie_secure = 1
// session.cookie_httponly = 1
// session.use_only_cookies = 1
// session.entropy_file = "/dev/urandom"

// Function to begin the session.
function begin_session()
{
    session_start();
}

// Function to forcibly end the session
function end_session()
{
    // Use both for compatibility with all browsers
    // and all versions of PHP.
    session_unset();
    session_destroy();
}

// Does the request IP match the stored value?
function request_ip_matches_session()
{
    // return false if either value is not set
    if (! isset($_SESSION['ip']) || ! isset($_SERVER['REMOTE_ADDR'])) {
        return false;
    }
    if ($_SESSION['ip'] === $_SERVER['REMOTE_ADDR']) {
        return true;
    } else {
        return false;
    }
}

// Does the request user agent match the stored value?
function request_user_agent_matches_session()
{
    // return false if either value is not set
    if (! isset($_SESSION['user_agent']) || ! isset($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }
    if ($_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT']) {
        return true;
    } else {
        return false;
    }
}

// Has too much time passed since the last login?
function last_login_is_recent()
{
    $max_elapsed = 60 * 60 * 24; // 1 day
                                 // return false if value is not set
    if (! isset($_SESSION['last_login'])) {
        return false;
    }
    if (($_SESSION['last_login'] + $max_elapsed) >= time()) {
        return true;
    } else {
        return false;
    }
}

// Should the session be considered valid?
function is_session_valid()
{
    $check_ip = true;
    $check_user_agent = true;
    $check_last_login = true;

    if ($check_ip && ! request_ip_matches_session()) {
        return false;
    }
    if ($check_user_agent && ! request_user_agent_matches_session()) {
        return false;
    }
    if ($check_last_login && ! last_login_is_recent()) {
        return false;
    }
    return true;
}

// If session is not valid, end and redirect to login page.
function confirm_session_is_valid()
{
    if (! is_session_valid()) {
        end_session();
        // Note that header redirection requires output buffering
        // to be turned on or requires nothing has been output
        // (not even whitespace).
        header("Location: login.php");
        exit();
    }
}

// Is user logged in already?
function is_logged_in()
{
    return (isset($_SESSION['logged_in']) && $_SESSION['logged_in']);
}

// If user is not logged in, end and redirect to login page.
function confirm_user_logged_in()
{
    if (! is_logged_in()) {
        end_session();
        // Note that header redirection requires output buffering
        // to be turned on or requires nothing has been output
        // (not even whitespace).
        header("Location: login.php");
        exit();
    }
}

// Actions to preform after every successful login
function after_successful_login()
{
    // Regenerate session ID to invalidate the old one.
    // Super important to prevent session hijacking/fixation.
    session_regenerate_id();

    $_SESSION['logged_in'] = true;

    // Save these values in the session, even when checks aren't enabled
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['last_login'] = time();
}

// Actions to preform after every successful logout
function after_successful_logout()
{
    $_SESSION['logged_in'] = false;
    end_session();
}

// Actions to preform before giving access to any
// access-restricted page.
function before_every_protected_page()
{
    confirm_user_logged_in();
    confirm_session_is_valid();
}

// Uncomment to demonstrate usage

// if(isset($_GET['action'])) {
// if($_GET['action'] == "login") {
// after_successful_login();
// }
// if($_GET['action'] == "logout") {
// after_successful_logout();
// }
// }
//
// echo "Session ID: " . session_id() . "<br />";
// echo "Logged in: " . (is_logged_in() ? 'true' : 'false') . "<br />";
// echo "Session valid: " . (is_session_valid() ? 'true' : 'false') . "<br />";
// echo "<br />";
// echo "--- SESSION ---<br />";
// var_dump($_SESSION);
// echo "--------------------<br />";
// echo "<br />";
//
// echo "<a href=\"?action=new_page\">Simulate a new page request</a><br />";
// echo "<a href=\"?action=login\">Simulate a log in</a><br />";
// echo "<a href=\"?action=logout\">Simulate a log out</a>";

// Password Hashing Function
function hash_passwd($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

// Password Verfification
function verify_passwd($password, $hashed_password)
{
    return password_verify($password, $hashed_password);
}

function makeMySQLDateTime()
{
    return date('Y-m-d H:i:s');
}

function makeMySQLDate()
{
     return date('Y-m-d');
}

function makeMySQLDateFromString($date)
{
    return date('Y-m-d',strtotime($date));
}

function getWeekday($date) {
    return date('l', strtotime($date));
}


function get_finacial_year_range() {
    $year = date('Y');
    $month = date('m');
    if($month<7){
        $year = $year-1;
    }
    $start_date = date('d/m/Y',strtotime(($year).'-07-01'));
    $end_date = date('d/m/Y',strtotime(($year+1).'-06-30'));
    $year_range = date('Y',strtotime(($year).'-07-01'))."/".date('Y',strtotime(($year+1).'-06-30'));
    $response = array('start_date' => $start_date, 'end_date' => $end_date, 'year_range'=>$year_range);

    return $response;
}

function haversineGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6372.795477598)
{
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}