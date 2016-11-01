<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $layout_context="public";?>
<?php include("../includes/layouts/header.php");?>
<?php find_selected_subject_or_page();?>
<div id="main">
	<div id="navigation">
		<?php echo navigation1($current_subject, $current_page, $layout_context); ?>
	</div>
	<div id="page">
        <?php if ($current_page) { ?>
			<h2><?php echo htmlspecialchars($current_page["menu_name"]);?></h2>
			<?php echo   nl2br(htmlspecialchars($current_page["content"])); 
					} elseif($current_subject) {  ?>
			    <h2><?php echo htmlspecialchars($current_subject["menu_name"]);?></h2>
			<?php echo nl2br(htmlspecialchars($current_subject["content"])); 
			   } else {
                    echo '<h2>Добро пожаловать!</h2>'; 
            }?> 
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>