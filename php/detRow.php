<?php
//Datos de una TABLA / CAMPO / CONDICION
//v1.0
function detRow($table,$field,$param,$foN=NULL, $foF='ASC'){ 
if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
$qry = sprintf("SELECT * FROM %s WHERE %s = %s ".$paramOrd.' LIMIT 1',
SSQL($table, ''),
SSQL($field, ''),
SSQL($param, "text"));
$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS); 
mysql_free_result($RS); return ($dRS);
}
/*HOW TO USE*/
$det=detRow('tbl_database','field_table','param','fiel_order','ASC');
?>