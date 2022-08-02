<?php require_once('../../init.php');
$id=vparam('id',$_GET['id'],$_POST['id'],FALSE);
$resp=vparam('resp',$_GET['resp'],$_POST['resp'],FALSE);
$detS=detRow('tbl_support','idSp',$id);
$idc=$detS['idData'];
$detC=detRow('tbl_contact_data','idData',$idc);
$idm=$detC['idMail'];
$detM=detRow('tbl_contact_mail','idMail',$idm);
?>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php if($detM){ ?>
<style type="text/css">
td{ padding:5px;}
.cero{ padding:0px !important;}
</style>
<div style="font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif">
<table style="width:100%; border:1px solid #E70D30" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0">
	<tr>
    	<td colspan="2" style="text-align:right; background:#E70D30" class="cero">
        <img src="<?php echo $RAIZi ?>struct/head_mail_support_002.jpg" style="width:inherit;max-width:100%;height:auto;"/>
        </td>
    </tr>
    <?php if($resp==TRUE){ ?>
    <tr>
    	<td colspan="2" style="text-align:center; background:#fff; padding:10px;">
        <h2>Your Inquiry was sent sucessfully, A Representative Will Contact You Soon</h2>
        </td>
    </tr>
    <?php } ?>
    <tr>
        
        <td colspan="<?php echo $valColSpan ?>" style="padding:0">
        <table style="width:100%" cellpadding="4" cellspacing="1">
        
        <?php if(($detC['name'])||($detC['company'])){ ?>
        <tr style="font-size:125%;">
            <td style="width:25%; background:#999; color:#fff">Name & Company</td>
            <td style="width:75%" bgcolor="#FFFFFF"><strong><?php echo $detC['name']; ?></strong>. <?php echo $detC['company']; ?></td>
        </tr><?php } ?>
        <?php if($detM['mail']){ ?>
        <tr style="font-size:125%;">
            <td style="background:#ccc; color:#666">E-Mail</td>
            <td bgcolor="#FFFFFF"><?php echo $detM['mail'] ?></td>
        </tr><?php } ?>
        <?php if(($detC['phone1'])||($detC['phone2'])){ ?>
        <tr>
            <td>Telefono</td>
            <td bgcolor="#FFFFFF"><?php echo $detC['phone1']; ?><br><?php echo $detC['phone2']; ?></td>
        </tr><?php } ?>
        <?php if(($detC['country'])||($detC['state'])||($detC['state'])||($detC['city'])||($detC['zip'])){ ?>
        <tr>
            <td>Location</td>
            <td bgcolor="#FFFFFF">
            <?php
            if($detC['country']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">Country <strong><?php echo $detC['country']?></strong></span>&nbsp;
            <?php }
            if($detC['state']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">State <strong><?php echo $detC['state']?></strong></span>&nbsp;
            <?php }
            if($detC['city']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">City <strong><?php echo $detC['city']?></strong></span>&nbsp;
            <?php }
            if($detC['zip']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">ZIP <strong><?php echo $detC['zip']?></strong></span>&nbsp;
            <?php } ?>
        </tr>
        <?php } ?>
        <?php if($detC['address']){ ?>
        <tr>
          <td>Address</td>
          <td bgcolor="#FFFFFF"><?php echo $detC['address']; ?></td>
        </tr>
        <?php } ?>
        <tr><td colspan="2" style="background:#666; color:#fff"><h3>Support Detaills</h3></td></tr>
        <tr style="font-size:125%;">
            <td>Invoice</td>
            <td bgcolor="#FFFFFF">
            <div style="padding:10px; background:#eee;"><?php echo $detS['invoice']; ?></div>
            </td>
        </tr>
        <tr>
          <td>Date Support</td>
          <td bgcolor="#FFFFFF"><?php echo $detS['date']; ?></td>
        </tr>
        <tr>
          <td>Date Purchase</td>
          <td bgcolor="#FFFFFF"><?php echo $detS['datep']; ?></td>
        </tr>
        <tr>
          <td>Message</td>
          <td bgcolor="#FFFFFF"><div style="padding:10px; background:#eee; border:1px solid #ddd; color:#333 font-size:110%; border-left:10px solid #ddd"><?php echo $detS['msg']; ?></div></td>
        </tr>
        <tr>
          <td>From IP</td>
          <td bgcolor="#FFFFFF"><?php echo $detC['ip']; ?></td>
        </tr>
        <?php if($detS){
		$qryLSD=sprintf('SELECT * FROM tbl_support_det WHERE idSp=%s',
		SSQL($id,'int'));
		$RSlsd=mysql_query($qryLSD) or die(mysql_error());
		$dRSlsd=mysql_fetch_assoc($RSlsd);
		?>
        <tr>
          <td colspan="2" style="background:#666; color:#fff"><h3>List Products Support</h3></td></tr>
          <tr>
          <td colspan="2" style="text-align:center;">
          <table style="width:90%" border="0" cellpadding="5" cellspacing="0" align="center">
          	<tr>
            	<?php do{ ?>
                <td>
                
                <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                	<td style="background:#ccc;color:#333;">Product</td>
                	<td><?php echo $dRSlsd['nom']?></td>
                </tr>
                <tr>
                	<td style="background:#ccc;color:#333;">Serial N°</td>
                    <td><?php echo $dRSlsd['serial']?></td>
                </tr>
                <tr>
                	<td style="background:#ccc;color:#333;">Problem</td>
                    <td><?php echo $dRSlsd['problem']?></td>
                </tr>
              </table>
                
                </td>
                <?php }while($dRSlsd=mysql_fetch_assoc($RSlsd)); ?>
            </tr>
          </table>
          
          </td>
          </tr>
        <?php } ?>
        </table>
        </td>
    </tr>
</table>
</div>
<?php }else{ ?>
<div><h4>Contact ID: <?php echo $id ?> :: Data Not Found !... <br />please contact webmaster !</h4></div>
<?php } ?>
<br>
<div>Support N° <?php echo $id ?></div>
</body>
</html>