<?php
//function vParam  v.1.1 : 2017-01-05
/* DOCUMENTATION
	$nompar. Nombre del parametro a verificar.
	$pget. Obtenemos parametros GET.
	$ppost. Obtenemos parametros POST.
	$revsess. TRUE o FALSE para confirmar si recuperamos valor desde la $_SESSION
*/
function vParam($nompar, $pget, $ppost, $revsess=NULL){
	//session_start(); //start once
	if(isset($pget)) {$retorno=$pget;}
	else if (isset($ppost)){$retorno=$ppost;}
	else if ($revsess==TRUE) $retorno=$_SESSION[$nompar];
	if ($revsess==TRUE) $_SESSION[$nompar]=$retorno;
	return $retorno;
}
?>