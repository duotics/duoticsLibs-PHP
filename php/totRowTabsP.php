<?php /* Obtain total rows of a database table
	// $table -> Table database
	// $field -> Campo cond
*/
//V.1.0 = 2016-08-18
//V.1.1 = 2017-05-20 :: Corregido cadenas de texto con problemas al pasar como parametro un string
//v.2.0 -> 2018-03-02 -> mysqli updated
//TOT ROWS table
function totRowsTabP($table,$param=NULL){//v.2.0
	Global $conn;
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s WHERE 1=1 %s',
	SSQL($table,''),
	SSQL($param,''));
	$RS = mysqli_query($conn,stripslashes($qry)) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	return ($dRS['TR']);
}
//////////////
/*HOW TO USE*/
$TR=totRowsTabP('db_items_type_vs','fiel="param"');
/*SHow me a integer value (count) of parameters*/
?>