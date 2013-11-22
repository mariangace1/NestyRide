<?php
// Inialize session
session_start();

// Include database connection settings
include('config.inc');

// Retrieve username and password from database according to user's input
$login = mysql_query("SELECT * FROM usuario WHERE (usuario= '" .$_POST['username']. "') and (pw = '" . mysql_real_escape_string($_POST['password'])."')");

// Check username and password match
if (mysql_num_rows($login) == 1){
	// Set username session variable
	$_SESSION['username'] = $_POST['username'];
	// Jump to secured page
	header('Location: bienvenido.php');

}
else {
	// Jump to login page
	header('Location: login.php');
}

//if ($_POST['rememberme']) {
//	setcookie("user", $_POST['username'], time()+3600);
//	setcookie("password", $_POST['password'], time()+3600);
//}

?>

