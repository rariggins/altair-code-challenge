<?php
  require_once 'BaseController.php';
  class TaskController extends BaseController
  {
    public function __construct()
    {
      parent::__construct();
      include('app/model/taskModel.php');
      $this->obj = new taskModel();
    }

    public function index()
    {
      $this->loadView('view/partials/task.php');
    }

    public function fetch()
    {
      $data = $this->obj->task();
      $response = [
        'success' => true,
        'total' => count($data),
        'tasks' => $data
      ];
      echo json_encode($response);
      exit();
    }

    public function create()
    {
      if(isset($_POST) && !empty($_POST)) {
        $task = $_POST['task'];
        $data = $this->obj->addTask($task);
        if($data) {
          $response = [
            'success' => true,
            'message' => 'Task has been created!'
          ];
        } else {
          $response = [
            'success' => false,
            'message' => 'Unable to create task!'
          ];
        }

        echo json_encode($response);
        exit();
      }
    }

    public function delete()
    {
      if(isset($_POST)) {
        $id = $_POST['task_id'];
        $task = $this->obj->deleteTaskById($id);
        if($task) {
          $response = [
            'success' => true,
            'message' => 'Task has been succesfully deleted!'
          ];
        } else {
          $response = [
            'success' => false,
            'message' => 'Unable to delete task!'
          ];
        }

        echo json_encode($response);
        exit();
      }
    }

    public function edit()
    {
      if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $task = $this->obj->getTaskById($id);
        $response = [
          'success' => true,
          'id' => $id,
          'task' => isset($task['task']) ? $task['task'] : null
        ];

        echo json_encode($response);
        exit();
      }
    }

    public function update()
    {
      if(isset($_POST) && !empty($_POST)) {
        $id = $_POST['taskId'];
        $task = $_POST['task'];
        $data = $this->obj->updateTaskById($id, $task);
        if ($data) {
          $response = [
            'success' => true,
            'message' => 'Task was sucessfully updated!'
          ];
        } else {
          $response = [
            'success' => false,
            'message' => 'Unable to update task!'
          ];
        }

        echo json_encode($response);
        exit();
      }
    }
  }
?>