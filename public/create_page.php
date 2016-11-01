<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php find_selected_subject_or_page();
if (isset($_POST['submit'])) {
	$menu_name = mysqli_prep($_POST["menu_name"]);
	$subject_id = (int) $current_subject["id"];
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	$content = mysqli_prep($_POST["content"]);

	//validation
	$required_fields = array("menu_name", "position", "visible", "content");
	validate_presences($required_fields);

	$fields_with_max_lengths = array ("menu_name" => 50, "content" => 5400);
	validate_max_lengths($fields_with_max_lengths);

	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_page.php?subject=<?php echo $current_subject[id]?>");
	} 
	
	$query = "INSERT INTO pages (";
	$query .= " subject_id, menu_name, position, visible, content ";
	$query .= " ) VALUES (";
	$query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}' ";
	$query .= " )";
	
	$result = mysqli_query($mysqli, $query);  
	if ($result) {
		//Success
		$_SESSION["message"] = "Страница создана.";
		redirect_to("manage_content.php");
	} else {
		$_SESSION["message"] = "Не получилось создать страницу.";
		redirect_to("new_subject.php");
	}

} else {
	//This is probably GET request
	redirect_to("new_page.php?subject=<?php echo $current_subject[id]?>");
}

?>

<?php if (isset($mysqli)) { mysqli_close($mysqli); }  ?>