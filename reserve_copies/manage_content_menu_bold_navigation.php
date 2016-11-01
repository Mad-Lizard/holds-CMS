<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php include("../includes/layouts/header.php");?>
		
<?php
 if (isset($_GET["subject"])) {
 	$selected_subject_id = $_GET["subject"];
 	$selected_page_id = null;
 } elseif (isset($_GET["page"])) {
 	$selected_subject_id = null;
 	$selected_page_id = $_GET["page"];
 } else {
 	$selected_subject_id = null;
 	$selected_page_id = null;
 }
?>
<div id="main">
	<div id="navigation">
		<?php echo navigation ($selected_subject_id, $selected_page_id); ?>
	</div>
		<div id="page">
				<h2>Управление контентом сайта</h2>
			<?php if($selected_subject_id) {
				$current_subject = find_subject_by_id($selected_subject_id);
				echo $current_subject["menu_name"]; ?> <br>
			<?php 
			} elseif (isset($selected_page_id)) {
				echo $selected_page_id;
			} else { ?>
			Пожалуйста, выберите пункт меню.
			<?php } ?> 
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>