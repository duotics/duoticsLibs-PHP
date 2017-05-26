<?php 
//SELECT PARA UN GENERARSELECT WITH N PARAMS
// Select para un Listado Form HTML
//v0.1
function detRowGSelNP($table,$fieldID,$fieldVal,$params,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v0.1
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 '.$lP,
	SSQL($fieldID,''),
	SSQL($fieldVal,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($orderBy,''));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}
?>
<?php
/*HOW TO USE*/
$paramsN[]=array(
	array("cond"=>"AND","field"=>"fiel_db","comp"=>"=","val"=>$val1),
	array("cond"=>"AND","field"=>"fiel_db","comp"=>'=',"val"=>$val1)
);
$RS=detRowGSelNP('table','field_id','field_nom',$paramsN,TRUE,'field_ord','ASC');
//Used with function genSelect
echo genSelect('name_select', $RS, $valSel, 'form-control input-sm '); ?>