<?php //Datos de una TABLA con N Parametros
//v1.0
function detRowNP($table,$params){ //v1.0
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	$qry = sprintf("SELECT * FROM %s WHERE 1=1 ".$lP,
	SSQL($table, ''));
	$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS);
	mysql_free_result($RS);
	return ($dRS);
}
/*HOW TO USE
$paramsN[] -> Params to detRowNP, 
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
$det=detRowNP('table',$paramsN);
?>