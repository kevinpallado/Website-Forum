<?php
session_start();
if(empty($_SESSION['login_user'])){
  header("location:login.php");
  exit;
}
include("config.php");
$user = $_SESSION['login_user'];
$user_data = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM myuser WHERE username='$user'")); // fetch all data
$user_id = $user_data['user_id'];
	if(isset($_POST['edit'])){
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		$mysql = mysqli_query($db,"UPDATE myuser SET email='$email' , contactno='$contact' WHERE username='$user'");
		if($mysql) {
		header("location:profile.php");
		die();
		}
			else {
    echo "Error updating record: " . $db->error;
	}
	}
  	if(isset($_POST['home'])){
  		echo header("Location: homepage.php");
  		die();
  	}

if(isset($_POST["upload"])) {
	echo '<script>

	</script>';
	include 'upload.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profile</title>
		  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js">  </script>
  <script type="text/javascript">
	function chk_control(str){
 	email = document.getElementById('email');
  	contact = document.getElementById('contact');
  	edit = document.getElementById('edit');
  	save = document.getElementById('savep');
  	toggle = document.getElementById('toggle');
  	file = document.getElementById('fileToUpload');
  	upload = document.getElementById('upload')
  		
  	if ( edit.checked == true )
  	{
  		save.style.display="block";
  		email.disabled = false;
  		contact.disabled = false;
      	toggle.disabled = true;
      	file.disabled = false;
      	upload.disabled = false;
  	}
  	else{
  		email.disabled = true;
  		contact.disabled = true;
      	toggle.disabled = false;
  		save.style.display="none";
      	file.disabled = true;
      	upload.disabled = true;
  	}
  }
  </script>
 

</head>
<header>
		<div class="container">
					<div class="dropdown" style="float: right; margin-top: 15px; margin-right:9.4px;">
					<h4>Welcome! <button class="btn btn-warning dropdown-toggle" id="toggle" data-toggle="dropdown"><?php echo $user_data['username'];?><span class="caret"></span></button>
  								<ul class="dropdown-menu">
			    					<li><a href="homepage.php">Homepage</a></li>
			    					<li><a href="logout.php">Change User</a></li>
    							</ul>
    				</h4>
    				</div>
		</div>
</header>
<body style="background-color:lightblue;">
	<div class="container" style="margin-top:20px;">
		<div class="form-group">
		<div class="col-xs-4">
		<form method="post" action="profile.php">
		<label for="idnumber">ID Number:</label><input class="form-control" type="number" selected disabled="" value="<?php echo $user_data['idnumber'];?>">
		<label for="username">Username:</label><input class="form-control" type="text" selected disabled="" value="<?php echo $user_data['username'];?>">
		<label for="college">College:</label><input class="form-control" type="text" id="college" disabled value="<?php echo $user_data['college'];?>">
		<label for="course">Course:</label><input class="form-control" type="text" id="course" disabled value="<?php echo $user_data['course'];?>">
		</form>
		</div>
		<form method="post" enctype="multipart/form-data">
		<img src="<?php
		$conn = new mysqli('localhost', 'root', '','userdb');
		$sql = "SELECT * FROM myuser WHERE username='$user' ";
		$result=$conn->query($sql);
		$pic=$result->fetch_assoc();
		 echo $pic['image'];

		 ?>" class="img-thumbnail" style="margin-top:25px;margin-left:100px;" width="200" height="200">
		<input type="file" name="fileToUpload" id="fileToUpload" disabled style="margin-left:480px; display: inline-block; float:left; clear:left; text-align:left;">
		<input type="submit" name="upload" id="upload" disabled style="display:inline-block; float:left;" id="upload" value="Update Profile" style="text-align:right">
		</form>
		</div>
	</div>
		<br>
		<br>
		<br>
		<br>
		<br>
	<div class="container">
		<form method="post">
		<div class="form-group">
		<h3>Contact Info</h3>
		<label for="email">E-mail:</label><input class="form-control" id="email" name="email" type="email" disabled value="<?php echo $user_data['email'];?>">
		<label for="contact">Contact Number:</label><input class="form-control" name="contact" id="contact" type="number" disabled="" value="<?php echo $user_data['contactno'];?>">
		<br>
     	<input type="submit" style="float: right; display :none;"class="btn btn-info" name="edit" value="Save Profile" id="savep">
		<h5 style="text-align:right;"><input type="checkbox" id="edit" name="edit" onClick="chk_control('enb')">Check to Edit Profile</h5>
		</div>
		</form>
	</div>
</body>
</html>