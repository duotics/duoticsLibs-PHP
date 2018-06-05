<?php
/* Function to obtain list ID from table and params only use sID
Params:
	- $table -> database table from obtain data
	- $fielID -> field used as sID 
	- $field -> field used as param in where
	- $param -> data param to field param
	- $other -> another data in sql like order, limit, etc.
*/
//v.0.1 init code
//v.1.1 migrate to mysqli
function detRowSel($table,$fielID,$field,$param,$other=NULL){//v.1.1
	Global $conn;
	$qry = sprintf('SELECT %s as sID FROM %s WHERE %s=%s '.$other,
	SSQL($fielID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'));
	$RS_datos = mysqli_query($conn,$qry) or die(mysql_error());
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	if($totalRows_RS_datos>0){ $x=0;
		do{ $list[$x]=$row_RS_datos['sID']; $x++;
		} while ($row_RS_datos = mysqli_fetch_assoc($RS_datos));
	}
	mysqli_free_result($RS_datos);
	return ($list);
}

//HOW TO USER
detRowSel('tbl_items_type_vs','typID','item_id',$ids)
?>