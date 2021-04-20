<?php
/* Version History
v.2.0 start documentation
v.2.1 add $paramOrd=null;
*/
//Datos de una TABLA / CAMPO / CONDICION
function detRow($table,$field,$param,$foN=NULL, $foF='ASC'){//duotics_lib -> v2.1
	Global $conn;
	$paramOrd=null;
	if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
	$qry = sprintf("SELECT * FROM %s WHERE %s = %s ".$paramOrd.' LIMIT 1',
				   SSQL($table, ''),
				   SSQL($field, ''),
				   SSQL($param, "text"));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn)); $dRS = mysqli_fetch_assoc($RS); 
	mysqli_free_result($RS); return ($dRS);
}
/*HOW TO USE*/
$det=detRow('tbl_database','field_table','param','fiel_order','ASC');
?>