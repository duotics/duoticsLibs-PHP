<?php defined('_JEXEC') or die('Restricted access');//comprueba si la constante esta definida
# Type="MYSQL"
# HTTP="true"
$hostname_conn = "localhost";
//$database_conn = "cbenav_ndb";
//$username_conn = "cbenav_unw01";
//$password_conn = "A0wL5Mb^[wEsMKF4Tk";
$database_conn = "cbenav_joomla";
$username_conn = "cbenav_usrj";
$password_conn = "=L_.AuTz$&%wUdDy9z";
//
if(!$conn){
	$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_select_db($database_conn);
	mysql_query("SET NAMES 'utf8'");
}
?>