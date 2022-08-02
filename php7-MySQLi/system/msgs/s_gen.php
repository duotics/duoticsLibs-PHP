<?php require_once('../init.php');
$colname_RS_OrderDet = "-1";
if (isset($_GET['idord'])) {
  $colname_RS_OrderDet = $_GET['idord'];
}
$query_RS_OrderDet = sprintf("SELECT * FROM tbl_orders WHERE ord_id = %s", SSQL($colname_RS_OrderDet, "int"));
$RS_OrderDet = mysql_query($query_RS_OrderDet, $conn) or die(mysql_error());
$row_RS_OrderDet = mysql_fetch_assoc($RS_OrderDet);
$totalRows_RS_OrderDet = mysql_num_rows($RS_OrderDet);
$sessionorder=$row_RS_OrderDet['basketSession'];
$query_RS_OrderCart = "SELECT * FROM tbl_baskets WHERE basketSession = '$sessionorder' GROUP BY productID ORDER By basketID DESC";
$RS_OrderCart = mysql_query($query_RS_OrderCart, $conn) or die(mysql_error());
$row_RS_OrderCart = mysql_fetch_assoc($RS_OrderCart);
$totalRows_RS_OrderCart = mysql_num_rows($RS_OrderCart);
if($totalRows_RS_OrderDet>0){ ?>
<div>
<table width="800" align="center" bgcolor="#EEEEEE" cellpadding="2" cellspacing="2">
<tr>
  <td colspan="3" style="color:#FFF; background:#999;" align="center"><span style="font-size:1.3em; margin-right:20px;">ORDER No. <strong><?php echo $row_RS_OrderDet['ord_id']; ?></strong> </span><span style="font-size:0.9em; color:#CCC;">Date. <strong><?php echo $row_RS_OrderDet['ord_date']; ?></strong></span></td></tr>
<tr><td width="100" align="center" bgcolor="#DDDDDD"><strong>Prev</strong></td><td align="center" bgcolor="#DDDDDD"><strong>Code</strong></td><td width="50" align="center" bgcolor="#DDDDDD"><strong>Items</strong></td></tr>
	<?php do { ?>
	<?php $res_prod=f_detprod($row_RS_OrderCart['productID']);?>
	<tr>
		<td style="border-bottom:1px dotted #CCC;" align="center"><a href="http://www.argoequipment.net/images/items/prods/<?php echo $res_prod["prod_img"]; ?>"><img src="../images/items/prods/<?php echo $res_prod["prod_img"]; ?>" height="30" border="0" /></a></td>
        <td style="border-bottom:1px dotted #CCC;"><a href="http://www.argoequipment.net/product.php?idprod=<?php echo $row_RS_OrderCart['productID']; ?>"><?php echo $res_prod['prod_cod']; ?></a></td>
        <td style="border-bottom:1px dotted #CCC;"><?php echo f_totitems_basketsend($row_RS_OrderCart['productID'], $row_RS_OrderCart['basketSession']);?></td>
	</tr>
	<?php } while ($row_RS_OrderCart = mysql_fetch_assoc($RS_OrderCart)); ?>
</table>
</div>
<?php }else{ ?>
<div> Error - Order Not Found !!! <br />please contact webmaster !</div>
<?php } ?>
<?php
mysql_free_result($RS_OrderDet);

mysql_free_result($RS_OrderCart);
?>
