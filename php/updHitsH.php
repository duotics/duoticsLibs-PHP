<?php
function updHitsH($paramRef,$paramSec){//v.0.1
	$LOG=null;
	$sdateYM=null;
	$dateYM=null;
	$pHits=null;
	$userAgent=$_SERVER['HTTP_USER_AGENT'];
	$vB=containsBots($userAgent);//Verifico si el HTTP USER AGENT contiene una palabra relacionada a Bots/
	if(!$vB['est']){//Si no contiene una palabra relacionada a Bots Almanacena
	
		global $conn;
		$ret=NULL;
		$vP=FALSE;
		$dateYM=$GLOBALS['sdateYM'];
		$dateTimeNow=$GLOBALS['sdatet'];
		$user_ip = getUserIP();

		$paramsN[]=array(
			array("cond"=>"AND","field"=>"obs","comp"=>"=","val"=>$userAgent),
			array("cond"=>"AND","field"=>"ref","comp"=>"=","val"=>$paramRef),
			array("cond"=>"AND","field"=>"sec","comp"=>"=","val"=>$paramSec),
			array("cond"=>"AND","field"=>"date","comp"=>"=","val"=>$dateYM),
			array("cond"=>"AND","field"=>"ip","comp"=>'=',"val"=>$user_ip)
		);//CONDICIONES CAMPO URL e ID tabla
		$dHitExist=detRowNP('db_hits',$paramsN);
		if($dHitExist){
			$minTrans=minutosTranscurridos($dHitExist['last'],$dateTimeNow);
			if($minTrans>0){
				$pHits=TRUE;
			}
		}else{
			$pHits=TRUE;
		}
		//var_dump($dHitExist);
		if($pHits){
			$qry=sprintf('INSERT INTO db_hits (ref, sec, date, ip, last, obs, hits) VALUES (%s, %s, %s, %s, %s, %s, 1)
			ON DUPLICATE KEY UPDATE hits = hits+1, ip=%s, last=%s, obs=%s',
			SSQL($paramRef,'int'),
			SSQL($paramSec,'text'),
			SSQL($dateYM,'text'),
			SSQL($user_ip,'text'),
			SSQL($dateTimeNow,'text'),
			SSQL($userAgent,'text'),
			//KEY UPDATE
			SSQL($user_ip,'text'),
			SSQL($dateTimeNow,'text'),
			SSQL($userAgent,'text'));
			if(mysqli_query($conn,$qry)){
				$LOG.='Hits updated';
				$vP=TRUE;
			}else{
				$LOG.=mysqli_error($conn);
			}
		}else{
			$LOG.='No Update - too short time betwee visits - '.$dateTimeNow;
		}
	}
	
	$ret['log']=$LOG;
	$ret['est']=$vP;
	return $ret;
}

function containsBots($param){
	$vP=FALSE;
	$vD=FALSE;
	$LOGd=null;
	$LOG=null;
	$listTerms=array('bot','spider','Vagabondo');
	//listTerms = array("viagra","biagra","sex","sexo", "cialis", "psychology", "ReCaptcha","virgin","virginity","cock","fuck","escort", "Music");
		foreach ($listTerms as $letter) {
			$LOGd.='Term. '.$letter.'<br>';
			if (stripos($param,$letter) !== FALSE) {
				$LOGd.='Match prohited terms';
				//$LOG.='Match prohited terms. <br>'.$letter;
				$vP=TRUE;
				break;
			}
	}
	if($vD) $LOG.=$LOGd;
	$ret['est']=$vP;
	$ret['log']=$LOG;
	$ret['logd']=$LOGd;
    return $ret;
}
function minutosTranscurridos($fecha_i,$fecha_f){
	$minutos = (strtotime($fecha_i)-strtotime($fecha_f))/60;
	$minutos = abs($minutos); $minutos = floor($minutos);
return $minutos;
}

/////////////////////////////////////////////////////
/* USAGE */
$hitsS=updHitsH($idr,'prod');
?>