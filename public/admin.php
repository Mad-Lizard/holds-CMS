<?php require_once("../includes/session.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php");?>
		
		<div id="main">
			<div id="navigation">
				&nbsp;
			</div>
			<div id="page">
				<h2>Панель админа</h2>
				<p>Добро пожаловать в административную часть, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</p>
				<ul>
					<li><a href="manage_content.php">Управление контентом сайта</a></li>
					<li><a href="manage_admins.php">Управление правами пользователей</a></li>
					<li><a href="logout.php">Выход</a></li>
				</ul>
			</div>
		</div>

<?php include("../includes/layouts/footer.php");?>