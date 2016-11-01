<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php
if (isset($_POST['submit'])) {
	//Process the form

	$username        = mysqli_prep($_POST["username"]);
	$password        = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];
    
	//validation
	$required_fields = array("username", "password", "repeat_password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array ("username" => 50);
	validate_max_lengths($fields_with_max_lengths);
    
    validate_unique_admin_name($username);
    
    validate_password($password, $repeat_password);

   
	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_admin.php");
	} 
    
    $hashed_password = password_encrypt($password);
	$repeat_hashed_password = password_encrypt($repeat_password);
	
	$query = "INSERT INTO admins (";
	$query .= " username, hashed_password";
	$query .= " ) VALUES (";
	$query .= " '{$username}', '{$hashed_password}'";
	$query .= " )";
	
	$result = mysqli_query($mysqli, $query);  
   
	if ($result) {
		//Success
		$_SESSION["message"] = "Новый администратор добавлен.";
		redirect_to("manage_admins.php");
	} else {
		$_SESSION["message"] = "Не получилось добавить нового администратора.";
		redirect_to("new_admin.php");
	}

} else {
	//This is probably GET request
	redirect_to("new_admin.php");
}

?>

<?php if (isset($mysqli)) { mysqli_close($mysqli); }  ?>