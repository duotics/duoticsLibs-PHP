<?php
/* Documentation
	// $table -> Table database
	// $field -> Campo cond
*/
/*version History
V.1.0 = 2016-08-18
V.1.1 = 2017-05-20 :: Corregido cadenas de texto con problemas al pasar como parametro un string
v.2.0 = 2018-04-02 :: update to mysqli
v.2.1 : 20191009 : add mysqli_free_result
v.2.2 upgrade php7
v.2.3 20200606 $qryCond=null; fix bug undefined php7
*/
function totRowsTab($table,$field=NULL,$param=NULL,$cond='='){//duotics_lib->v.2.3
	Global $conn;
	$qryCond=null;
	if(($field)&&($param)){
		$qryCond=sprintf(' WHERE %s %s %s',
						SSQL($field,''),
						SSQL($cond,''),
						SSQL($param,'text'));
	}
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s '.$qryCond,
	SSQL($table,''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS['TR']);/*SHow me a integer value (count) of parameters*/
}
//////////////
/*HOW TO USE*/
$TRitem=totRowsTab('db_items_type_vs','md5(typID)',$ids);
/*SHow me a integer value (count) of parameters*/
?>