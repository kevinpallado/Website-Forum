<?php
include("config.php"); // database connection
$reply_id= @$_GET["reply"]; // gkuha ni ang id sa nag reply bali ang tag-iya sa nag reply NOTE: kani btaw ang value ani kay gkan sa lain nga page
$mysql = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM myreply WHERE reply_id = '$reply_id'"));
$topic_id = $mysql['topic_id'];


  if(isset($_POST['save_edit'])){ // if tuplokon niya ang save edit suggod ang operation
    $topic_content = $_POST['topic_content']; // gkuha niya ang content sa imung e update na reply
    $sql = "UPDATE myreply SET reply_content = '$topic_content' WHERE reply_id = '$reply_id'"; // sql command
    $mysql = mysqli_query($db,$sql); // iyang ge load sa table bali dari na nag access sa table btaw
    if($mysql){ // if na success ang pasabot anang argument dha is if(true) adto dayun siya
      header("location:discuss.php?topic=".$topic_id);
      die();
    }
    else{
       echo "Error updating record: " . $conn->error;
    }
  }
  if(isset($_POST['cancel_edit'])){
    header("location:discuss.php?topic=".$topic_id);
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
			<script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
			<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js">  </script>
	</head>
	<body>
	<div class="container" style="text-align:center;position:absolute;top:100px;width:100%;">
  <div class="form-group">
  <form method="post">
   <label for="comment">Edit Reply:</label>
  <textarea class="form-control" rows="10" id="comment" name="topic_content"></textarea> <!--DARI SIYA NAG SULAT SA IYANG UPDATE-->
  <br>
  <input type="submit" class="btn btn-info btn-lg" name="save_edit" value="Save Edit"> <!--trigger para save-->
   <input type="submit" class="btn btn-warning btn-lg" name="cancel_edit" value="Cancel"> <!--trigger para save-->
  </form>
  </div>
  </div>
	</body>
</html>