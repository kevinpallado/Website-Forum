<?php
$conn = mysqli_connect("localhost","root","","userdb") or die("Could't connect");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])){
  $idnumber = $_POST['idnumber'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $college = $_POST['college'];
  $course = $_POST['course'];
  $contact = $_POST['contact'];
  $password = $_POST['password'];
  $password = md5($password); // encyyption of password
  $test = "SELECT username FROM myuser WHERE username='$username'";
  $mysql = mysqli_query($conn, $test);
      if(mysqli_num_rows($mysql) == 0){ 
      
        $sql = "INSERT INTO myuser (idnumber, username, college, course, contactno ,email, password) VALUES('$idnumber','$username','$college','$course' ,'$contact','$email','$password')";
        mysqli_query($conn,$sql);
        header("location: login.php");

      }else{
        $_SESSION['message'] = "Your username is already taken ";
          
      }
}
  if(isset($_POST['cancel'])){
    header("location: login.php");
  }
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="select_js/samok.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<?php
  if(isset($_SESSION['message'])){
    echo "<div id='error_msg'>".$_SESSION['message']."</div>";
    unset ($_SESSION['message']);
  }
?>

  <h2>Registration Form</h2>
      <br>
      <h4>Personal Information</h4>
      <br>
  <form method="post" action="register.php">
    <div class="form-group">
      <label for="idnumber">ID Number:</label><input type="text" class="form-control" id="idnumber" name="idnumber" placeholder="Enter ID number" required>
      <label for="username">Username:</label><input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
    <label for="college">College:</label>

      <select name="college" id="college" class="form-control" onchange="configureDropDownLists(this,document.getElementById('course'))">
        <option selected disabled>Select College</option>
        <option value="CEA">College of Engineering</option>
        <option value="CITC">College of Information Technology and Computing</option>
        <option value="CAS">College of Arts and Science</option>
      </select>
      <label for="course">Course:</label>
        
      <select name="course" id="course" class="form-control">
        <option selected disabled="">Select College</option>
      </select>
      <br>
      <h4>Contact Information</h4>
      <br>
      <label for="contactnumber">Contact Number:</label><input type="number" class="form-control" name="contact" id="contact" placeholder="Contact Number" required>
      <label for="email">Email:</label><input type="email" class="form-control" id="contact" name="email" placeholder="Email Address" required>
      <div class="fieldWrapper">
      <label for="password">Password:</label><input type="password" class="form-control" id="password" placeholder="Enter Password" required>
      <label for="password">Confirm Password:</label><input type="password" class="form-control" id="cpassword" name="password" placeholder="Password"  onkeyup="checkPass(); return false;" required>
      <span id="confirmMessage" class="confirmMessage"></span>
      </div>
      <br>
      <input class="btn btn-primary" type="submit" value="Submit" name="submit">
  </form>
      <form method="post">
       <button style="float: right; margin-top: -35px;" class="btn btn-danger" type="cancel" name="cancel">Cancel</button>
       </form>
       </div>
</div>
</body>
</html>
