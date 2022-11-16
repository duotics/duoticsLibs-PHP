<?php
/*documentation
	$data=array("PRE"=>"P", "DEF"=>"D");
*/
/*version history
v.0.2 add $sel=null default, add condition if $sel
v.0.3 more options switch case
v.0.4 add $val=null; fix bug php 7
v.0.5 20200618 : add spaces after and befre $xval
v.0.6 20210504 : changes styles comp with bootstrap 5, and ID property mod with name at begin
v.0.7 20221115 : add if for verify isset $sel
v.0.8 20221115 : minimize code and optimize, styles to BS5
*/
function genFormsInpRadio($params, $sel = null, $typ = null, $def = null, $name = null)
{ //duotics_lib -> v.0.7
	$val = null;
	$contI = 0;
	foreach ($params as $xid => $xval) {
		$actinp = null;
		if (isset($sel)) {
			if (!strcmp($sel, $xid)) $actinp .= ' checked ';
		}
		switch ($typ) {
			case 'btn-group':
				$val .= "<input class='btn-check' type='radio' name='{$name}' id='{$name}-{$xid}' value='{$xid}' {$actinp}>
				<label class='btn btn-outline-primary' for='{$name}-{$xid}'>{$xval}</label>";
				break;
			case 'inline':
				$val .= "<div class='form-check form-check-inline'>
				<input name='{$name}' class='form-check-input' type='radio' id='{$name}-inlineRadioOptions{$xid}' value='{$xid}' {$actinp}>
				<label class='form-check-label' for='{$name}-inlineRadioOptions{$xid}'>{$xval}</label></div>";
				break;
			default:
				$val .= "<label class='radio inline'><input type='radio' name='{$name}' value='{$xid}' {$actinp}>{$xval}</label>";
				break;
		}
		$contI++;
	}
	if ($contI > 0) {
		if ($typ == 'btn-group') $val = "<div class='btn-group btn-group-sm' role='group' data-toggle='buttons'>{$val}</div>";
	}
	return $val;
}
//USAGE
$params = array("1" => "ENABLE", "0" => "DISABLE");
echo genFormsInpRadio($params, $dG['gall_view'], 'btn-group', 0, 'iView');

$params = array("1" => "ENABLE", "0" => "DISABLE");
echo genFormsInpRadio($params, $dFile['stat'], 'btn-group', 1, 'iStat');

$params = array("0" => "UPLOAD", "1" => "EXTERNAL");
echo genFormsInpRadio($params, $dFile['ext'], 'btn-group', null, 'iExt');

$params = array("1" => "VIEW", "0" => "HIDDEN");
echo genFormsInpRadio($params, $dG['gall_view'], 'btn-group', 1, 'iView');

$params = array("1" => "ENABLE", "0" => "DISABLE");
echo genFormsInpRadio($params, $dG['gall_stat'], 'btn-group', 1, 'iStat');

$params = array("1" => "ENABLE", "0" => "DISABLE");
echo genFormsInpRadio($params, $item_stat, 'inline', 1, 'item_status');
