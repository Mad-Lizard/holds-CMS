<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php //confirm_logged_in();?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php");?>
		
<?php //find_selected_subject_or_page();?>

<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
		<div id="page">
	<?php   echo message (); 
			$errors = errors(); 
			echo form_errors($errors);	
			?> 
		  <h2>Добавление администратора</h2>

		  <form action="create_admin.php" method="post">
		  	<p>Имя пользователя:
		  		<input type="text" name="username" value="" />
		  	</p>
		  	<p>Пароль:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  		<input type="password" name="password" value="" />
            <p>Пароль ёще раз:&nbsp;&nbsp;&nbsp;
		  		<input type="password" name="repeat_password" value="" />
                
		  	</p>
		   	<input type="submit" name="submit" value="Добавить администратора" />
		  </form>
		  <form action="admin.php">
		  	<button type="submit">Отмена</button>
		  </form>
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>