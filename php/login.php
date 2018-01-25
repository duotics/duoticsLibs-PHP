<?php
//LOGIN TO SYSTEM
/*
v.0.1 initial code
v.0.2 add field user_theme

NOTES. review redirect prev URL
*/

function login($username, $password, $accesscheck){//v.0.2
	if (isset($accesscheck)) $_SESSION['PrevUrl'] = $accesscheck;
	
	if (isset($username)) {
	  session_start();
	  $loginUsername=$username;
	  $password=md5($password);
	  $MM_fldUserAuthorization = "user_level";
	  //if (isset($_SESSION['PrevUrl']) && true) $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
	  $MM_redirectLoginSuccess = $GLOBALS['RAIZc']."com_index/";
	  $MM_redirectLoginFailed = $GLOBALS['RAIZ']."errorlogin.php";
	  $MM_redirecttoReferrer = true;

	  $LoginRS__query=sprintf("SELECT user_cod, user_username, user_password, user_level, user_theme, id_aud FROM db_user_system WHERE user_username=%s AND user_password=%s",
	  SSQL($loginUsername, "text"), SSQL($password, "text")); 

	  $LoginRS = mysql_query($LoginRS__query) or die(mysql_error());
	  $loginFoundUser = mysql_num_rows($LoginRS);
	  $row_LoginRS = mysql_fetch_assoc($LoginRS);
	  if ($loginFoundUser) {
		$loginStrGroup  = mysql_result($LoginRS,0,'user_level');    
		if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
		//declare two session variables and assign them
		$_SESSION['MM_Username'] = $loginUsername;
		$_SESSION['MM_UserID'] = $row_LoginRS['user_cod'];
		$_SESSION['MM_UserGroup'] = $loginStrGroup;
		$_SESSION['MM_UserAUD'] = $row_LoginRS['id_aud'];
		$_SESSION['bsTheme'] = $row_LoginRS['user_theme'];
		$id_aud=AUD($_SESSION['MM_UserAUD'],NULL,'sysacc');
		header("Location: " . $MM_redirectLoginSuccess );
	  }
	  else header("Location: ". $MM_redirectLoginFailed );
	}
}
?>