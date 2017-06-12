<?php
function getParamSQLA($params){
	if($params){
		foreach($params as $val){
			if(!$val[3]) $val[3]=' AND ';
			$qryParam.=$val[3].' '.$val[0].' '.$val[1].' "'.$val[2].'"';
		}
	}
	return $qryParam;
}
/**/
if($bus) $param['cod']=array('item_cod','LIKE','%'.$bus.'%');
if($idB) $param['brand']=array('brand_id','=',$idB);
$paramSQL=getParamSQLA($param);
?>