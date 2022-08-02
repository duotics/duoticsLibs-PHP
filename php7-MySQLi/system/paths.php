<?php
$domainName='comercialbenavides.com.ec/';
$folderBase='/'; //Remoto. '/'; Local. '/Folder/' (Folder in www)
$folderFE='/'; //Folder for front end
//$folderCont='clinic/'; //Folder if system is in subdirectory
$folderCont='admin2/'; //Folder if system is in subdirectory
$serverRoot=$_SERVER['DOCUMENT_ROOT'];
//$hostType='localhost/'; //Remoto. 'www.'; Local. 'localhost/'
$hostType='www.'; //Remoto. 'www.'; Local. 'localhost/'
$protocolS='http://';

//define('RAIZg',$serverRoot.$folderBase);
//define('RAIZ0',RAIZg.$folderFE);
define('RAIZ0',$serverRoot.$folderBase);
define('RAIZ',RAIZ0.$folderCont);
define('RAIZi',RAIZ.'images/');
define('RAIZidb',RAIZ.'images/db/');
define('RAIZm',RAIZ.'modulos/');
define('RAIZmdb',RAIZ.'media/db/');
define('RAIZf',RAIZ.'frames/');
define('RAIZc',RAIZ.'com/');
define('RAIZs',RAIZ.'system/');
define('RAIZu',RAIZ.'uploads/');
define('RAIZa',RAIZ.'assets/');

global $RAIZ0,$RAIZ,$RAIZi,$RAIZj,$RAIZc,$RAIZc,$RAIZs,$RAIZidb;
$urlCont=$hostType.$domainName;
$RAIZ0=$protocolS.$urlCont;
$RAIZ=$protocolS.$urlCont.$folderCont;
$RAIZa=$RAIZ.'assets/';
$RAIZi=$RAIZa.'images/';
$RAIZii=$RAIZi.'icons/';
$RAIZidb=$RAIZ.'images/db/';
$RAIZj=$RAIZ.'js/';
$RAIZt=$RAIZ.'css/';
$RAIZc=$RAIZ.'com/';
$RAIZci=$RAIZ.'com/com_index/';
$RAIZs=$RAIZ.'system/';
$RAIZu=$RAIZ.'uploads/';
$RAIZmdb=$RAIZ.'media/db/';

$_SESSION['urlp']=$_SESSION['urlc'];
$_SESSION['urlc']=basename($_SERVER['SCRIPT_FILENAME']);//URL clean Current;
$urlc=$_SESSION['urlc'];
$urlp=$_SESSION['urlp'];

//echo RAIZ0;
?>