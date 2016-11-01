<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php 
$id = $_GET["id"];
$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
$result = mysqli_query($mysqli, $query);

if ($result && mysqli_affected_rows($mysqli) == 1) {
//Success
	$_SESSION["message"] = "Администратор удалён.";
	redirect_to("manage_admins.php");	
} else {
	//Failure
	$_SESSION["message"] = "Не получилось удалить администратора.";
	redirect_to("manage_admins.php");
}
?>
<?php include ("../includes/layouts/header.php"); 
?>
