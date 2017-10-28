<?php
include("config.php");
$topic_id = @$_GET["topic_id"];

if(isset($_POST['save_topic_edit'])){
		$topic = $_POST['edit_topic_content'];
		$sql = "UPDATE mytopic SET topicname = '$topic' WHERE topic_id = '$topic_id'";
		$mysql = mysqli_query($db, $sql);
		if($mysql) {
		header("location:homepage.php");
		die();}
	}
if(isset($_POST['cancel_topic_edit'])){
	header("location:discuss.php?topic=".$topic_id);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit topic</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
		<script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
		<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js">  </script>
</head>
<body>
	<div class="container" style="text-align:center;position:absolute;top:100px;width:100%;">
		<form method="post">
			<div class="form-group">
				<label for="topic_content">Edit topic content</label>
				<textarea class="form-control" rows="10" name="edit_topic_content" class="form-control"></textarea>
				<br>
				<input type="submit" class="btn btn-info btn-lg" name="save_topic_edit" value="Save">
				<input type="submit" class="btn btn-warning btn-lg" name="cancel_topic_edit" value="Cancel">
			</div>
		</form>
	</div>
</body>
</html>