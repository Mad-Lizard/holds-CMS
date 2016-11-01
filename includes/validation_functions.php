<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $errors = array();

function fieldname_as_text($fieldname) {
	$fieldname = str_replace("_", " ", $fieldname);
	$fieldname = ucfirst($fieldname);
	return $fieldname;
}



function has_presence($value) {
	return isset($value) && $value !== "";
}

function validate_presences($required_fields) {
	global $errors;
	foreach ($required_fields as $field) {
		$value = trim($_POST[$field]);
		if (!has_presence($value)) {
			$errors[$field] = "Поле " . fieldname_as_text($field) . " не может быть пустым";
		}
	  }
	return $errors[$field];	
}


function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	foreach ($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
   		if(!has_max_length($value, $max)) {
			$errors[$field] = "Слишком длинное название раздела";
		}
	}
	return $errors[$field];
}

function has_inclusion_in($value, $set) {
	return in_array($value, $set);
}

function validate_unique_admin_name($username){
    global $errors;
    $admin = find_admin_by_username($username);
    if($admin!=null){
        $errors[$field] = "Администратор с таким именем уже существует.";
    }
    return $errors[$field];
}

function validate_password($password, $repeat_password){
     global $errors;
   
	if ($password !== $repeat_password){
        $errors[$field] = "Пароль не совпадает.";
    }
    return $errors[$field];
}

?>