<?php
//Datos de una TABLA / CAMPO SUMA / CAMPO / CONDICION
//v.1.0
//v.2.0 -> mysqli implemented
function sumRow($table,$fielsum,$field,$param,$foN=NULL, $foF='ASC'){//v2.0
	Global $conn;
	if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
	$qry = sprintf("SELECT SUM(%s) AS SUMA FROM %s WHERE %s = %s ".$paramOrd.' LIMIT 1',
				   SSQL($fielsum, ''),
				   SSQL($table, ''),
				   SSQL($field, ''),
				   SSQL($param, "text"));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn)); $dRS = mysqli_fetch_assoc($RS); 
	mysqli_free_result($RS); return ($dRS[SUMA]);
}
/*HOW TO USE*/
$det=sumRow('tbl_database','field_sum','field_table','param','fiel_order','ASC');
?>