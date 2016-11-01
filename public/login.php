<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context = "admin"; 
$username = "";
if (isset($_POST['submit'])) {

	$required_fields = array("username", "password");
	validate_presences($required_fields);

 if(empty($errors)) {
 	//Atempt login
 	$username = $_POST["username"];
 	$password = $_POST["password"];
 	$found_admin = attempt_login($username, $password);

 	if ($found_admin) {
 		//Success
 		$_SESSION["admin_id"] = $found_admin["id"];
 		$_SESSION["username"] = $found_admin["username"];
 		redirect_to("admin.php");
 	} else {
 		//Failure
 		
 	}
 }
 $_SESSION["message"] = "Имя пользователя и/или пароль не найдены.";
}

include("../includes/layouts/header.php");?>
<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
		<div id="page">
	<?php   echo message (); 
			$errors = errors(); 
			echo form_errors($errors);	
			?> 
		  <h2>Вход</h2>

		  <form action="login.php" method="post">
		  	<p>Имя пользователя:
		  		<input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" />
		  	</p>
		  	<p>Пароль:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  		<input type="password" name="password" value="" />
		  	</p>
		   	<input type="submit" name="submit" value="Отправить" />
		  </form>
          <br>
            <a href="create_admin.php">Регистрация</a>
		  
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>