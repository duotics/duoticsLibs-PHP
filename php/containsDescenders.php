<?php 
function containsDescenders($param){
	global $conn;
	$vP=FALSE;
	$vD=FALSE;
	$LOG=null;
	$LOGd=null;
	$qry=('SELECT term FROM tbl_contact_term_block WHERE stat=1');
	$RSlt=mysqli_query($conn,$qry);
	$dRSlt=mysqli_fetch_assoc($RSlt);
	$tRSlt=mysqli_num_rows($RSlt);
	if($tRSlt>0){
		do{
			$listTerms[]=$dRSlt['term'];
		}while($dRSlt=mysqli_fetch_assoc($RSlt));
	}
	//listTerms = array("viagra","biagra","sex","sexo", "cialis", "psychology", "ReCaptcha","virgin","virginity","cock","fuck","escort", "Music");
	foreach ($param as $text){
		$LOGd.='Field. '.$text.'<br>';
		foreach ($listTerms as $letter) {
			if (stripos($text,$letter) !== FALSE) {
				$LOGd.='Match prohited terms';
				//$LOG.='Match prohited terms. <br>'.$letter;
				$vP=TRUE;
				break;
			}
		}
	}
	if($vD) $LOG.=$LOGd;
	$ret['est']=$vP;
	$ret['log']=$LOG;
    return $ret;
}

$vI=containsDescenders($dataf);//Verifica que el mensaje no contenga palabras ofensivas dentro del listado de palabras claves

if(!$vI['est']){
}else $LOG.="<h4>Prohibited text detected</h4>Please try again.";

?>