<?php require_once('../../init.php');
$idu=$_REQUEST['id'];
$token=$_REQUEST['token'];
$dU=detRow('db_usuario','usr_id',$idu);
$dP=detRow('db_contactinfo','id',$dU['idp']);
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
<div style="font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif">
<table style="width:100%; border:1px solid #0970B4" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0">
	<tr>
    	<td colspan="2" style="text-align:center; background:#3498db; color:#fff">
        <h1>Eco Ruta Juvenil</h1>
        </td>
    </tr>
    <tr>
    <td style="padding:20px 40px;">
		<h1>Resetear Contraseña</h1>
        <p>Estimado, <?php echo $dP['nom'].' '.$dP['ape'] ?></p>
        <?php $LINK_RPASS=$RAIZ.'mapa/resetP.php?id='.md5($idu).'&token='.$token ?>
        <p>Si usted no ha solicitado un cambio de contraseña por favor ignore este email.</p><br>
        <p>Para cambiar la contraseña clic en el boton</p><br>
        <p><a href="<?php echo $LINK_RPASS ?>" style="padding:10px 20px; background:#3498db; color:#fff; font-size:15px; text-decoration:none;">CAMBIAR CONTRASEÑA</a></p><br>
        <p>SI el boton no funciona copie y pegue el siguiente enlace en la barra de direcciones del navegador</p>
        <p style="font-size:110%"><a href="<?php echo $LINK_RPASS ?>"><?php echo $LINK_RPASS ?></a></p>
        <hr>
        </td>
    </tr>
    <tr>
    	<td><p>Por favor no conteste a este correo, ya que el mismo fue generado automaticamente</p></td>
    </tr>
</table>
</div>
</body>
</html>