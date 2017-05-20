<?php
//V.1.0 = 2016-08-18
//V.1.1 = 2017-05-20 :: Corregido cadenas de texto con problemas al pasar como parametro un string
//TOT ROWS table
function totRowsTabP($table,$param=NULL){
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s WHERE 1=1 %s',
	SSQL($table,''),
	SSQL($param,''));
	$RS = mysql_query(stripslashes($qry)) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RS);
	return ($dRS['TR']);
}
//////////////
/*HOW TO USE*/
$TR=totRowsTabP('db_items_type_vs','fiel="param"');
/*SHow me a integer value (count) of parameters*/
?>