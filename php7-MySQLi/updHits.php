<?php
//UPDATE HITS ARTICLES FIELD INTEGER PLUS 1 EACH CALL FUNCTION
//v.1.0 inicial code
//v.1.1 return data $ret
//v.1.2 SQL --> LIMIT 1; val param type int to text
function updHits($table,$fieldHits,$fieldId,$val){//v.1.2
	$ret=NULL;
	$vP=FALSE;
	$qry=sprintf('UPDATE %s SET %s=%s+1 WHERE %s=%s LIMIT 1',
	SSQL(strip_tags($table),''),
	SSQL(strip_tags($fieldHits),''),
	SSQL(strip_tags($fieldHits),''),
	SSQL(strip_tags($fieldId),''),
	SSQL($val,'text'));
	if(mysqli_query($GLOBALS['conn'],$qry)){
		$LOG.='Hits updated';
		$vP=TRUE;
	}else{
		$LOG.=mysqli_error();
	}
	$ret['log']=$LOG;
	$ret['est']=$vP;
	return $ret;
}
//EXAMPLE
updHits('tbl_items','hits','id',$ID);
?>