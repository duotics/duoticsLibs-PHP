<?php
//LOGIN TO SYSTEM
/*
v.0.1 initial code
v.0.2 add field user_theme
v.1.0 add SESSION dU and another vars
v.1.1 add level in qry change vars
v.1.2 add vL to verify login
NOTES. review redirect prev URL
*/

function login($loginUsername, $loginPassword, $accesscheck){//v.1.2
	Global $conn;
	$vL=FALSE;
	if (isset($loginUsername)) {
		//session_start();
		$loginPassword=md5($loginPassword);
		
		if ($accesscheck) $MM_redLS = $accesscheck;
		else $MM_redLS = $GLOBALS['RAIZc']."com_index/";
		$MM_redLF = $GLOBALS['RAIZ']."index.php";
		$MM_redRF = true;
		
		$qry=sprintf("SELECT usr_id as ID, usr_nombre as USER, usr_contrasena as PASS, usr_est as EST, 
		usr_level as LEVEL, usr_theme as THEME, id_aud as AUD 
		FROM tbl_usuario WHERE usr_nombre=%s AND usr_contrasena=%s",
						  SSQL($loginUsername, "text"), 
						  SSQL($loginPassword, "text"));
		$LoginRS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
		$loginFoundUser = mysqli_num_rows($LoginRS);
		$dLoginRS = mysqli_fetch_assoc($LoginRS);
		if ($loginFoundUser) {
			if($dLoginRS['EST']==1){
				if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
				$_SESSION['autentificacion']=TRUE;
				$_SESSION['dU']=$dLoginRS;
				$_SESSION['MM_Username'] = $loginUsername;
				$_SESSION['MM_UserID'] = $dLoginRS['ID'];
				$_SESSION['MM_UserAUD'] = $dLoginRS['AUD'];
				$_SESSION['bsTheme'] = $dLoginRS['THEME'];
				$id_aud=AUD($_SESSION['MM_UserAUD'],NULL,'sysacc');

				$vL=TRUE;
				$LOG='<h4>Usuario Identificado</h4>';
			}else $LOG='<h4>Usuario Deshabilitado</h4>Comuniquese con el Administrador';
		}else $LOG='<h4>Error de Nombre de Usuario - Contraseña</h4>Intente de nuevo';
		if($vL){//Login TRUE
		header("Location: ".$MM_redLS.'?LOG='.$LOG);
		}else{//Login False
			header("Location: ".$MM_redLF.'?LOG='.$LOG);
		}
	}
}
?>