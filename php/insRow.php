<?php
/*FUNCTION TO INSERT ROW WITH N PARAMS
v.0.1 -> 2017-06-04 :: Create Function
*/
function insRow($table,$params){//v.0.1
	$pIndex=implode(',',array_keys($params));
	$pValue=implode(',',array_values($params));
	$qry=sprintf('INSERT INTO %s (%s) VALUES (%s)',
				SSQL($table,''),
				SSQL($pIndex,''),
				SSQL($pValue,''));
	if(@mysql_query($qry)){
		$ret['est']=TRUE;
		$ret['id']=@mysql_insert_id();
		$ret['log']='Creado correctamente';
	}else{
		$ret['est']=FALSE;
		$ret['log']='Error. '.mysql_error();
	}
	return($ret);
}
$array = array('first'=>'"daniel"', 'second'=>'"alfredo"', 'banegas'=>'333');
$data=insRow('table',$array);
?>