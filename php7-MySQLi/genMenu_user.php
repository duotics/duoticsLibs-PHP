<?php
//FUNCTION -genMenu- TO GENERATE MENU FROM DATABASE (FORM html), VERIFY USER ASIGNED
/*
v.0.1 initial code
*/
function genMenu($refMC,$css=NULL,$vrfUL=TRUE){//v.0.1
	//Consulta para Menus Principales
	$qry=sprintf("SELECT * FROM tbl_menus_items 
	INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
	INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id 
	WHERE tbl_menus.ref = %s 
	AND tbl_menus_items.men_padre = %s AND tbl_menu_usuario.usr_id = %s 
	AND tbl_menus_items.men_stat = %s 
	ORDER BY men_orden ASC",
	SSQL($refMC,'text'),
	SSQL('0','int'),
	SSQL($_SESSION['dU']['usr_id'],'int'),
	SSQL('1','text'));
	$RSmp = mysql_query($qry) or die(mysql_error());
	$dRSmp = mysql_fetch_assoc($RSmp);
	$tRSmp = mysql_num_rows($RSmp);
	if($tRSmp > 0){
		do{
			//Consulta para Submenus
			$qry2 = sprintf("SELECT * FROM tbl_menus_items 
			INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
			WHERE tbl_menus_items.men_padre = %s AND tbl_menu_usuario.usr_id = %s AND tbl_menus_items.men_stat = %s 
			ORDER BY men_orden ASC",
			SSQL($dRSmp['men_id'],'int'),
			SSQL($_SESSION['dU']['usr_id'],'int'),
			SSQL(1,'int'));
			$RSmi = mysql_query($qry2) or die(mysql_error());
			$dRSmi = mysql_fetch_assoc($RSmi);
			$tRSmi = mysql_num_rows($RSmi);
			if($tRSmi>0) $cssSM="dropdown"; 
			else $cssSM="";
			if($dRSmp['men_link']) $link = $GLOBALS['RAIZc'].$dRSmp['men_link'];
			else $link = "#";
			if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];
			$ret.='<li class="'.$cssSM.'">'; 
			if($tRSmi > 0){
				$ret.='<a href="'.$link.'" class="dropdown-toggle"';
				if($tRSmi > 0){ $ret.='data-toggle="dropdown"';
			}
			$ret.='>';
			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
			$ret.=$dRSmp['men_tit'];
			if($tRSmi > 0){
				$ret.=' <b class="caret"></b>';
			}
			$ret.='</a>';
			$ret.='<ul class="dropdown-menu">';
			do{
				if($dRSmi['men_link']){ 
					$link = $GLOBALS['RAIZc'].$dRSmi['men_link'];
				}else{
					$link = "#"; 
				}
			if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];
			$ret.='<li><a href="'.$link.'">';
			if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';
			$ret.=$dRSmi['men_tit'].'</a></li>';
			if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];
			}while($dRSmi = mysql_fetch_assoc($RSmi));
			mysql_free_result($RSmi);
			$ret.='</ul>';
		}else{
			
			$ret.='<a href="'.$link.'">';
			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
			$ret.=$dRSmp['men_tit'].'</a>';
		}                             	                    
		$ret.='</li>';
		if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
	}while($dRSmp = mysql_fetch_assoc($RSmp));
	mysql_free_result($RSmp);
	}else{
		$ret.='<li>No existen menus para <strong>'.$refMC.'</strong></li>';
	}
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}

?>
<!--EXAMPLE USE-->
<div class="collapse navbar-collapse" id="mainMenu">
	<?php echo genMenu('MAINMENU','nav navbar-nav') ?>
		<ul class="nav navbar-nav navbar-right">
			<li><a><div id="logF"></div></a></li>
			<li><a href="#"><div id="loading"><img src="<?php echo $RAIZa ?>images/struct/loader.gif"/></div></a></li>
			<?php echo genMenu('CONFIGUSER','NULL',FALSE) ?>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['dU']['usr_nombre'] ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo $RAIZc?>com_usersystem/user_perfil.php">Informacion Usuario</a></li>
            <li><a href="<?php echo $RAIZc?>com_usersystem/changePass.php" class="fancybox fancybox.iframe fancyreload">Cambiar Contraseña</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $RAIZ ?>logout.php">Salir</a></li>          
            </ul>
            </li>
		</ul>
	</div>