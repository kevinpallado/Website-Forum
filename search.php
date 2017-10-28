<?php
session_start();
if(empty($_SESSION['login_user'])){
  header("location:login.php");
  exit;
}
include("config.php");
$user = $_SESSION['login_user'];
$check = "SELECT * FROM myuser WHERE username='$user'";
$result = mysqli_query($db,$check);
$user_data = mysqli_fetch_assoc($result); 
?>
<!DOCTYPE html>
<html>
<head>
	  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/search_box.css">
  <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<div class="container">
	<header>
		<div class="dropdown" style="float: right; margin-top: 15px;">
			<h4>Welcome! <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><?php echo $user_data['username'];?><span class="caret"></span></button>
  					<ul class="dropdown-menu">
  						<li><a href="homepage.php">Homepage</a></li>
    					<li><a href="profile.php">Profile</a></li>
    					<li><a href="logout.php">Change User</a></li>
    				</ul>
    		</h4>
    	</div>
    </header>
</div>
<body style="background-color:lightblue;">
	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading "> 
				<span class=""> Topics</span>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<table>
								<div class="container">
									<?php
										$search = $_POST['search_box'];
										$counter = 1;
										if(($search == NULL) && ($counter == 1)){
												echo "<script>
												alert('Empty Field!');
												window.location.href='homepage.php';
												</script>";
										}
										else{
										$search = mysql_real_escape_string($search);
										#echo "$search";
										$all = "SELECT * FROM mytopic WHERE topicname LIKE '%$search%'";
										$output = mysqli_query($db,$all);
										$count_search = mysqli_num_rows($output);
												if ($output->num_rows >0) {
													while($row = $output->fetch_assoc()) {
											     	echo "<strong class=text-uppercase><br>Content : " . $row["topicname"]."<br><br>Author: " . $row["author"]. "<br><br>Posted in : " .$row["reg_date"]. "</strong><br><br>Posted by : ";
											        $user_id = $row["user_id"];
											        $topic_id = $row["topic_id"];
											        $user_id_topic = mysqli_fetch_assoc(mysqli_query($db,"SELECT username FROM myuser WHERE user_id = '$user_id'"));
											        foreach($user_id_topic as $id_topic){
											        echo "<em><mark>" .$id_topic."</mark></em>";}
											        echo '<form method="post" >
											        		<button type="submit" style="float: right;margin-right:100px; margin-top:-25px;"class="btn btn-info fa fa-folder-open" name="confirm['.$topic_id.']" value="'.$topic_id.'">  View</button>
											        	</form> <br> <hr style="display:block;border-width:5px;width:91%;">';}}
												else{
													echo "<script>
												alert('Error:Walay ma search');
												window.location.href='homepage.php';
												</script>";
												}
										}

										if(isset($_POST['confirm'])){
												$conf_arr = $_POST['confirm'];
												foreach($conf_arr as $id){
													header("location:discuss.php?topic=".$id);}}

									?>
									<h3><?php echo $count_search; ?> Search Result</h3>
								</div>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>
</html>