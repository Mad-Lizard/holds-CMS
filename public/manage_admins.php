<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php");?>
		<div id="main">
			<div id="navigation">
				&nbsp;
				<br /><a href="admin.php">&laquo; Главное меню</a><br />
			</div>
			<div id="page">
				<?php echo message(); ?>
				<h2>Управление доступом к сайту</h2>
				<table>
					<tr>
						<th>Имя пользователя</th>
						<th>Действия</th>
					</tr>
					<?php $admin_set = find_all_admins();
					while ($admin = mysqli_fetch_assoc($admin_set)) {
					
						echo "<tr><td>{$admin["username"]}</td>";
						echo "<tr><td>{$admin["hashed_password"]}</td>"; ?>
						<td>
						<a href="edit_admin.php?id=<?php echo $admin["id"]?>">Редактировать</a><br />
						<a href="delete_admin.php?id=<?php echo $admin["id"]?>" onclick="return confirm('Вы уверены?')">Удалить</a>
					</td></tr>	
					<?php }?>
				</table><br>
				<form action="new_admin.php">
		  	<button type="submit">Добавить администратора</button>
		  </form>
		</div>
	</div>

<?php include("../includes/layouts/footer.php");?>