<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php");?>
		
<?php find_selected_subject_or_page();?>
<div id="main">
	<div id="navigation">
		<br />
		<a href="admin.php">&laquo; Главное меню</a><br />
		<?php echo navigation1 ($current_subject, $current_page, $layout_context); ?>
		<br />
		<a href="new_subject.php">+ Добавить раздел меню</a>
		</div>
		<div id="page">
			<?php echo message (); ?>	
			<?php if($current_subject) {
				
				echo "<h2>Редактирование раздела меню</h2><br />"; 
				echo "Название:";
				echo htmlspecialchars($current_subject["menu_name"]) . "<br />";
				echo  "Позиция:" . $current_subject["position"] . "<br />";
				echo  "Отображение:";
				echo $current_subject["visible"] == 1 ? 'да' : 'нет';
				echo "<br /><br />"; ?>
			<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Изменить раздел меню</a>	
				<br />
				<br />
				<hr color="#8D0D19" size="1">
				<h3>Страницы раздела меню:</h3>
			<?php
			$page_set = find_pages_for_subject($current_subject["id"], $public = false);
			echo "<ul class=\"pages\">";
			if(isset($page_set)) {
			while ($page = mysqli_fetch_assoc($page_set)){
				echo "<li><a href=\"manage_content.php?page=";
				echo urlencode($page["id"]);
				echo "\">";
				echo htmlspecialchars($page["menu_name"]);
				echo "</a>";
				echo "</li>";
				}
				echo "</ul>";
			}		
			?>
			<br />
		<a href="new_page.php?subject=<?php echo $current_subject["id"]; ?>">+ Добавить страницу в этот раздел меню</a>	
			<?php 
			} elseif ($current_page) {
				echo "<h2>Редактирование страницы: ";
				echo htmlspecialchars($current_page["menu_name"]);
				echo "</h2><br>";
				echo  "Позиция:" . $current_page["position"] . "<br />";
				echo  "Отображение:";
				echo $current_page["visible"] == 1 ? 'да' : 'нет';
				echo "<br />";
				echo "Содержание: <br />"; ?>
			<div class="view-content">
			<?php echo htmlspecialchars($current_page["content"]); ?>	
			</div>
			<a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Изменить страницу</a>
			<br />
			<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]);?>"  onclick="return confirm('Вы уверены?')">Удалить страницу</a>	
	<?php	 		} else { 
		        echo "<h2>Управление контентом сайта</h2><br>"; ?>
			    Выберите пункт для редактирования.
			<?php }
			 ?> 
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>