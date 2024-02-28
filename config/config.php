<?php
  //site name
  define('SITE_NAME', 'altair-code-challenge');

  //App Root
  define('APP_ROOT', dirname(dirname(__FILE__)));
  define('URL_ROOT', '/');
  define('URL_SUBFOLDER', '');


  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  
  // require_once('include/log.php');

  class DBConn {
    private $serverName   = 'localhost:3306';  // host name
    private $userName     = 'root';   // user name
    private $passCode     = 'root';   // password
    protected $dbName     = 'todolist';
    // private $port         = 0000;         // specified port number
    // private $client_key   = 'client-key.pem';   // path name to the key file
    // private $client_cert  = 'client-cert.pem';  // path name to the certificate authority file
    // private $server_ca    = 'server-ca.pem';    // path name to the directory that contains trusted SSL CA certificates (PEM format)
    
    public $conn          = null;
    
    function __construct()
    {
      // create Log File
      // $logFile = new LogFile();
      // $logFile->errors[] = new ErrorData(array('fileName' => '', 'lineNumber' => '', 'errorText' => 'Log File: ', 'errorCode' => $logFile->currentDate));

      $this->conn = new mysqli($this->serverName, $this->userName, $this->passCode, $this->dbName);

      // $this->conn->ssl_set($this->client_key, $this->client_cert, $this->server_ca, NULL, NULL);

      $this->db = $this->conn->real_connect($this->serverName, $this->userName, $this->passCode, $this->dbName, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);

      if(!$this->db) {
        $e = 'What we\'ve got here is a failure to communicate. ' . mysqli_connect_error();
        // $logFile->errors[] = new ErrorData(array('fileName' => 'dbconfig', 'lineNumber' => __LINE__, 'errorText' => 'Exception Handling: ', 'errorCode' => $e));

        // print('Exception handling: ' . $e);
        return false;
      } else {
        // $logFile->errors[] = new ErrorData(array('fileName' => 'onboard_dbconfig', 'lineNumber' => __LINE__, 'errorText' => 'Connection Established Successfully', 'errorCode' => ''));
        // print("Connection Established Successfully\n\n\n");
      }

      // if(count($logFile->errors) > 0) {
      //   // var_dump($logFile->errors);
      //   $logFile->printErrors($logFile);
      // };

      return $this->conn;
    }
  }
?>