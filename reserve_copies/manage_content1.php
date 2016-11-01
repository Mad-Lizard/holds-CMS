<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php include("../includes/layouts/header.php");?>
		
<?php
 if (isset($_GET["subject"])) {
 	$selected_subject_id = $_GET["subject"];
 	$current_subject = find_subject_by_id($selected_subject_id);
 	$selected_page_id = null;
 	$current_page = 0;
 } elseif (isset($_GET["page"])) {
 	$selected_subject_id = null;
 	$current_subject = 0;
 	$selected_page_id = $_GET["page"];
 	$current_page = find_page_by_id($selected_page_id);
 } else {
 	$selected_subject_id = null;
 	$current_subject = 0;
 	$selected_page_id = null;
    $current_page = 0;
   }
?>
<div id="main">
	<div id="navigation">
		<?php echo navigation ($selected_subject_id, $selected_page_id); ?>
	</div>
		<div id="page">
				
			<?php if($current_subject) {
				
				echo "<h2>Редактирование раздела: "; 
				echo $current_subject["menu_name"] ;
				echo "</h2><br>"; ?>
				
			<?php 
			} elseif ($current_page) {
				echo "<h2>Редактирование страницы: ";
				echo $current_page["menu_name"];
				echo "</h2><br>";
		 		} else { 
		        echo "<h2>Управление контентом сайта</h2><br>"; ?>
			    Выберите пункт для редактирования.
			<?php } ?> 
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>