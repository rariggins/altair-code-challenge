<?php @session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Tasks</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="public/css/custom.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Altair Code Challenge</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar1">
          <ul class="nav navbar-nav pull-right">
            <?php if (isset($_SESSION['user_id'])) { ?>
              <li><p class="navbar-text">Hi! <?php echo $_SESSION['user_name']; ?></p></li>
              <li><a href="task.php">Tasks</a></li>
              <li><a href="logout.php">Logout</a></li>
            <?php } else { ?>
              <li><a href="#" data-toggle="modal" data-target="#signup-modal">Sign Up</a></li>
              <li class="active"><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- modal signup form -->
    <div id="signup-modal" class="modal fade" aria-labelledby="SignUp" aria-hidden="true" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="signup-modal-container">
          <form id="signup-form" role="form">
            <div class="modal-body">
              <h2>Signup for an Account</h2>
              <div id="err-msg"></div>
              <div class="form-group">
                <input type="text" id="fname" name="fname" placeholder="First Name" class="form-control input-lg" />
              </div>
              <div class="form-group">
                <input type="text" id="lname" name="lname" placeholder="Last Name" class="form-control input-lg" />
              </div>
              <div class="form-group">
                <input type="text" id="email" name="email" placeholder="Your email address" class="form-control input-lg" />
              </div>
              <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" class="form-control input-lg" />
              </div>
              <div class="form-group">
                <div id="captcha"></div>
              </div>
              <div class="form-group">
                <input type="submit" id="signup" name="signup" value="signup" class="btn btn-primary btn-block btn-lg" />
              </div>
            </div>
          </form>
        </div>
     </div>
    </div>

    <!-- modal login form -->
    <div id="login-modal" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="login-modal-container">
          <form id="login-form" role="form">
            <div class="modal-body">
              <h2>Login to Your Account </h2>
              <div id="err-msg"></div>
              <div class="form-group">
                <input type="text" id="email" name="email" placeholder="Your email address" class="form-control input-lg" />
              </div>
              <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" class="form-control input-lg" />
              </div>
              <div class="form-group">
                <div id="captcha"></div>
              </div>
              <div class="form-group">
                <input type="submit" id="login" name="login" value="Sign In" class="btn btn-primary btn-block btn-lg" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
