<?php
/* Function to obtain list ID from table and params only use sID
Params:
	- $table -> database table from obtain data
	- $fielID -> field used as sID 
	- $field -> field used as param in where
	- $param -> data param to field param
	- $other -> another data in sql like order, limit, etc.
v.0.1 init code
v.1.1 migrate to mysqli
v.1.2 20191009 change variable names
*/
function detRowSel($table,$fielID,$field,$param,$other=NULL){//v.1.2
	Global $conn;
	$list=null;
	$q = sprintf('SELECT %s as sID FROM %s WHERE %s=%s '.$other,
	SSQL($fielID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'));
	$RS = mysqli_query($conn,$q) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
	if($tRS>0){ $x=0;
		do{ $list[$x]=$dRS['sID']; $x++;
		} while ($dRS = mysqli_fetch_assoc($RS));
	}
	mysqli_free_result($RS);
	return ($list);
}
//HOW TO USER
detRowSel('tbl_items_type_vs','typID','item_id',$ids)
?>