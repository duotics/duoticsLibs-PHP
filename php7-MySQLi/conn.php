<?php defined('_JEXEC') or die('Restricted access');//comprueba si la constante esta definida
$hostname_conn = "localhost";
$database_conn = "database";
$username_conn = "user";
$password_conn = "pass";
if(!$conn){
	$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_select_db($database_conn);
	mysql_query("SET NAMES 'utf8'");
}
?>