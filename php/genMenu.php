<?php
//GENERACION DE MENUS CON NIVELES Y LENGUAJES
function genMenu($refMC,$css=NULL,$vrfUL=TRUE){//v.3.0
	Global $conn;
	//verifico si el menu existe
	$dMC=detRow('tbl_menus','ref',$refMC);
	if($dMC){
		//Consulta si el usuario es SuperAdmin
		if($_SESSION['dU']['LEVEL']!=0){
			$userJoin=' INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id ';
			$userLevel=' AND tbl_menu_usuario.usr_id ='.$_SESSION['dU']['ID'];
		}
		//Consulta para Menus Principales
		$qry=sprintf("SELECT * FROM tbl_menus_items ".
		$userJoin.
		"INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id 
		WHERE tbl_menus.ref = %s 
		AND tbl_menus_items.men_padre = %s ".
		$userLevel.
		" AND tbl_menus_items.men_stat = %s 
		ORDER BY men_orden ASC",
		SSQL($refMC,'text'),
		SSQL('0','int'),
		SSQL('1','text'));
		
		$RSmp = mysqli_query($conn,$qry) or die(mysqli_error($conn));
		$dRSmp = mysqli_fetch_assoc($RSmp);
		$tRSmp = mysqli_num_rows($RSmp);
		//echo $qry;
		//
		if($tRSmp > 0){
			do{
				$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
				$paramsN[]=array(
					array("cond"=>"AND","field"=>"idm","comp"=>"=","val"=>$dRSmp['men_id']),
					array("cond"=>"AND","field"=>"lang","comp"=>'=',"val"=>$_SESSION['lang'])
				);
				$detMenuTopLang=detRowNP('tbl_menus_items_txt',$paramsN);
				if($detMenuTopLang){
					$detMenuTopLang_tit=$detMenuTopLang[titv];
				}else{
					$detMenuTopLang_tit=$dRSmp[men_tit];
				}
				if(!$detMenuTopLang_tit) $detMenuTopLang_tit='N/D';
				
				//Consulta para Submenus
				$qry2 = sprintf("SELECT * FROM tbl_menus_items 
				LEFT JOIN tbl_menus_items_txt ON tbl_menus_items.men_id=tbl_menus_items_txt.idm 
				WHERE tbl_menus_items.men_padre = %s AND tbl_menus_items.men_stat = %s 
				ORDER BY men_orden ASC",
				SSQL($dRSmp['men_id'],'int'),
				SSQL(1,'int'),
				SSQL($_SESSION['lang'],'text'));
				
				//echo $qry2.'<br>'.$tRSmi.'<hr>';
				
				$RSmi = mysqli_query($conn,$qry2) or die(mysqli_error($conn));
				$dRSmi = mysqli_fetch_assoc($RSmi);
				$tRSmi = mysqli_num_rows($RSmi);
				
				
				if($tRSmi>0) $cssSM="dropdown"; 
				else $cssSM="";
				if($dRSmp['men_link']) $link = $GLOBALS['RAIZ'].$dRSmp['men_link'];
				else $link = "#";
				if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];
				$ret.='<li class="'.$cssSM.' '.$dRSmp['men_css'].'" style="'.$dRSmp['men_sty'].'">';
				if($tRSmi > 0){
					$ret.='<a href="'.$link.'" class="dropdown-toggle"';
					if($tRSmi > 0){ $ret.='data-toggle="dropdown"';
				}
				$ret.='>';
				if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
				$ret.=$detMenuTopLang_tit;
				if($tRSmi > 0){
					$ret.=' <b class="caret"></b>';
				}
				$ret.='</a>';
				$ret.='<ul class="dropdown-menu">';
				do{
					if($dRSmi['men_link']){ 
						$link = $GLOBALS['RAIZ'].$dRSmi['men_link'];
					}else{
						$link = "#"; 
					}
					if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];
					$ret.='<li><a href="'.$link.'">';
					
					if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';
					if(!$dRSmi['titv']) $dRSmi['titv']=$dRSmi['men_tit'];
					$ret.=$dRSmi['titv'].'</a></li>';
					
					if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];
					
				}while($dRSmi = mysqli_fetch_assoc($RSmi));
				mysqli_free_result($RSmi);
				$ret.='</ul>';
			}else{
				$ret.='<a href="'.$link.'">';
				if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
				$ret.=$dRSmp['men_tit'].'</a>';
			}                             	                    
			$ret.='</li>';
			if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
		}while($dRSmp = mysqli_fetch_assoc($RSmp));
		mysqli_free_result($RSmp);
		}else{
			$ret.='<li>No items in menu <strong>'.$refMC.'</strong></li>';
		}
	}else $ret.='<li>No existe menu <strong>'.$refMC.'</strong></li>';
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}
?>