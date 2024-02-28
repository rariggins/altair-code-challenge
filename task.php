<?php
  $controller = "TaskController";
  $function = "index";
  require_once  'config/config.php';
  if (isset($_GET['controller']) && !empty($_GET['controller'])) 
  {
      $controller = $_GET['controller'];
  }
  if (isset($_GET['function']) && !empty($_GET['function'])) 
  {
      $function = $_GET['function'];
  }
  if (file_exists('app/controller/' . $controller . '.php')) 
  {
    include('app/controller/TaskController.php');
    $class = $controller;
    $obj = new $class();
    if (method_exists($class, $function)) {
      $obj->$function();
    } else {
      echo 'Function not found';
    }
  } else {
      echo 'Controller not found';
  }
?>