<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $current_subject = find_subject_by_id($_GET["subject"], false); ?>
<?php if (!$current_subject) {
redirect_to("manage_content.php");
}
$pages_set = find_pages_for_subject($current_subject["id"]);
if (mysqli_num_rows($pages_set) > 0) {
	$_SESSION["message"] = "Невозможно удалить раздел меню со страницами.";
	redirect_to("manage_content.php?subject={$current_subject["id"]}");
}
$id = $current_subject["id"];
$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
$result = mysqli_query($mysqli, $query);

if ($result && mysqli_affected_rows($mysqli) == 1) {
//Success
	$_SESSION["message"] = "Раздел меню удалён.";
	redirect_to("manage_content.php");	
} else {
	//Failure
	$_SESSION["message"] = "Не получилось удалить раздел меню.";
	redirect_to("manage_content.php?subject={$id}");
}
?>
<?php include ("../includes/layouts/header.php"); 
?>
