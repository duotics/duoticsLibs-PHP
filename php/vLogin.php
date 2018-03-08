<?php
//FUNCTIONS ACCESS USERS
//v.0.1 initial code
//v.0.2 mysqli updated -> 2018-03-02
function vLogin($mSel=NULL){//v.0.2
	//,$accesscheck=FALSE){
	Global $conn;
	if($mSel){
		$qry=sprintf('SELECT * FROM tbl_menus_items 
		INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id=tbl_menu_usuario.men_id
		LEFT JOIN db_componentes ON tbl_menus_items.mod_cod=db_componentes.mod_cod
		WHERE tbl_menu_usuario.usr_id=%s AND tbl_menus_items.men_nombre=%s',
		SSQL($_SESSION['MM_UserID'],'int'),
		SSQL($mSel,'text'));
		$RS=mysqli_query($qry);
		$dRS=mysqli_fetch_assoc($RS);
		$tRS=mysqli_num_rows($RS);
		if($tRS>0) $vVM=TRUE;
		else $vVM=FALSE;
	}else $vVM=TRUE;
	$MM_authorizedUsers = "";
	$MM_donotCheckaccess = "true";
	$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";
	if (!((isset($_SESSION['MM_Username'])) && ($vVM) && (isAuthorized($MM_authorizedUsers, $_SESSION['MM_Username'])))) {   
 
	  $MM_qsChar = "?";
	  $MM_referrer = $_SERVER['PHP_SELF'];
	  
	  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
	  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
	  
	  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	  header("Location: ". $MM_restrictGoTo); 
	  exit;
	}
	if($mSel) return($dRS);
}

?>