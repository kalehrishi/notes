<?php
 $q=$_GET['q'];
 echo $q;
 //$my_data=mysql_real_escape_string($q);
 $mysqli=mysqli_connect('localhost','developer','test123','notes-master') or die("Database Error");
 $sql="SELECT * FROM UserTags WHERE tag LIKE '% { $q } %' ORDER BY tag";
 $result = mysqli_query($mysqli,$sql) or die(mysqli_error());

 if($result)
 {
  while($row=mysqli_fetch_array($result))
  {
  	$id = $row['id'];
  	$userId = $row['userId'];
  	$tag = $row['tag'];
  	$isDeleted = $row['isDeleted'];
  	//echo $row['tag']."\n";
  	$output=array(
		'id'=> $row['id'],
		'userId'=> $row['userId'],
		'tag'=> $row['tag'],
		'isDeleted'=> $row['isDeleted']
	);
    }
    print_r($output);
	$json= json_encode($output);
 	echo($json);

 }

?>