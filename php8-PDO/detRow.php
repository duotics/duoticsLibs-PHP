<?php 
/* function to obtain a simple row
Version History
v.0.1 update to PDO and php8.1
*/
//Datos de una TABLA / CAMPO / CONDICION / CAMPO ORDEN / TIPO ORDEN

function detRow($table,$field,$param,$foN=NULL, $foF='ASC'){//duotics_lib -> php8
	global $dbh;
	if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
	else $paramOrd="";
	$sql=sprintf("SELECT * FROM %s WHERE %s = :param %s LIMIT 1",
	htmlentities($table),
	htmlentities($field),
	htmlentities($paramOrd));

	$RS = $dbh->prepare($sql);
	$RS->bindValue("param", $param);
	$RS->setFetchMode(PDO::FETCH_ASSOC);
	$RS->execute();
	$dRS = $RS->fetch();
	return $dRS;
}

/*HOW TO USE*/
$det=detRow('tbl_database','field_table','param','fiel_order','ASC');
?>