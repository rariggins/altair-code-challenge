<?php
  require_once 'BaseController.php';
  class UserController extends BaseController
  {
    public function __construct()
    {
      parent::__construct();
      include('app/model/UserModel.php');
      $this->obj = new userModel();
    }

    public function index()
    {
      $this->loadView('view/partials/footer.php');
    }

    function login($email, $pwd)
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
    
    
    function signup()
    {
      // set form validation rules
      $this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha|min_length[3]|max_length[30]|xss_clean');
      $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha|min_length[3]|max_length[30]|xss_clean');
      $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[user.email]');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[cpassword]|md5');
      $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required');

      // submit
      if ($this->form_validation->run() == FALSE)
      {
          // fails
        $this->load->view('signup_view');
      }
      else
      {
          //insert user details into db
        $data = array(
          'fname' => $this->input->post('fname'),
          'lname' => $this->input->post('lname'),
          'email' => $this->input->post('email'),
          'password' => md5($this->input->post('password'))
        );

        if ($this->obj->insert_user($data))
        {
          $this->session->set_flashdata('msg','<div class="alert alert-success text-center">You are Successfully Registered! Please login to access your Profile!</div>');
          redirect('signup/index');
        }
        else
        {
          // error
          $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
          redirect('signup/index');
        }
      }
    }
  }
?>