<?php
//V.1.0 = 2016-08-18
//V.1.1 = 2017-05-20 :: Corregido cadenas de texto con problemas al pasar como parametro un string
function totRowsTab($table,$field=NULL,$param=NULL,$cond='='){//v.1.1
	// $table -> Table database
	// $field -> Campo cond
	if(($field)&&($param)){
		$qryCond=sprintf(' WHERE %s %s %s',
						SSQL($field,''),
						SSQL($cond,''),
						SSQL($param,'text'));
	}
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s '.$qryCond,
	SSQL($table,''));
	echo $qry.'<hr>';
	$RS = mysql_query($qry) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RS);
	return ($dRS['TR
	/*SHow me a integer value (count) of parameters*/']);
}
//////////////
/*HOW TO USE*/
$TRitem=totRowsTab('db_items_type_vs','md5(typID)',$ids);
/*SHow me a integer value (count) of parameters*/
?>