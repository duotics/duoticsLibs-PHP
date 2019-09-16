<?php
//v.0.2 add $sel=null default, add condition if $sel
function genFormsInpRadio($params,$sel,$typ=null,$def=null,$name=null){//duotics_lib -> v.0.2
						//$data=array("PRE"=>"P", "DEF"=>"D");
						$contI=0;
						foreach($params as $xid => $xval){
							
							switch($typ){
								case 'btn-group':
									$val.='<label class="btn btn-default btn-sm ';
									if(($sel)&&($sel==$xid)) $val.=' active ';
									$val.='"><input type="radio" name="'.$name.'" value="'.$xid.'"';
									if(($sel)&&($sel==$xid)) $val.=' checked ';
									$val.='>'.$xval.'</label>';
								break;
								default:
									$val.='<label class="radio inline">
									<input type="radio" name="'.$name.'" value="'.$xid.'"';
									if($sel){
										if (!(strcmp($xid, $sel))) $val.=' checked ';
									}
									$val.='>'.$xval.'</label>';
							}
							$contI++;
						}
						if($contI>0){
							if($typ=='btn-group') $val='<div class="btn-group" data-toggle="buttons">'.$val.'</div>';
						}
						
						return $val;
					}
//USAGE
$params=array("1"=>"ENABLE", "0"=>"DISABLE");
echo genFormsInpRadio($params,$dG['gall_view'],'btn-group',0,'iView');