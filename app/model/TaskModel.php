<?php
  class TaskModel extends DBConn
  {
    public function __construct()
    {
      parent::__construct();
    }

    public function addTask($task)
    {
      $conn = $this->$db_conn;
      $taskSQL = 'INSERT INTO tasks(task) VALUES ("'.$task.'")';
      $data = mysqli_query($conn, $taskSQL) or mysqli_error($conn);
      return $data;
    }

    public function task()
    {
      $tasks = [];
      $conn = $this->$db_conn;
      $query = 'SELECT * FROM tasks order by due_date DESC';
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
      while($row = mysqli_fetch_assoc($result)) {
        array_push($tasks, $row);
      }
      return $tasks;
    }

    public function getTaskById($id)
    {
      $conn = $this->db_conn;
      $query = 'SELECT task FROM tasks WHERE task_id="'.$id.'"';
      $res = mysqli_query($conn, $query) or mysqli_error($conn);
      return mysqli_fetch_assoc($res);
    }

    public function updateTaskById($id)
    {
      $conn = $this->db_conn;
      $sql = 'UPDATE tasks SET 
              task="'.$task.'",
              updated_date = "'.date('Y-m-d h:i:s').'"
              WHERE id = "'.$id.'"';
      $data = mysqli_query($conn, $sql) or myslqi_error($conn);
      return $data;
    }

    public function delTaskById($id)
    {
      $conn = $this->db_conn;
      $query = 'DELETE FROM tasks WHERE id="' . $id . '"';
      $task = mysqli_query($conn, $query) or mysqli_error($conn);return $task;
    }
  }
?>