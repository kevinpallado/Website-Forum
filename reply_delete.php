<?php
include("config.php");
$topic_id= @$_GET["topic"];
	session_start();
	$user = $_SESSION['login_user'];
	$check = "SELECT * FROM myuser WHERE username='$user'";
	$result = mysqli_query($db,$check);
	$user_data = mysqli_fetch_assoc($result); // fetch all data
	$user_id = $user_data['user_id'];// fetch all data
										$reply_arr = $_POST['reply_delete'];
								foreach($reply_arr as $reply_id){
										$replay_id = $reply_id;}
									$user_id_reply_id = "SELECT * FROM myreply WHERE reply_id = '$reply_id'";
									$output = mysqli_query($db,$user_id_reply_id);
									$result = mysqli_fetch_assoc($output);
									$output_reply = $result['user_id'];
									if($user_id != $output_reply){	
										$delete_reply = "DELETE FROM myreply WHERE reply_id ='$reply_id'";
										$output_delete = mysqli_query($db,$delete_reply);
										if($output_delete){
											echo $topic_id;
											#header("location:discuss.php?topic=".$topic_id);
											die();
										}else{
											echo "<script>
											alert('Error:Delete problem detected');
											window.location.href='homepage.php';
										</script>";
										}
									}
?>