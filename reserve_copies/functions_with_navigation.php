<?php

	function confirm_query($result_set) {
	if (!$result_set) {
		printf("Не получилось сформировать запрос к базе данных.");
	exit();
	}
}
?>


<?php
			//Database query
function find_all_subjects () {
		global $mysqli;
			$query = "SELECT * ";
			$query .= "FROM subjects ";
			$query .= "WHERE visible = 1 ";
			$query = mysqli_real_escape_string($mysqli, $query);
			$subject_set = mysqli_query($mysqli, $query);
			confirm_query($subject_set);
		return $subject_set;
		}
		?>

<?php
			//Database query
function find_pages_for_subject ($subject_id) {
		global $mysqli;
			$query = "SELECT * ";
			$query .= "FROM pages ";
			$query .= "WHERE visible = 1 ";
			$query .= "AND subject_id = {$subject_id};";
			$query = mysqli_real_escape_string($mysqli, $query);
			$page_set = mysqli_query($mysqli, $query);
			confirm_query($page_set);
		return $page_set;
		}
		?>

<?php
function find_subject_by_id($subject_id) {
	global $mysqli;
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$subject_id} ";
		$query .= "LIMIT 1";
		$query = mysqli_real_escape_string($mysqli, $query);
		$subject_set = mysqli_query($mysqli, $query);
		confirm_query($subject_set);
		if ($subject = mysqli_fetch_assoc($subject_set)) {;
	return $subject;
        } else {
    return null;
        }
} ?>

<?php
function navigation ($subject_id, $page_id) {
	$output = "<ul class=\"subjects\">";
	$subject_set = find_all_subjects();	
	while($subject = mysqli_fetch_assoc($subject_set)) {
//выделение выбранных пунктов меню
		$output .= "<li";
		if ($subject["id"] == $subject_id) {
		$output .= " class = \"selected\"";
		} 
		$output .= ">";
//вывод пунктов меню	
		$output .="<a href = \"manage_content.php?subject=";
		$output .= urlencode($subject["id"]);
		$output .= "\">";
		$output .= $subject["menu_name"];
		$output .= "</a></li>";
		$page_set = find_pages_for_subject($subject["id"]); 
		$output .= "<ul class=\"pages\">";
	while ($page = mysqli_fetch_assoc($page_set)) {
//выделение выбранных страниц	
		$output .= "<li";
		if ($page["id"] == $page_id) {
		$output .= " class = \"selected\"";
		} 
		$output .= ">";
//вывод перечня страниц 
		$output .= "<a href = \"manage_content.php?page=";
		$output .= urlencode($page["id"]); 
		$output .= "\">";
		$output .= $page["menu_name"];
		$output .= "</a></li>";
	}			
		$output .= "</ul>";
		mysqli_free_result($page_set);		
	}
		mysqli_free_result($subject_set); 
		$output .= "</ul>";
		return $output;
}
?>
