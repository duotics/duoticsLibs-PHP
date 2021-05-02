<?php 
/* Obtain total rows of a database table
	$table -> Table database
	$field -> Campo cond
v.1.0 = 2016-08-18
v.1.1 = 2017-05-20 :: Corregido cadenas de texto con problemas al pasar como parametro un string
v.2.0 -> 2018-03-02 -> mysqli updated
v.2.1 -> 20191009 : add msqli_free_result
v.3.0 -> 20210427 : add $aux for some conditions for example INNER JOIN 
*/
function totRowsTabP($table,$param=null,$aux=null){//duotics_lib->v.3.0
	Global $conn;
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s %s WHERE 1=1 %s',
	SSQL($table,''),
	SSQL($aux,''),
	SSQL($param,''));
	$RS = mysqli_query($conn,stripslashes($qry)) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS['TR']);
}
//////////////
/*HOW TO USE*/
$TR=totRowsTabP('db_items_type_vs','fiel="param"','INNER JOIN ....');
/*SHow me a integer value (count) of parameters*/
?>