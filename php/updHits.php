<?php
//UPDATE HITS ARTICLES FIELD INTEGER PLUS 1 EACH CALL FUNCTION
//v.1.0 inicial code
//v.1.1 return data $ret
function updHits($table,$fieldHits,$fieldId,$val){//v.1.1
	$ret=NULL;
	$vP=FALSE;
	$qry=sprintf('UPDATE %s SET %s=%s+1 WHERE %s=%s',
	SSQL(strip_tags($table),''),
	SSQL(strip_tags($fieldHits),''),
	SSQL(strip_tags($fieldHits),''),
	SSQL(strip_tags($fieldId),''),
	SSQL($val,'int'));
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
?>