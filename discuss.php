<?php
	include("config.php");
	$topic_id= @$_GET["topic"];
	$topic = mysqli_query($db,"SELECT * FROM mytopic WHERE topic_id='$topic_id'");
	$topic_content = mysqli_fetch_assoc($topic);
	$print =  $topic_content['topic_id'];
	$user_topic = $topic_content['user_id'];


	session_start();
	if(empty($_SESSION['login_user'])){
  header("location:login.php");
  exit;
}
	$user = $_SESSION['login_user'];
	$check = "SELECT * FROM myuser WHERE username='$user'";
	$result = mysqli_query($db,$check);
	$user_data = mysqli_fetch_assoc($result); // fetch all data
	$user_id = $user_data['user_id'];// fetch all data

	if(isset($_POST['submit'])){
		header("location:homepage.php");}

	if(isset($_POST['replyarea'])){
			$textarea = $_POST['replyarea'];
			echo $user_id."/".$topic_id."/".$textarea;
			$reply = "INSERT INTO myreply (user_id,topic_id,reply_content) VALUES ($user_id,$topic_id,'$textarea')";
					if($db->query($reply) === TRUE){
					header("location:discuss.php?topic=".$topic_id);
				}
				else {
		   		 echo "Error mytopic recording: " . $db->error;
				}
	}
	if(isset($_POST['change_topic'])){
		if($user_id == $user_topic ){
		header("location:edit_topic.php?topic_id=".$topic_id);
		die();}
	}
	if(isset($_POST['delete_topic'])){
		if($user_id == $user_topic){
			$delete_reply = "DELETE FROM myreply WHERE topic_id ='$topic_id'";
			$output_delete = mysqli_query($db,$delete_reply);
			$sql = "DELETE FROM mytopic WHERE topic_id = '$topic_id'";
			$topic_delete = mysqli_query($db,$sql);
			if($topic_delete){
			header("location:homepage.php");
			die();
			}
			else{
				echo "Error".$db->error;
			}
		}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reply</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js">  </script>
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container">
	<form method="post">
		<div style="width:100%">
		<textarea disabled name="textarea" rows="10" style="width:100%;margin-top:20px;"><?php echo $topic_content['topicname'];?></textarea>
			<h4> <?php echo "<em>Author : " .$topic_content['author']. "</em>";?></h4>

			<?php
			if($user_id == $user_topic){
			echo '<input type="submit" class="btn btn-info" name="change_topic" value="Edit topic content">
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">DeleteTopic</button>
				  <div class="modal fade" id="myModal" role="dialog">
				    <div class="modal-dialog">
				    
				      <!-- Modal content-->
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          <h4 class="modal-title">Confirmation</h4>
				        </div>
				        <div class="modal-body">
				          <p>Are you sure you want to delete this topic?</p>
				        </div>
				        <div class="modal-footer">
				        <form method="post">
				        <button type="submit" class="btn btn-warning" name="delete_topic">Submit</button>
				        </form>
				          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				        </div>
				      </div>
				      
				    </div>
				  </div>';}
			?>
		<input type="submit" class="btn btn-primary"name="submit" value="Go back">
		<button type="button" class="btn btn-info" style="float:right;" data-toggle="modal" data-target="#myModalreply">Reply</button>
		</div>
	</form>
			  <!-- Trigger the modal with a button -->
			  <!-- Modal -->
			  <div class="modal fade" id="myModalreply" role="dialog">
			    <div class="modal-dialog">
			    
			      <!-- Modal content-->
			      <div class="modal-content">
			      <form method="post" action="<?php echo 'discuss.php?topic='.$topic_id.''; ?>">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title"><?php echo $topic_content['topicname'];?></h4>
			        </div>
			        <div class="modal-body" style="width:100%;">
			          <h4>Content</h4>
			          <textarea name="replyarea" rows="10" style="width:100%;"></textarea>
			        </div>
			        <div class="modal-footer">
			          <input type="submit" class="btn btn-default" name="reply" value="Reply">
			        </div>
			      </form>
			      </div>
			      
			    </div>
			  </div>
		<?php
								if(isset($_POST['replyyy'])){
								$reply_arr = $_POST['replyyy'];
								foreach($reply_arr as $reply_id){
										$replay_id = $reply_id;
								}
									$user_id_reply_id = "SELECT * FROM myreply WHERE reply_id = '$reply_id'";
									$output = mysqli_query($db,$user_id_reply_id);
									$result = mysqli_fetch_assoc($output);
									$output_reply = $result['user_id'];
									if($user_id == $output_reply){
										header("location:reply.php?reply=".$replay_id);}
							}
									if(isset($_POST['delete'])){
										$reply_arr = $_POST['delete'];
								foreach($reply_arr as $reply_id){
										$replay_id = $reply_id;}
									$user_id_reply_id = "SELECT * FROM myreply WHERE reply_id = '$reply_id'";
									$output = mysqli_query($db,$user_id_reply_id);
									$result = mysqli_fetch_assoc($output);
									$output_reply = $result['user_id'];
									if($user_id != $output_reply){	
											echo "<script>
											alert('Error: Not your reply! Don`t delete someone`s work!!!!!');
											window.location.href='homepage.php';
										</script>";
									}
									else{
										$delete_reply = "DELETE FROM myreply WHERE reply_id ='$reply_id'";
										$output_delete = mysqli_query($db,$delete_reply);
										if($output_delete){
											header("location:discuss.php?topic=".$topic_id);
											die();
										}else{
											echo "<script>
											alert('Error:Delete problem detected');
											window.location.href='homepage.php';
										</script>";
										}

									}
								}


					$replydata = "SELECT * FROM myreply WHERE topic_id = $topic_id";
					$output = mysqli_query($db,$replydata);
						if ($output->num_rows >0) {
							    // output data of each row
							$counter = 1;
							    while($row = $output->fetch_assoc()) {
							    	$user_id_reply = $row["user_id"];
							    	$user_reply_id = mysqli_fetch_assoc(mysqli_query($db,"SELECT username FROM myuser WHERE user_id = '$user_id_reply'"));
							     	foreach($user_reply_id as $id_reply){
							        echo "<br><br>User :<em><mark> ".$id_reply."</mark></em>";
							    }
							    	echo "<br><br>Reply content : " .$row["reply_content"]. "<br><br></h4>";
							     	#echo "<h4><br>Reply: " . $row["reply_id"]. " - User_id: " . $row["user_id"]."- Topic ID: " . $row["topic_id"]. "Reply content:" .$row["reply_content"]. "<br><br></h4>";
							     	$reply_id = $row["reply_id"];
							     	
							     	$topic_id = $row["topic_id"];
							     
							     	if($user_id == $user_id_reply){
							        echo '<form method="post" >
							        		<button type="submit" id="edit-reply" style="float: right; margin-right:15px;margin-top:-35px;"class="btn btn-info" name="replyyy['.$reply_id.']" value="'.$reply_id.'">Edit</button>
							        		</form> 
							        		<button type="button" id="delete-reply" style="float: right; margin-right:100px; margin-top:-35px;"class="btn btn-danger" data-toggle="modal" data-target="#myModal_delete_reply">Delete</button>
							        	<br>				  
							        	<div class="modal fade" id="myModal_delete_reply" role="dialog">
				    <div class="modal-dialog">
				    
				      <!-- Modal content-->
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          <h4 class="modal-title">Confirmation</h4>
				        </div>
				        <div class="modal-body">
				          <p>Are you sure you want to delete this reply?</p>
				        </div>
				        <div class="modal-footer">
				        <form method="post">
				        <button type="submit" class="btn btn-warning" name="delete['.$counter.']" value="'.$reply_id.'">Submit</button>
				          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				          </form>
				        </div>
				      </div>
				      
				    </div>
				  </div>';
							        }
							        	$counter ++;
							        echo '<hr style="display:block;border-width:5px;width:100%;">';
							    }
							}
		?>
</div>
</body>
</html>