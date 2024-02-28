<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
        
  require_once('config.php');
  // require_once('log.php');

  class MySQL extends DBconn
  { 
    public $lf = "\n";

    public function Database($set_database) {
      $this->database = $set_database;

      $this->connection->select_db($this->database) or die('Cannot select Database');
    }

    protected function getResults($sql, $debug) {
      // print("\n\nLINE: " . __LINE__ . ": " .$sql . "\n");
      if($debug) {
        print($this->lf. $this->lf . 'LINE: ' . __LINE__ . ': ' .$sql . $this->lf);
      }

      if($this->CheckConnection() === false) {
        return false;
      }
      $this->result = $this->connection->query($sql);

      return $this->result;
    }

    protected function checkConnection() {
      if(!$this->connection) {
        $e = 'What we\'ve got here is a failure to communicate. (checkConnection)' . mysqli_connect_error();
        $this->logFile->errors[] = new ErrorData(array('fileName' => 'onboard_db_classes', 'lineNumber' => __LINE__, 'errorText' => '', 'errorCode' => $e));
        return false;
      } else {
        return true;
      }
    }

    protected function checkTable($table, $debug) {
      $sql = "SHOW TABLES FROM $this->dbName LIKE '$table';";
      if($debug) {
        print($sql);
      }
      $this->tableExists = $this->connection->query($sql);

      if(!$this->tableExists) {
        $e = $table . 'does not exists in the ' . $this->dbName . ' (checkTable)';
        $this->logFile->errors[] = new ErrorData(array('fileName' => 'onboard_db_classes', 'lineNumber' => __LINE__, 'errorText' => '', 'errorCode' => $e));

        echo 'Exception handling: ' . $e;
        return false;
      } else {
        if(mysqli_num_rows($this->tableExists) == 1) {
          return true;
        }
      }
    }

    public function execute($sql, $table, $debug) {
      if($this->checkConnection() === false) {
        return false;
      }

      $this->dataResult = array();

      if($this->checkTable($table, $debug)) {
        $this->execute = $this->getResults($sql, $debug);

        if($this->execute === false) {
          return false;
        }
        if(!is_bool($this->execute)) {
          while($this->row = mysqli_fetch_assoc($this->execute)) {
            $this->dataResult[] = $this->row;
          }
        } else {
          $this->logFile->errors[] = new ErrorData('onboard_db_classes', __LINE__, 'I have no data to return.', '');
        }
        return $this->dataResult;
      } else {
        return false;
      }
    }

    public function select($debug, $table, $table_alias = '', $fields = '*', $join = null, $condition = '', $sort = '', $order = ' ASC ', $clause = 'AND', $limit = null) {
      /*
        @param table      - the target table name
        @param rows       - fields to find (comma seperated)
        @param join       - table joins can be assoc array with join_type => left, table name => field name 
        @param condition  - condition can be string, array of object, array of array
        @param sort       - the field name that you want to be sorted
        @param order      - ASC/DESC
        @param clause     - AND/OR
        @return array
      */
      $dataResult = array();

      $this->sql = "SELECT " . $fields . " FROM " . $table . ' ' . $table_alias;

      if($join != null) {
        $this->sql .= $this->joins($table, $table_alias, $join);
      }
      if(!empty($condition)) {
        $this->sql .= $this->where($condition, $clause);
      }
      if(!empty($sort)) {
        $this->sql .= " ORDER BY " . $sort . " $order";
      }
      if($limit != null) {
        $this->sql .= ' LIMIT ' . $limit;
      }
      $this->dataResult = $this->execute($this->sql, $table, $debug);
      return $this->dataResult;
    }

    public function insert($debug, $logFile, $table, $params) {
      $lf = "\n";

      if($this->checkConnection() === false) {
        return false;
      }

      if($this->checkTable($table, $debug)) {
        $this->sqlQuery = 'INSERT INTO `' . $table . '` (`' . implode('`, `', array_keys($params)) . '`)' . ' VALUES ' . $lf . '(' . implode(', ', array_values($params)) . ')' . 
          $lf . ' ON DUPLICATE KEY UPDATE ' . $lf;
        foreach ($params as $key => $value) {
          $this->sqlQuery .= '`' . $key . '` = ' . $value;
          if($key != array_key_last($params)) {
            $this->sqlQuery .= ',' . $lf;
          } else {
            $this->sqlQuery .= ';' . $lf;
          }
        }

        if($debug) {
          print($this->sqlQuery . $lf);
        }

        if($this->connection->query($this->sqlQuery))
        {
          return true;
        } else {
          $logFile->errors[] = new ErrorData(array('fileName' => 'onboard_db_classes', 'lineNumber' => __LINE__, 'errorText' => '', 'errorCode' => mysqli_error($this->connection)));          
        }
      }
    }

    protected function where($condition, $clause) {
      $this->query = " WHERE ";
      if(is_array($condition)) {
        $this->size = count($condition);

        if($this->size > 1) {
          for($i = 0; $i < $this->size; $i++) {
            $this->query .= $condition[$i];
            if($this->size - 1 != $i) {
              $this->query .= " $clause ";
            }
          }
        } else {
          $this->query .= $condition[0];
        }
      } else if(is_string($condition)) {
        $this->query .= $condition;
      } else {
        $this->query = "";
      }
      return $this->query;
    }

    protected function joins($table, $table_alias, $join) {
      $this->result = '';
      foreach($join as $value) {
        $this->result .= ' ' . $value['type'] . ' JOIN ' . $value['table'] . ' ' . $value['alias'] . ' ON ';
        if($table_alias != '') {
          $this->result .= $table_alias;
        }
        else {
          $this->result .= $table;
        }
        $this->result .= '.' . $value['onField'] . " = " . $value['alias'] . '.' . $value['onField'] . "\n";
      }
      return $this->result;
    }

    public function isValid($result) {
      if(is_array($this->result) && count($this->result) > 0) {
        return true;
      }
      return false;
    }

    public function __destruct() {
      $this->sqlQuery     = NULL;
      $this->databaseName = NULL;
      $this->hostName     = NULL;
      $this->userName     = NULL;
      $this->passCode     = NULL;
    }
  }
?>