
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
<body>
<?php
include("config.php");
$sortby = intval($_GET['asc']);

$conn = new mysqli('localhost','root','','userdb');
    if($sortby=='1'){
        $all = "SELECT * FROM mytopic ORDER BY topicname DESC";
    }
    else{
        $all = "SELECT * FROM mytopic ORDER BY reg_date DESC";}
    $result = mysqli_query($db,$all);
    if($result->num_rows>0){
         while($row = $result->fetch_assoc()) {
          echo "<strong class=text-uppercase><br>Content : " . $row["topicname"]."<br><br>Author: " . $row["author"]. "<br><br>Posted in : " .$row["reg_date"]. "</strong><br><br>Posted by : ";
                                    $user_id = $row["user_id"];
                                    $topic_id = $row["topic_id"];
                                    $user_id_topic = mysqli_fetch_assoc(mysqli_query($db,"SELECT username FROM myuser WHERE user_id = '$user_id'"));
                                    foreach($user_id_topic as $id_topic){
                                    echo "<em><mark>" .$id_topic."</mark></em>";
                                }
    echo '<form method="post" ><button type="submit" style="float: right;margin-right:100px; margin-top:-25px;"class="btn btn-info fa fa-folder-open" name="confirm['.$topic_id.']" value="'.$topic_id.'">  View</button>
          </form> <br> <hr style="display:block;border-width:5px;width:91%;">';
    }
}
?>
</body>
</html>