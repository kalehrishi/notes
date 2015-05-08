<?php
 $mysqli=mysqli_connect('localhost','developer','test123','notes-master') or die("Database Error");
 $sql="SELECT * FROM UserTags";
 $result = mysqli_query($mysqli,$sql) or die(mysqli_error());

 if(!empty($result))
 {
  $userTags = array();
  $i=0;
  while($row=mysqli_fetch_array($result))
  {   
    $output  = array(
    	'id' => $row['id'],
    	'userId' => $row['userId'],
    	'tag'=> $row['tag'],
    	'isDeleted'=>$row['isDeleted']
    	);
    /*$json =  json_encode($output);
  	echo $json;*/
    array_push($userTags, $output);
  }
  $json =  json_encode($userTags);
  echo $json;
 }
?>