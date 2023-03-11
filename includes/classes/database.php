<?php


/**
 * MySQLi database; only one connection is allowed.
 */
class database {
  private $_connection;

  // Store the single instance.
  private static $_instance;
  private static  $_last_query;


  /**
   * Get an instance of the Database.
   * @return database
   */
  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * Constructor
   */
  public function __construct() {
  	
    $this->_connection = new mysqli("localhost", "root", "", 'maaif');
    // Error handling.
    if (mysqli_connect_error()) {
      trigger_error('Failed to connect to MySQL: ' . mysqli_connect_error(), E_USER_ERROR);
    }
  }

  /**
   * Empty clone magic method to prevent duplication.
   */
  private function __clone() {

  }

  /**
   * Get the mysqli connection.
   */
  public function getConnection() {
    return $this->_connection;
  }


  //Query Database using current instance
  public static function performQuery($sql) {
  	$db = database::getInstance();
  	$mysqli = $db->getConnection();
  	self::$_last_query = $sql;
  	$result = $mysqli->query($sql);
    if(!$result){
      echo "<pre>".$mysqli -> error." ".self::$_last_query."<pre><br />";
    }
  	//self::confirm_query($result);
  	return $result;
  }


  public static function prepData($data)
  {
      $db = self::getInstance();
      $mysqli = $db->getConnection();
      
      try {
        $data = $mysqli->real_escape_string($data);
      } catch (\Throwable $th) {
        $d = json_encode($data);
        $data = $mysqli->real_escape_string($d);
      }
      $data = addslashes($data);
      return $data;
  }

  public static function confirm_query($result) {
  	if (!$result) {
  //	echo " Internal server problem.<br />";
  	echo "<pre>".self::$_last_query."<pre><br />";
  //	echo $result->error();
  	}
}

  public static function getLastInsertID()
  {
  	$db = database::getInstance();
  	$mysqli = $db->getConnection();
  	return $mysqli->insert_id;
  }

  /**
   * Get GRM Database configurations.
   * @return array
   */
  public static function getGRMConfigs() {
    return [
      'host'      => 'localhost',
      'user'      => 'root',
      'database'  => 'e_grm',
      'password'  => 'MaaifExt@1234!'
    ];
  }

  public function getDBConfigs(){
    return [
      'host'      => 'localhost',
      'user'      => 'root',
      'database'  => 'e_extension_staging',
      'password'  => 'MaaifExt@1234!'
    ];
  }

}


//Create new Database object and store it in $db
$database = database::getInstance();
$database = $database->getConnection();
$db =&$database;
