<?php
class UserModel extends DBConn
{

    public function __construct()
    {
      parent::__construct();
    }

    function userLogin($email, $pwd)
    {
      $result = $this->obj->query("SELECT * FROM users WHERE email = '" . $email. "' and password = '" . md5($pwd) . "'");
        
      if ($result->num_rows > 0)
      {
        // success
        @session_start();
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        return true;
      }
      else
      {
        // login fail
        return false;
      }
    }
        
    function insert_user($fname, $lname, $email, $pwd)
    {
      echo 'In function';
      $result = $this->obj->query("INSERT INTO users(first_name, last_name, email, password) VALUES ('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $pwd . "')");
      echo $result;

      if ($this->user_model->insert_user($data))
      {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">You are Successfully Registered! Please login to access your Profile!</div>');
        redirect('login/index');
      }
      else
      {
        // error
        $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
        redirect('signup/index');
      }
    }
    
    function userLogout()
    {
      session_destroy();
      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      return;
    }
    
    function escapeString($str) {
      return $this->obj->real_escape_string($str);
    }
}
?>