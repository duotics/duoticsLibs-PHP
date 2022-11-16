<?php
//FUNCTION -genSelect- TO GENERATE SELECT (FORM html)
/* Documentation
	//PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
*/
/* version history
	v.0.1 to use with RS data from PDO fetch ASSOC data array value include sID and sVAL
*/

function genSelectList($nom = NULL, $list = null, $sel = NULL, $class = NULL, $opt = NULL, $id = NULL, $placeHolder = NULL, $showIni = TRUE, $valIni = NULL, $nomIni = "Select")
{ //duotics_lib->v.4.1
    $ret = null;
    $retSelIni = null;
    $retSel = null;

    $dRS = null;
    $grpAct = null;
    $grpSel = null;
    $banG = false;
    if ($list) {
        //$dRS = mysqli_fetch_assoc($RS);
        $tRS = count($list);
        if (!isset($id)) $id = $nom;
        if (!$nom) $nom = "select";
        $ret .= "<select name='{$nom}' id='{$id}' class='{$class}' data-placeholder='{$placeHolder}' {$opt}>";
        //Show Ini Value
        if ($showIni == TRUE) {
            if (!$sel) $retSelIni = "selected='selected'";
            $ret .= "<option value='{$valIni}' {$retSelIni}>{$nomIni}</option>";
        }
        if ($tRS > 0) {
            foreach ($list as $dRS) {
                if (isset($dRS['sGRUP'])) $grpAct = $dRS['sGRUP'];
                if (($grpSel != $grpAct) && (isset($grpAct))) {
                    if ($banG == true) $ret .= '</optgroup>';
                    $ret .= "<optgroup label='{$dRS[' sGRUP']}'>";
                    $grpSel = $grpAct;
                    $banG = true;
                }
                $retSel = null;
                if ($sel) {
                    if (is_array($sel)) {
                        if (in_array($dRS['sID'], $sel)) {
                            $retSel = "selected='selected'";
                        }
                    } else {
                        if (!(strcmp($dRS['sID'], $sel))) {
                            $retSel = "selected='selected'";
                        }
                    }
                }
                $ret .= "<option value='{$dRS[' sID']}' {$retSel}>{$dRS['sVAL']}</option>";
            }
            if ($banG == true) $ret .= '</optgroup>';
        }
        $ret .= "</select>";
    } else {
        $ret .= "<span class='label label-danger'>Error genSelect : {$nom}</span>";
    }
    return $ret;
}
/* HOW TO USE 
DATA FROM PDO class array data

*/
