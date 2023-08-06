<?php
 session_start();
?>
<!DOCTYPE html>
<!---Coding By CoderGirl | www.codinglabweb.com--->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login & Registration Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- BOOTSTRAP STYLES-->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!---Custom CSS File--->
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="title"><h2>Welcome to E-Booking</h2></div>
  <div class="container">
  <?php
              if(isset($_SESSION['warning'])){
                ?>
                <div class="row alert alert-danger alert-dismissible ">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <?php echo $_SESSION['warning']; ?>
              </div>
                <?php
                  
                  unset($_SESSION['warning']);
              }
              ?>
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Login</header>
      <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <a href="#">Forgot password?</a>
        <input type="submit" class="button" value="Login" name="login">
      </form>
    </div>
    </div>
  </div>
</body>
</html>
