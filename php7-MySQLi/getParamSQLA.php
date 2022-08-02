<?php
/* version history
v.0.1 initial code
v.0.2 20200606 add if(isset($val))
*/
function getParamSQLA($params){//duotics_lib -> v.0.2
	$qryParam=null;
	if($params){
		foreach($params as $val){//foreach $params
			if(isset($val)){//Verify if $val (param) exists
				if(!isset($val[3])) $val[3]=' AND ';//Verify if condition SQL was passed else write AND default
				$qryParam.=$val[3].' '.$val[0].' '.$val[1].' "'.$val[2].'"';
			}
		}
	}
	return $qryParam;
}
/**/
if($bus) $param['cod']=array('item_cod','LIKE','%'.$bus.'%');
if($idB) $param['brand']=array('brand_id','=',$idB);
$paramSQL=getParamSQLA($param);
?>