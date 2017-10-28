<?php
session_id("loginuser");
session_start();
if(!empty($_SESSION['login_user'])){
  header("location:homepage.php");
  exit;
}
include("config.php");
if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
    $myusername = mysqli_real_escape_string($db,$_POST['username']);
    $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
    $mypassword = md5($mypassword); // encrption of password
    $result = mysqli_query($db,"SELECT username,password FROM myuser WHERE username = '$myusername' and password = '$mypassword'");
    $count = mysqli_num_rows($result);
    if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         header("location:homepage.php");
      }else {
       echo "<script>
        alert('Error: Invalid username or password!!');
       window.location.href='login.php';
        </script>";
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="jumbotron" style="background-color:powderblue;text-align:left;padding-left:100px;">
	
	<h1>Snap-Post</h1>
	<p>An online discussion exclusively for USTsP students (formerly MUST) and all graduates from this institution</p>
</div>
<div class="container" style="width:50%;">

<form method="post" action="login.php">
<div class="form-group">
	<h3>Login</h3>
	  <input type="text" class="form-control" id="username" name="username" placeholder="Username">
</div>
<div class="form-group">
	  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
</div>
<h5>Not a member?
<a href="register.php">Register</a>
</h5>
<input class="btn btn-primary" type="submit" name="submit" value="Go">

</form>
</div>
<hr style="display:block;border-width:5px;margin-left:75px;margin-right:75px;margin-top:150px;">
<div class="container">
	<h6 style="text-align:right;">All rights reserved <span class="label label-default">@Kevin Ren B. Pallado</span></h6>
</body>
</html>