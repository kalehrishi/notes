<?php
$connect = mysqli_connect('localhost','developer','test123','notes-master') or die("Database Error");

if($_POST['id'])
{
$id=mysqli_real_escape_string($_POST['id']);
$sql = "DELETE FROM Notes WHERE id='$id'";
$result = mysqli_query($connect,$sql) or die(mysqli_error());

if($result)
{
	$app = \Slim\Slim::getInstance();
    $app->redirect("/notes");
}
}
?>