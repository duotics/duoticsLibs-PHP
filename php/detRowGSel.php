<?php 
//SELECT PARA UN GENERARSELECT
// Select para un Listado Form HTML
//v1.0
//v1.0.1 change order of SELECT, first sVAL, later sID, because the use of certain expresions like DISTINCT cause error of syntaxis
//v.1.1 mysqli updated
//v.1.2 Global $conn add
function detRowGSel($table,$fieldID,$fieldVal,$field,$param,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v1.2
	Global $conn;
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=%s %s',
	SSQL($fieldVal,''),
	SSQL($fieldID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($orderBy,''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn)); 
	return ($RS); mysqli_free_result($RS);
}

/*HOW TO USE*/
//detRowGSel('table','field_id','field_nom','field_status','1','field_nom');
detRowGSel('table','field_val','field_id','field_cond','cond',TRUE,'field_order','ASC');

//Used with genSelect
echo genSelect('name_select', detRowGSel('table','field_val','field_id','field_cond','cond',TRUE,'field_order','ASC'), $valSel, 'form-control input-sm ');
?>