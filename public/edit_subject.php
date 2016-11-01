<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php find_selected_subject_or_page();?>
<?php if (!$current_subject) {
// нет ид, он неверен или мы не можем найти его в БД
	redirect_to("manage_content.php");
}
?>
<?php if (isset($_POST['submit'])) {
	
	//validation
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);

	//Process the form
	if (empty($errors)) {
	//Perform update	
	$id        = $current_subject["id"];
	$menu_name = mysqli_prep($_POST["menu_name"]);
	$position  = (int) $_POST["position"];
	$visible   = (int) $_POST["visible"];
    $content   = mysqli_prep($_POST["content"]); 

	$query = "UPDATE subjects SET ";
	$query .= "menu_name = \"{$menu_name}\", ";
	$query .= "position = {$position}, ";
	$query .= "visible = {$visible}, ";
    $query .= "content = \"{$content}\" ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1";
  
	$result = mysqli_query($mysqli, $query);
 

	if ($result && mysqli_affected_rows($mysqli) >= 0) {
		//Success
		$_SESSION["message"] = "Раздел меню обновлен.";
		redirect_to("manage_content.php");
	} else {
		//Failure
		$_SESSION["message"] = "Не получилось обновить раздел меню.";
		redirect_to("manage_content.php");
	}
}
} else {
	//This is probably GET request
	echo $errors;
} //end: if (isset($_POST['submit']))

?>
<?php confirm_logged_in();?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
	<div id="navigation">
		<?php echo navigation1 ($current_subject, $current_page, $layout_context); ?>
		<br />
		<a href="new_subject.php">+ Добавить раздел меню</a>
	</div>
	<div id="page">
	<?php	
		if (!empty($message)) {
		echo "<div class=\"message\">" . htmlspecialchars($message) . "</div>";
	}
?>
	<?php echo form_errors($errors); ?> 

		  <h2>Изменение раздела меню: <?php echo htmlspecialchars($current_subject["menu_name"]); ?></h2>

		  <form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
		  	<p>Название раздела (Menu name):
		  		<input type="text" name="menu_name" value="<?php echo htmlspecialchars($current_subject["menu_name"]); ?>" />
		  	</p>
		  	<p>Позиция (Position):
		  		<select name="position">
		  		<?php
		  		   $subject_set = find_all_subjects(false);
		  		   $subject_count = mysqli_num_rows($subject_set);
		  			for($count = 1; $count <= $subject_count; $count++){
		  			  echo "<option value=\"{$count}\" ";
		  			  if ($current_subject["position"] == $count) {
		  			  	echo "selected";
		  			  }
		  			   echo ">{$count}</option>";	
		   			}
		  		?>	 
		  		</select>
		  	</p>
		  	<p>Отображать (Visible):
		  	<input type="radio" name="visible" value="0" <?php 
		  	if ($current_subject["visible"] == 0) {echo "checked";} ?>/> Нет
		  	&nbsp;
		  	<input type="radio" name="visible" value="1" <?php 
		  	if ($current_subject["visible"] == 1) {echo "checked";} ?>/> Да
		  	</p>
              <p>Содержание: <br />
		  	<textarea name="content" rows=20 cols=80><?php echo htmlspecialchars($current_subject["content"]); ?></textarea>
		  	</p>
		  	<input type="submit" name="submit" value="Изменить раздел" />
		  </form>  
		  <a href="new_page.php?subject=<?php echo $current_subject["id"]; ?>">Добавить страницу</a>
<br><br>
		  <a href="delete_subject.php?subject=<?php echo $current_subject["id"]?>" onclick="return confirm('Вы уверены?')">Удалить раздел меню</a>
<br><br>		 
		  <a href="manage_content.php">Отмена</a>
	
		 
	</div>
</div>

<?php include("../includes/layouts/footer.php");?>