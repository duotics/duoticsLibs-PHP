<?php 
/*SELECT PARA UN GENERARSELECT WITH N PARAMS
Select para un Listado Form HTML
v.0.1
v.0.2 -> 2017-05-05 :: Correcciones codigo
v.0.3 -> 2017-11-22 :: Valida si el parametro tiene valor
v.1.0 -> 2019-10-05 :: mysqli_update
v.1.1 -> $lp defined null
*/
function detRowGSelNP($table,$fieldID,$fieldVal,$params,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v1.1
	global $conn;
	$lP=null;
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal){
				$lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'];
				if($xVal['val']){
					$lP.=' "'.$xVal['val'].'" ';
				}
			}
		}
	}
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 '.$lP.' %s',
	SSQL($fieldID,''),
	SSQL($fieldVal,''),
	SSQL($table,''),
	SSQL($orderBy,''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn)); 
	return ($RS); mysqli_free_result($RS);
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