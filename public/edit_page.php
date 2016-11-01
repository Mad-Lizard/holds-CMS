<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php find_selected_subject_or_page(false);?>
<?php if (!$current_page) {
// нет ид, он неверен или мы не можем найти его в БД
	redirect_to("manage_content.php");
}
?>
<?php if (isset($_POST['submit'])) {
	
		//Perform update	
	$id        = (int) $current_page["id"]; 
	$menu_name = mysqli_prep($_POST["menu_name"]);
	$position  = (int) $_POST["position"];
	$visible   = (int) $_POST["visible"];
	$content   = mysqli_prep($_POST["content"]); 

	//validation
	$required_fields = array("menu_name", "position", "visible", "content");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("menu_name" => 50, "content" => 5400);
	validate_max_lengths($fields_with_max_lengths);

	//Process the form
	if (empty($errors)) {
	$query = "UPDATE pages SET ";
	$query .= "menu_name = \"{$menu_name}\", ";
	$query .= "position = {$position}, ";
	$query .= "visible = {$visible}, ";
	$query .= "content = \"{$content}\" ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1"; 
	$result = mysqli_query($mysqli, $query); 
var_dump($query);
	if ($result && mysqli_affected_rows($mysqli) == 1) {
		//Success
		$_SESSION["message"] = "Страница обновлена.";
		redirect_to("manage_content.php?page={$id}");
	} else {
		//Failure
		$_SESSION["message"] = "Не получилось обновить страницу.";
		redirect_to("manage_content.php");
	}
}
} else {
	//This is probably GET request
	
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
	<?php   if (!empty($message)) {
		echo "<div class=\"message\">" . htmlspecialchars($message) . "</div>";
		}
?>
	<?php echo form_errors($errors);  
	?>
		  <h2>Редактирование страницы: <?php echo htmlspecialchars($current_page["menu_name"]); ?></h2>
		  <form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
		  	<p>Название страницы:
		  		<input type="text" name="menu_name" value="<?php echo htmlspecialchars($current_page["menu_name"]); ?>" />
		  	</p>
		  	<p>Позиция: 
		  		<select name="position">
		  		<?php
		  		   //$page_subject_id = (int)find_subject_id_for_page($current_page["id"]);
		  		   $page_set = find_pages_for_subject($current_page["subject_id"], false);
		  		   $page_count = mysqli_num_rows($page_set);
		  		  	for($count=1; $count<=$page_count; $count++){
		  			  echo "<option value=\"{$count}\" ";
		  			  if($current_page["position"] == $count) {
		  			  echo "selected";	
		  			  } 
		  			  echo ">{$count}</option>";	
		  			}
		  		?>	
		  		</select>
		  		</p>
		  	<p>Отображать:
		  	<input type="radio" name="visible" value="0" <?php 
		  	if ($current_page["visible"] == 0) {echo "checked";} ?> /> Нет
		  	&nbsp;
		  	<input type="radio" name="visible" value="1" <?php 
		  	if ($current_page["visible"] == 1) {echo "checked";} ?> /> Да
		  	</p>
		  	<p>Содержание: <br />
		  	<textarea name="content" rows=20 cols=80><?php echo htmlspecialchars($current_page["content"]); ?></textarea>
		  	</p>
		  	<input type="submit" name="submit" value="Редактировать страницу" />
		  	</form>
			<form action="delete_page.php?page=<?php echo urlencode($current_page["id"]);?>" onclick="return confirm('Вы уверены?')">
			<button type="submit">Удалить страницу</button>
			</form>
		  <form action="manage_content.php">
		  	<button type="submit">Отмена</button>
		  </form>
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>