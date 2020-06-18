<?php
/*documentation
	$data=array("PRE"=>"P", "DEF"=>"D");
*/
/*version history
v.0.2 add $sel=null default, add condition if $sel
v.0.3 more options switch case
v.0.4 add $val=null; fix bug php 7
v.0.5 20200618 : add spaces after and befre $xval
*/
function genFormsInpRadio($params,$sel=null,$typ=null,$def=null,$name=null){//duotics_lib -> v.0.5
	$val=null;
	$contI=0;
	foreach($params as $xid => $xval){
		switch($typ){
			case 'btn-group':
				$val.='<label class="btn btn-default btn-sm ';
				if (!(strcmp($sel, $xid))) $val.=' active ';
				else if (!(strcmp($def, $xid))) $val.=' active ';
				$val.='"><input type="radio" name="'.$name.'" value="'.$xid.'"';
				if (!(strcmp($sel, $xid))) $val.=' checked ';
				else if (!(strcmp($def, $xid))) $val.=' checked ';
				$val.='> '.$xval.' </label>';
			break;
			case 'inline':
				$val.='<div class="form-check form-check-inline">';
				$val.='<input name="'.$name.'" class="form-check-input" type="radio" id="inlineRadioOptions'.$xid.'" value="'.$xid.'"';
				if (!(strcmp($sel, $xid))) $val.=' checked ';
				else if (!(strcmp($def, $xid))) $val.=' checked ';
				$val.='>';
				$val.='<label class="form-check-label" for="inlineRadioOptions'.$xid.'"> '.$xval.' </label>';
				$val.='</div>';
			break;
			default:
				$val.='<label class="radio inline">
				<input type="radio" name="'.$name.'" value="'.$xid.'"';
				if (!(strcmp($sel, $xid))) $val.=' checked ';
				else if (!(strcmp($def, $xid))) $val.=' checked ';
				$val.='> '.$xval.' </label>';
			break;
		}
		$contI++;
	}
	if($contI>0){
		if($typ=='btn-group') $val='<div class="btn-group" data-toggle="buttons"> '.$val.' </div>';
	}
	return $val;
}
//USAGE
$params=array("1"=>"ENABLE", "0"=>"DISABLE");
echo genFormsInpRadio($params,$dG['gall_view'],'btn-group',0,'iView');

$params=array("1"=>"ENABLE", "0"=>"DISABLE");
echo genFormsInpRadio($params,$dFile['stat'],'btn-group',1,'iStat');

$params=array("0"=>"UPLOAD", "1"=>"EXTERNAL");
echo genFormsInpRadio($params,$dFile['ext'],'btn-group',null,'iExt');

$params=array("1"=>"VIEW", "0"=>"HIDDEN");
echo genFormsInpRadio($params,$dG['gall_view'],'btn-group',1,'iView');

$params=array("1"=>"ENABLE", "0"=>"DISABLE");
echo genFormsInpRadio($params,$dG['gall_stat'],'btn-group',1,'iStat');

$params=array("1"=>"ENABLE", "0"=>"DISABLE");
echo genFormsInpRadio($params,$item_stat,'inline',1,'item_status');