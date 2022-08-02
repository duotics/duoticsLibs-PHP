<?php require_once('../../init.php');
$id=$_REQUEST['id'];
//$token=$_REQUEST['token'];
$dP=detRow('db_pag','md5(id)',$id);
$dPP=detRow('db_contactinfo','id',$dP['idp']);
$dU=detRow('db_usuario','usr_id',$dP['idu']);
$dUP=detRow('db_contactinfo','id',$dU['idp']);
switch($dP['est']){
	case '0': $estPub='Pendiente de Aprobación'; break;
	case '1': $estPub='Aprobada'; break;
	case '2': $estPub='Rechazada'; break;
	default: $estPub='No Definido !'; break;
}
?>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<style type="text/css">
td{ padding:5px;}
.cero{ padding:0px !important;}
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
	<?php if($dP){ ?>
		<h1>Estado de Publicacion</h1>
        <p>Estimad@, <?php echo $dUP['nom'].' '.$dUP['ape'] ?></p>
        <p style="font-size:120%">Su Publicación <strong>'<?php echo $dP['tit'] ?>'</strong> se encuentra <strong><?php echo $estPub ?></strong></p><br>
        <p></p>
    <?php switch($dP['est']){
		case '0': ?>
        <p>Recuerde que la verificación de la información puede tomar hasta 5 días"</p>
    <?php 
		break;
		case '1':
		$LINK_PUB=$RAIZ0.'web/a/'.$id;
		?>
        <p>Su Publicación ya puede visualizarse en la web</p><br>
        
        <p><a href="<?php echo $LINK_PUB ?>" style="padding:15px 25px; background:#3498db; color:#fff; font-size:20px; text-decoration:none;">VER PUBLICACION</a></p><br>
        
        <p>Si el link no funciona puede copiar el enlace de a continuación</p>
        <p><a href="<?php echo $LINK_PUB ?>"><?php echo $LINK_PUB ?></a></p>
    <?php 
		break;
		case '2': ?>
        <p>Por favor inicie sesión y realice los cambios solicitados, una vez actualizada la información procederemos a la revisión y aprobación</p><br>
    <?php
    	break;
		default: ?>
        <p><strong>Error !</strong> Esta Publicación no puede ser procesada en este momento, para mas informacion por favor contactarse a <strong>soporte@ecorutajuvenil.org</strong></p>
    <?php 
		break;
	} ?>
    
    <span style="font-size:90%; padding:5px 15px; background:#ddd;">Mensaje del Administrador</span>
    <?php if($dP['msg']){ ?>
    <div style="padding:5px 10px; border:1px solid #ddd; background:#fff">
    <p><?php echo $dP['msg'] ?></p>
    </div>
    <?php } ?>
    
    <?php }else{ ?>
    <p><strong>Error</strong> no se encuentra el Registro relacionado</p>
	<?php } ?>
    </td>
    </tr>
    <tr>
    	<td style="padding:5px 15px;"><p>Por favor no conteste a este correo, ya que el mismo fue generado automaticamente</p></td>
    </tr>
</table>
</div>
</body>
</html>