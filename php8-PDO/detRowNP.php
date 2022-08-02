<?php

function detRowNP($table,$params,int $lim=1){ //duotics_lib -> php8 v.0.1
	/* Limit 0=all, 1=1, x=x*/
	global $dbh;
	$lP=null;
	if($lim!=0){
    	if(($lim<=0)||(!$lim)) $lim=1;
    	$limit=" LIMIT ".$lim;
	}else $limit="";
	if($params){
		foreach($params as $x) {
			foreach($x as $y) $lP.=$y['cond'].' '.$y['field'].' '.$y['comp'].' :'.$y['field'].' ';
		}
	}
    $sql = sprintf("SELECT * FROM %s WHERE 1=1 %s %s",
	htmlentities($table),
	htmlentities($lP),
    htmlentities($limit));
    $RS = $dbh->prepare($sql);
	if($params){
		foreach($params as $x) {
			foreach($x as $y) $RS->bindValue($y['field'],$y['val']);
		}
	}
	$RS->setFetchMode(PDO::FETCH_ASSOC);
	$RS->execute();
    $tRS=$RS->rowCount();
    if((($tRS>1)&&($lim==0))||(($tRS>1)&&($lim>0))) return $RS;
    else return ($RS->fetch());
	//rowCount > 1 && Limit = 0 -> RS
	//rowCount > 1 && Limit > 1 -> RS
	//rowCount > 1 && Limit 1 -> dRS
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