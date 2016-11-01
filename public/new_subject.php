<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php");?>
		
<?php find_selected_subject_or_page();?>

<div id="main">
	<div id="navigation">
		<?php echo navigation1 ($current_subject, $current_page, $layout_context); ?>
		<br />
		<a href="new_subject.php">+ Добавить раздел меню</a>
	</div>
		<div id="page">
	<?php   echo message (); 
			$errors = errors(); 
			echo form_errors($errors);	
			?> 
		  <h2>Создание раздела меню</h2>

		  <form action="create_subject.php" method="post">
		  	<p>Название раздела:
		  		<input type="text" name="menu_name" value="" />
		  	</p>
		  	<p>Позиция:
		  		<select name="position">
		  		<?php
		  		   $subject_set = find_all_subjects(false);
		  		   $subject_count= mysqli_num_rows($subject_set);
		  			for($count=1; $count<=$subject_count+1; $count++):
                    if($count!=$subject_count+1){
		  			  echo "<option value=\"{$count}\">{$count}</option>";
                    } else {
                         echo "<option value=\"{$count}\" selected>{$count}</option>";
                    }
		  			endfor;       
		  		?> 
		  		</select>
		  	</p> 
		  	<p>Отображать:
		  	<input type="radio" name="visible" value="0" /> Нет
		  	&nbsp;
		  	<input type="radio" name="visible" value="1" /> Да
		  	</p>
              <p>Содержание: <br />
		  	<textarea name="content" rows=20 cols=80 value=""></textarea>
		  	</p>
		  	<input type="submit" name="submit" value="Создать раздел" />
		  </form>
		  <form action="manage_content.php">
		  	<button type="submit">Отмена</button>
		  </form>
		</div>
</div>

<?php include("../includes/layouts/footer.php");?>