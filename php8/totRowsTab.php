<?php

function totRowsTab($table,$field=NULL,$param=NULL,$cond='='){//duotics_lib-> php8 v.0.1
    global $dbh;
	$qryCond=null;
	if((isset($field))&&(isset($param))){
		$qryCond=sprintf(' WHERE %s %s %s',
		htmlentities($field),
		($cond),
		htmlentities(":".$field));
	}
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s '.$qryCond,
	htmlentities($table));

	$RS = $dbh->prepare($qry);
	$RS->bindValue($field,$param);
	$RS -> setFetchMode(PDO::FETCH_ASSOC);
	$RS -> execute();
	$dRS = $RS->fetch();
	return ($dRS['TR']);/*SHow me a integer value (count) of parameters*/
}

/*HOW TO USE*/
$TRitem=totRowsTab('db_items_type_vs','md5(typID)',$ids);
/*SHow me a integer value (count) of parameters*/