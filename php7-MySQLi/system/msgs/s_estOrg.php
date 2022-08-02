<?php require_once('../../init.php');
$id=$_REQUEST['id'];
//$token=$_REQUEST['token'];

$dO=detRow('db_org','md5(id)',$id);
$dP=detRow('db_contactinfo','id',$dO['idp']);
$dU=detRow('db_usuario','usr_id',$dO['idu']);
$dUP=detRow('db_contactinfo','id',$dU['idp']);

switch($dO['est']){
	case '0': $estOrg='Pendiente de Aprobaci&oacute;n'; break;
	case '1': $estOrg='Aprobada'; break;
	case '2': $estOrg='Rechazada'; break;
	default: $estOrg='No Definido !'; break;
}
?>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<style type="text/css">
td{ padding:5px;}
.cero{ padding:0px !important;}
.f1{font-size:110%}
.f2{font-size:120%}
</style>
<div style="font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size:16px">
<table style="width:100%; border:1px solid #0970B4" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0">
	<tr>
    	<td colspan="2" style="text-align:center; background:#3498db; color:#fff">
        <h1>Eco Ruta Juvenil</h1>
        </td>
    </tr>
    <tr>
    <td style="padding:20px 40px;">
	<?php if($dO){ ?>
		<h1>Estado de Organizaci&oacute;n</h1>
        <p>Estimado/a <?php echo $dUP['nom'].' '.$dUP['ape'] ?></p>
        <p style="font-size:120%">Su organizaci&oacute;n <strong>'<?php echo $dP['nom'].' '.$dP['ape'] ?>'</strong> se encuentra <strong><?php echo $estOrg ?></strong></p><br>
    <?php switch($dO['est']){
		case '0': ?>
        
        <span style="font-size:90%; padding:5px 15px; background:#ddd;">Mensaje del Administrador</span>
    <?php if($dO['msg']){ ?>
    <div style="padding:5px 10px; border:1px solid #ccc; background:#fff">
    <p><?php echo htmlentities($dO['msg']) ?></p>
    </div>
    <?php } ?>
        
        <p>Recuerde que la verificaci&oacute;n de la informaci&oacute;n puede tomar hasta 5 d&iacute;as</p>
    <?php 
		break;
		case '1':
		$LINK_ORG=$RAIZ0.'mapa/det.php?id='.$id;
		?>
        <p>Su Organizaci&oacute;n ya puede visualizarse en el mapa</p><br>
        
        <p><a href="<?php echo $LINK_ORG ?>" style="padding:15px 25px; background:#3498db; color:#fff; font-size:20px; text-decoration:none;">VER ORGANIZACION</a></p><br>
        
        <p>Si el link no funciona puede copiar el enlace de a continuaci&oacute;n</p>
        <p><a href="<?php echo $LINK_ORG ?>"><?php echo $LINK_ORG ?></a></p>
    <?php 
		break;
		case '2': ?>
        <p>Por favor inicie sesi&oacute;n y realice los cambios solicitados, una vez actualizada la informaci&oacute;n procederemos a la revisi&oacute;n y aprobaci&oacute;n de la organizaci&oacute;n</p><br>
    <?php
    	break;
		default: ?>
        <p><strong>Error !</strong> Esta organizaci&oacute;n no puede ser procesada en este momento, para mas informaci&oacute;n por favor contactarse a <strong>soporte@ecorutajuvenil.org</strong></p>
    <?php 
		break;
	} ?>
    
    
    
    <?php }else{ ?>
    <p><strong>Error</strong> no se encuentra el Registro relacionado</p>
	<?php } ?>
    </td>
    </tr>
    <tr>
    	<td style="padding:5px 15px;"><p>No responda a este correo el mismo fue generado autom&aacute;ticamente</p></td>
    </tr>
</table>
</div>
</body>
</html>