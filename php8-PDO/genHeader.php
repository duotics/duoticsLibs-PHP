<?php
/* Generate Page Header Bootstrap 5.2
20220806 - v.0.2  ->	php8 
*/
function genHeader($MOD=null, $tip='card', $cont=NULL, $floatR=NULL, $floatL=NULL, $css='mb-2', $tag='h1'){//duoticsLib -> php8 -> v.0.2
	$ret=null;
	$retMod=null;
	switch($tip){
		case 'card':
			if($MOD){
				if(isset($MOD['mod_icon'])) $retMod.='<span class="badge badge-light"><i class="'.$MOD['mod_icon'].'"></i></span>';
				$retMod.='<span class="badge badge-primary">'.$MOD['mod_nom'].'</span>';
			}
			$ret.='<div class="card mt-2 mb-2 '.$css.'">';
			$ret.='	<div class="card-body">';
			$ret.='		<div class="btn-group float-right">';
			$ret.=		$floatR;
			$ret.='		</div>';
			$ret.='		<h2 class="mb-0">';
			$ret.=		$retMod.' '.$cont;
			$ret.='		</h2>';
			$ret.='	</div>';
			$ret.='</div>';
		break;
		case 'header':
			if($MOD){
				$retMod.='<span class=""><i class="'.$MOD['mod_icon'].'"></i></span> ';
				$retMod.='<span class="">'.$MOD['mod_nom'].'</span> ';
				$retMod.='<small class="badge badge-light">'.$MOD['mod_des'].'</small>';
			}
			$ret.='<div class="border-bottom mt-2 mb-2 '.$css.'">';
			if ($floatL) $ret.='<div class="float-left">'.$floatL.'</div>';
			if ($floatR) $ret.='<div class="float-right">'.$floatR.'</div>';
			$ret.='<'.$tag.'>';
			$ret.=$retMod.' '.$cont;
			$ret.='</'.$tag.'>';
			$ret.='</div>';
		break;
		case 'navbar':
			$ret.='<nav class="navbar navbar-dark bg-dark '.$css.'">
			<div class="container-fluid">
			<a class="navbar-brand" href="#">
			<i class="'.$MOD['mod_icon'].'"></i> '.
			$MOD['mod_nom'].' <small class="badge badge-secondary">'.$MOD['mod_des'].'</small>
			</a>
			<ul class="navbar-nav mr-auto">
			'.$cont.'
			</ul>
			</div>
			</nav>';
		break;
		default:
			$ret='<div>';
			if(isset($MOD['mod_cod'])) $ret.=' <span class="badge badge-secondary">'.$MOD['mod_cod'].'</span> ';
			$ret.=$MOD['mod_nom'];
			$ret.='<div>';
		break;
	}
	return $ret;
}