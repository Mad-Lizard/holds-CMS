<?php if(!isset($layout_context)){$layout_context = "public";}?>
<!DOCTYPE html>
<html lang="ru">
<meta charset="UTF-8">
	<head>
		<title>Holds <?php if($layout_context == "admin"){ echo "Админка";}?></title>
		<link href="css/public.css" media="all" rel="stylesheet" type="text/css" />
        
	</head>
	<body>
		<div id="header">
            <h1>Holds 
                <?php if($layout_context == "admin"){ 
                echo "Админка";
                echo "<a href=\"index.php\" class=\"button1\">Выход</a></h1>";
        } else {
                echo "<a href=\"login.php\" class=\"button1\">Вход на сайт</a>";
} ?>
          
           </h1>
            
		</div>
             