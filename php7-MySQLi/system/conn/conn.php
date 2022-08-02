<?php
if(!$conn_new){
	$host_conn_new = "localhost";
	$db_conn_new = "cbenav_ndb";
	$user_conn_new = "cbenav_unw01";
	$pass_conn_new = "A0wL5Mb^[wEsMKF4Tk";
	$conn = mysql_connect($host_conn_new, $user_conn_new, $pass_conn_new) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_select_db($db_conn_new, $conn_new);
	mysql_query("SET NAMES 'utf8'");
}
?>