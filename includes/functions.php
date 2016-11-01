<?php
function redirect_to($new_location) {
	header("Location: ". $new_location);
	exit;
}

function mysqli_prep($string) {
	global $mysqli;
	$escaped_string = mysqli_real_escape_string($mysqli, $string);
	return $escaped_string;
}

function confirm_query($result_set) {
	if (!$result_set) {
		printf("Ooops... Не получилось сформировать запрос к базе данных.");
	exit();
	}
}

function find_all_admins(){
	global $mysqli;

	$query = "SELECT * ";
	$query .= "FROM admins ";
	$admin_set = mysqli_query($mysqli, $query);
	confirm_query($admin_set);
	return $admin_set;
}
			//Database query
function find_all_subjects($public=true) {
		global $mysqli;
		
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		if($public){
		$query .= "WHERE visible = 1 ";
	}
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($mysqli, $query);
		confirm_query($subject_set);
		return $subject_set;
	}

function find_all_visible_subjects() {
		global $mysqli;
		
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($mysqli, $query);
		confirm_query($subject_set);
		return $subject_set;
	}	

function find_all_subjects_name() {
		global $mysqli;
		
		$query  = "SELECT menu_name ";
		$query .= "FROM subjects ";
		// $query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($mysqli, $query);
		confirm_query($subject_set);
		return $subject_set;
	}
	
function find_all_positions_for_subjects() {
		global $mysqli;
		
		$query  = "SELECT position ";
		$query .= "FROM subjects ";
		// $query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$position_set = mysqli_query($mysqli, $query);
		confirm_query($subject_set);
		return $position_set;
	} 


function find_pages_for_subject($subject_id, $public=true) {
		global $mysqli;	
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE subject_id = {$subject_id} ";
		if ($public) {
		$query .= "AND visible = 1 ";
	}
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($mysqli, $query);
		confirm_query($page_set);
		return $page_set;
	}

function find_visible_pages_for_subject($subject_id) {
		global $mysqli;	
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE visible = 1 ";
		$query .= "AND subject_id = {$subject_id} ";
		$query .= "ORDER BY position";
		$page_set = mysqli_query($mysqli, $query);
		confirm_query($page_set);
		return $page_set;
	}
	
function find_subject_by_id($subject_id, $public = true) {
		global $mysqli;
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = \"$subject_id\" ";
		if ($public) {
		$query .= "AND visible = 1 ";
	}
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($mysqli, $query);
		confirm_query($subject_set);
		if($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

function find_page_by_id($page_id, $public=true) {
		global $mysqli;
		
		$safe_page_id = mysqli_real_escape_string($mysqli, $page_id);
		
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = \"$safe_page_id\" ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$page_set = mysqli_query($mysqli, $query);
		confirm_query($page_set);
		if($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}

function find_admin_by_id() {
		global $mysqli;
		$admin_id = $_GET["id"];
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($mysqli, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

function check_password() {
	global $mysqli;
	
	$id = $_GET["id"];
	$query = "SELECT hashed_password ";
	$query .= "FROM admins ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1";
	$password = mysqli_query($mysqli, $query);
	confirm_query($password);
	$password = mysqli_fetch_assoc($password);
		return $password;
	
}

function find_default_page_for_subject($subject_id){
	$page_set = find_pages_for_subject($subject_id);
	if($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return null;
		}
}

function find_selected_subject_or_page($public=false) {
global $current_subject;
global $current_page;	
 if (isset($_GET["subject"])) {
 	$current_subject = find_subject_by_id($_GET["subject"], $public);
 	if ($current_subject && $public) {
 		$current_page = find_default_page_for_subject($current_subject["id"]);
 	} else {
 	$current_page = null;	
 	}
 } elseif (isset($_GET["page"])) {
 	$current_subject = null;
 	$current_page = find_page_by_id($_GET["page"], $public);
 } else {
 	$current_subject = null;
 	$current_page = null;
   }
 }

 function find_subject_id_for_page($page_id) {
 	global $mysqli;
 	$query = "SELECT subject_id ";
 	$query .= "FROM pages ";
 	$query .= "WHERE id = \"$page_id\" ";
 	$query .= "LIMIT 1";
 	$subject_id_for_page = mysqli_query($mysqli, $query);
	confirm_query($subject_id_for_page);
	$subject_id = mysqli_fetch_assoc($subject_id_for_page);
			return $subject_id_for_page;
	 }

function form_errors ($errors = array()) {
		$output = "";
	if (!empty($errors)) {
		$output .= "<div class =\"error\">";
		$output .= "Пожалуйста, исправьте следующие ошибки:";
		$output .= "<ul>";
		foreach ($errors as $key => $error) {
		$output .= "<li>{$error}</li>";
		}
		$output .= "</ul>";
		$output .= "</div>";

		return $output;
	 }
}

function password_encrypt($password) {
	
		  $hash_format = "$2y$10$";
		  $salt_length = 22;
		  $salt = generate_salt($salt_length);
		  $format_and_salt = $hash_format . $salt;
		  $hash = crypt($password, $format_and_salt);
		 return $hash;
		 		
}

function generate_salt($length) {
	$unique_random_string = md5(uniqid(mt_rand(), true));
	$base64_string = base64_encode($unique_random_string);
	$modified_base64_string = str_replace('+', '.', $base64_string);
	$salt = substr($modified_base64_string, 0, $length);
	return $salt;
}

function password_check($password, $existing_hash) {
	$hash = crypt($password, $existing_hash);
	if ($hash === $existing_hash){
		return true;
	} else {
		return false;
	}
}

function find_admin_by_username($username) {
	global $mysqli;
	$safe_username = mysqli_real_escape_string($mysqli, $username);
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($mysqli, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
}

function attempt_login($username, $password) {
	$admin = find_admin_by_username($username);
	if ($admin) {
//found admin, now checked password
		if(password_check($password, $admin["hashed_password"])) {
			// matches
			return $admin;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function logged_in() {
	return isset($_SESSION['admin_id']);
}

function confirm_logged_in(){
	 if(!logged_in()) {
	redirect_to("login.php");
	}
}

function navigation1 ($subject_array, $page_array, $layout_context) {
	if ($layout_context =="admin"){
		$public = false;
	} elseif ($layout_context =="public") {
		$public = true;
	} else {
		$public = true;
	}
	$output = "<ul class=\"subjects\">";
	$subject_set = find_all_subjects($public);	
	while($subject = mysqli_fetch_assoc($subject_set)) {
//выделение выбранных пунктов меню
		$output .= "<li";
		if ($subject_array && $subject["id"] == $subject_array["id"]) {
		$output .= " class = \"selected\"";
		} 
		$output .= ">";
//вывод пунктов меню	
		if ($layout_context == "public") {
		$output .="<a href = \"index.php?subject=";
	} else {
		$output .="<a href = \"manage_content.php?subject=";
	}
		$output .= urlencode($subject["id"]);
		$output .= "\">";
		$output .= htmlspecialchars($subject["menu_name"]);
		$output .= "</a>";
		
		/*if($subject_array["id"] == $subject["id"] || $page_array["subject_id"] == $subject["id"] || $layout_context == "admin") {*/
		$page_set = find_pages_for_subject($subject["id"], $public);
		$output .= "<ul class=\"pages\">";
	while ($page = mysqli_fetch_assoc($page_set)) {
//выделение выбранных страниц	
		$output .= "<li";
		if ($page_array && $page["id"] == $page_array["id"]) {
		$output .= " class = \"selected\"";
		} 
		$output .= ">";
//вывод перечня страниц
		if ($layout_context == "public") {
		$output .="<a href = \"index.php?page=";
 		} else {
		$output .="<a href = \"manage_content.php?page=";
		} 
		$output .= urlencode($page["id"]); 
		$output .= "\">";
		$output .= htmlspecialchars($page["menu_name"]);
		$output .= "</a></li>";
	}			
		$output .= "</ul>";
		mysqli_free_result($page_set);	
	// }		
	 	$output .= "</li>"; //end of the subject
	}
		mysqli_free_result($subject_set); 
		$output .= "</ul>";
 
		return $output;
}
/*
function navigation ($subject_id, $page_id) {
	$output = "<ul class=\"subjects\">";
	$subject_set = find_all_subjects(false);	
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
		$output .= htmlspecialchars($subject["menu_name"]);
		$output .= "</a></li>";
		$page_set = find_pages_for_subject($subject["id"], false); 
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
		$output .= htmlspecialchars($page["menu_name"]);
		$output .= "</a></li>";
	}			
		$output .= "</ul>";
		mysqli_free_result($page_set);		
	}
		mysqli_free_result($subject_set); 
		$output .= "</ul>";
		return $output;
}

function public_navigation ($subject_array, $page_array) {
	$output = "<ul class=\"subjects\">";
	$subject_set = find_all_visible_subjects();	
	while($subject = mysqli_fetch_assoc($subject_set)) {
//выделение выбранных пунктов меню
		$output .= "<li";
		if ($subject_array && $subject["id"] == $subject_array["id"]) {
		$output .= " class = \"selected\"";
		} 
		$output .= ">";
//вывод пунктов меню	
		$output .="<a href = \"index.php?subject=";
		$output .= urlencode($subject["id"]);
		$output .= "\">";
		$output .= htmlspecialchars($subject["menu_name"]);
		$output .= "</a>";
		
		if($subject_array["id"] == $subject["id"] || $page_array["subject_id"] == $subject["id"]) {
		$page_set = find_visible_pages_for_subject($subject["id"]);
		$output .= "<ul class=\"pages\">";
	while ($page = mysqli_fetch_assoc($page_set)) {
//выделение выбранных страниц	
		$output .= "<li";
		if ($page_array && $page["id"] == $page_array["id"]) {
		$output .= " class = \"selected\"";
		} 
		$output .= ">";
//вывод перечня страниц 
		$output .= "<a href = \"index.php?page=";
		$output .= urlencode($page["id"]); 
		$output .= "\">";
		$output .= htmlspecialchars($page["menu_name"]);
		$output .= "</a></li>";
	}			
		$output .= "</ul>";
		mysqli_free_result($page_set);	
	 }		
	 	$output .= "</li>"; //end of the subject
	}
		mysqli_free_result($subject_set); 
		$output .= "</ul>";
		return $output;
}*/
?>