<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php find_selected_subject_or_page(false);
$id = $current_page["id"];
$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
$result = mysqli_query($mysqli, $query);

if ($result && mysqli_affected_rows($mysqli) == 1) {
//Success
	$_SESSION["message"] = "Страница удалена.";
	redirect_to("manage_content.php");	
} else {
	//Failure
	$_SESSION["message"] = "Не получилось удалить страницу.";
	redirect_to("manage_content.php");
}
?>
<?php include ("../includes/layouts/header.php"); 
?>
