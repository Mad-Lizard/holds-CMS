<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php
if (isset($_POST['submit'])) {
	//Process the form

	$menu_name = mysqli_prep($_POST["menu_name"]);
	$position  = (int) $_POST["position"];
	$visible   = (int) $_POST["visible"];
    $content   = mysqli_prep($_POST["content"]);

	//validation
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);

	$fields_with_max_lengths = array ("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);

	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_subject.php");
	} 
	
	$query = "INSERT INTO subjects (";
	$query .= " menu_name, position, visible, content";
	$query .= " ) VALUES (";
	$query .= " '{$menu_name}', {$position}, {$visible}, '{$content}''";
	$query .= " )";
	
	$result = mysqli_query($mysqli, $query);  
	if ($result) {
		//Success
		$_SESSION["message"] = "Раздел меню создан.";
		redirect_to("manage_content.php");
	} else {
		$_SESSION["message"] = "Не получилось создать раздел меню.";
		redirect_to("new_subject.php");
	}

} else {
	//This is probably GET request
	redirect_to("new_subject.php");
}

?>

<?php if (isset($mysqli)) { mysqli_close($mysqli); }  ?>