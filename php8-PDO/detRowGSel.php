<?php
/*SELECT PARA UN GENERARSELECT
Select para un Listado Form HTML
20220802 v0.1 Updated for PHP8 & PDO
*/

function detRowGSel($table,$fieldID,$fieldVal,$field,$param,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//duotics_lib-> php8 v0.1
	global $dbh;
	$orderBy="";//Param for ordering SQL rows
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}

	$qry = sprintf('SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=:%s %s',
	htmlentities($fieldVal),
	htmlentities($fieldID),
	htmlentities($table),
	htmlentities($field),
	htmlentities($field),
	htmlentities($orderBy));

	$RS = $dbh->prepare($qry);
	$RS -> bindValue(":".$field,$param);
	$RS -> execute();
	$RS -> closeCursor();
	return ($RS);
}

/*HOW TO USE*/
//detRowGSel('table','field_id','field_nom','field_status','1','field_nom');
detRowGSel('table','field_val','field_id','field_cond','cond',TRUE,'field_order','ASC');

//Used with genSelect
echo genSelect('name_select', detRowGSel('table','field_val','field_id','field_cond','cond',TRUE,'field_order','ASC'), $valSel, 'form-control input-sm ');

?>