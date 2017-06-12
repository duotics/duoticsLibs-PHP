<?php include('../../init.php');
$data=$_REQUEST;//RECEIVE DATA
$LOG.=setCookieArray($data['cookieName'],$data['cookieID'],NULL,TRUE,$data['cookieNum']);
echo json_encode(array("LOG"=>$LOG));
?>