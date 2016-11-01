<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php $current_id = $_GET["id"]; 
$admin = find_admin_by_id();
if (!$admin) {
// нет ид, он неверен или мы не можем найти его в БД
	redirect_to("manage_admins.php");
}
	if (isset($_POST['submit'])) {
		//validation
	$required_fields = array("username", "password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array ("username" => 50);
	validate_max_lengths($fields_with_max_lengths);

	//Process the form
	if (empty($errors)) {
	//Perform update	
	$id = $admin["id"];
	$username = mysqli_prep($_POST["username"]);
	$hashed_password = password_encrypt($_POST["password"]);

	//$password = check_password();

	//if ($password == $hashed_password) {

	$query = "UPDATE admins SET ";
	$query .= "username = '{$username}', ";
	$query .= "hashed_password = '{$hashed_password}' ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1";
	$result = mysqli_query($mysqli, $query);
 

	if ($result && mysqli_affected_rows($mysqli) >= 0) {
		//Success
		$_SESSION["message"] = "Данные администратора успешно обновлены.";
		redirect_to("manage_admins.php");
	} else {
		//Failure
		$_SESSION["message"] = "Не получилось обновить данные администратора.";
		redirect_to("manage_admins.php");
	}
}
} else {
	//This is probably GET request
	//echo $errors;
} //end: if (isset($_POST['submit']))
onfirm_logged_in();
$layout_context = "admin";
include("../includes/layouts/header.php"); ?>
<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
	<div id="page">
	<?php	
		if (!empty($message)) {
		echo "<div class=\"message\">" . htmlspecialchars($message) . "</div>";
	}
?>
	<?php  echo form_errors($errors);?> 

		  <h2>Изменение данных администратора: <?php echo htmlspecialchars($admin["username"]); ?></h2>

		  <form action="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>" method="post">
		  	<p>Имя пользователя:
		  		<input type="text" name="username" value="<?php echo htmlspecialchars($admin["username"]); ?>" />
		  	</p>
		  	<p>Пароль:
		  		<input type="password" name="password" value="" />
		  	</p>
		  	<p>
		  	<input type="submit" name="submit" value="Применить" />
		  </p>
		  </form>  
		  <form action="manage_admins.php">
		  	<button type="submit">Отмена</button>
		  </form>
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>