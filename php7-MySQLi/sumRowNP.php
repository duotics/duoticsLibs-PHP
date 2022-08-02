<?php //Datos de una TABLA con N Parametros
//v.1.0
//v.2.0 update to mysqli
function sumRowNP($table,$fieldsum,$params){ //v2.0 -> duotics_lib
	Global $conn;
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	$qry = sprintf("SELECT SUM(%s) AS SUMA FROM %s WHERE 1=1 ".$lP,
				   SSQL($table, ''),
				   SSQL($fieldsum,''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS[SUMA]);
}
/*HOW TO USE
$paramsN[] -> Params to sumRowNP, 
$paramsN[] :: important => '[]' after the array name '$paramsN'
PARAMS.
	cond -> CONDICION EACH PARAM (OR / AND)
	field -> field in 'table' of database
	comp -> comparation (= / <>)
	val -> value for parameter
*/
$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
$paramsN[]=array(
	array("cond"=>"AND","field"=>"fiel_db","comp"=>"=","val"=>$val1),
	array("cond"=>"AND","field"=>"fiel_db","comp"=>'=',"val"=>$val1)
);
$det=sumRowNP('table','fielsum',$paramsN);
?>