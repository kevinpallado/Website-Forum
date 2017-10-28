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
$user_data = mysqli_fetch_assoc($result); // fetch all data
//echo $user_data['username'];

	if(isset($_POST['confirm'])){
		$conf_arr = $_POST['confirm'];
	foreach($conf_arr as $id){
		header("location:discuss.php?topic=".$id);}}
	if(isset($_POST['save'])){
		$topic_name = $_POST['topic_name'];
		$author = $_POST['author'];
		$user_id = $user_data['user_id'];
		$sql = "INSERT INTO mytopic (topicname , author , user_id) VALUES ('$topic_name' , '$author', (SELECT user_id FROM myuser WHERE myuser.user_id=$user_id))";
		if($db->query($sql) === TRUE){
			header("location:homepage.php");
		}
		else {
   		 echo "Error mytopic recording: " . $db->error;
		}
	}
	else{
        $_SESSION['message'] = "Error Post! ";
          
      }

$total_user = mysqli_num_rows(mysqli_query($db,"SELECT * FROM myuser"));
$total_topic_post = mysqli_num_rows(mysqli_query($db,"SELECT * FROM mytopic"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Forum</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/search_box.css">
  <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <script>
function showUser(str) {
    if (str == "") {
        document.getElementById("result").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("result").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","sort.php?asc="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>
<div class="container">
	<header>
		<div class="dropdown" style="float: right; margin-top: 15px;">
			<h4>Welcome! <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><?php echo $user_data['username'];?><span class="caret"></span></button>
  					<ul class="dropdown-menu">
    					<li><a href="profile.php">Profile</a></li>
    					<li><a href="logout.php">Change User</a></li>
    				</ul>
    		</h4>
    	</div>
    </header>
</div>
<body style="background-color:lightblue;">
	<div class="container" style="margin-top: 70px;margin-bottom: 50px;">
		
			<div id="myModal" class="modal fade" role="dialog">
  				<div class="modal-dialog">

    				<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal">&times;</button>
        					<h4 class="modal-title">Snap-Post!</h4>
      					</div>
      						<form method="post">
      							<div class="form-group">
				      				<div class="modal-body">
				        				<label for="topic_name">Topic Content:</label><textarea class="form-control" rows="5" id="comment" name="topic_name"></textarea>
				        				<label for="author">Author:</label>
				        				<select name="author" size="1" class="form-control">
												<option selected disabled>Who are you?</option>
												<option value='student'>Student</option>
												<option value='guest'>Guest</option>
										</select>
				      				</div>
				      				<div class="modal-footer">
				       					<input type="submit" class="btn btn-info" name="save" value="Go"></input>
				      				</div>
    							</div>
    						</form>
    				</div>
  				</div>
			</div>
	<div class="col-md-12">
		<div class="page-header">
			<h4>
				Latest : Subject Matter
				<button class="fa fa-comments-o btn btn-primary btn-md" data-toggle="modal" style="float:right;margin-top:-10px;" data-target="#myModal"> Create new thread</button>
			</h4>
			<br><br>
			  <table class="table table-bordered">
			  <thead>
      			<tr>
			        <th><center>Number of User(s) Registered</center></th>
			        <th><centeR>Number of Posted Topic(s)</center></th>
      			</tr>
      		  <tbody>
				<tr>
			        <td><center><?php echo $total_user; ?></center></td>
			        <td><center><?php echo $total_topic_post;?></center></td>
     			</tr>
     		  </tbody>
      		</thead>
      		</table>
      		<br><br>
    </thead>
		</div>
 			<div class="panel panel-info">
				<div class="panel-heading "> 
					<span class=""> Topics
						<form method="post" action="search.php">
							<label style="display:inline-block;">Sort by:
								<select name="sortby" size="1" onchange="showUser(this.value)">
									<option selected disabled>Sort by</option>
									<option value='1'>Topic</option>
									<option value='2'>Date</option>
							</select></label>
							<button type="submit" name="search_go" class="btn btn-warning fa fa-search" style="float:right;margin-top;display: inline-block;-25px;margin-left: 20px;"> Go</button>
							<input type="text" name="search_box" style="float:right;display: inline-block;" placeholder=" Search topic...">
						</form>
			 	</div>
						 
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
						<table>
							<div class="container">
								 <div id="result">
						<?php 
						$postdata = "SELECT * FROM mytopic";
						$output = mysqli_query($db,$postdata);
						if ($output->num_rows >0) {
							    // output data of each row
							    while($row = $output->fetch_assoc()) {
							     	echo "<strong class=text-uppercase><br>Content : " . $row["topicname"]."<br><br>Author: " . $row["author"]. "<br><br>Posted in : " .$row["reg_date"]. "</strong><br><br>Posted by : ";
							        $user_id = $row["user_id"];
							        $topic_id = $row["topic_id"];
							        $user_id_topic = mysqli_fetch_assoc(mysqli_query($db,"SELECT username FROM myuser WHERE user_id = '$user_id'"));
							        foreach($user_id_topic as $id_topic){
							        echo "<em><mark>" .$id_topic."</mark></em>";
							    }
							        echo '<form method="post" >
							        		<button type="submit" style="float: right;margin-right:100px; margin-top:-25px;"class="btn btn-info fa fa-folder-open" name="confirm['.$topic_id.']" value="'.$topic_id.'">  View</button>
							        	</form> <br> <hr style="display:block;border-width:5px;width:91%;">';
							    }
							}
						?>
							</div>
						</table>
						</div>
					</div>
				</div>				
			</div>
	</div>
	</div>
</body>
</html>