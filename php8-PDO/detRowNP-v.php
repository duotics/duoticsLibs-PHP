<?php
/*
Function to make a SELECT with parameters like table name, fields and params, limit, order
Params. Function returns a single row($dRS -> array fields) or multiple rows ($RS -> asociative arrar multiple rows obtain with fetch())
    $table -> Database tablename example. db_country
    $params -> accept array or arrays to multiple params example:
        $paramsN=NULL;
        $paramsN[]=array(
        array("cond"=>"AND","field"=>"fieldname1","comp"=>">=","val"=>$val1),
        array("cond"=>"AND","field"=>"fieldname2","comp"=>'<=',"val"=>$val2));
    $lim -> now of rows returned
            1 -> returns 1 row -> $dRS (array with row) (default value in function param definition)
            0 -> return all rows -> $RS (array assoc of multiple rows)
            x -> return x rows :
                * option 1 row -> return $dRS
                * option multiple rows -> return $RS
            * if not row results return bool(false)* //BY VERIFY
    $foN -> table field to used to ORDER BY
    $foF -> only send two values:
            * ASC (default)
            * DESC

VERSION HISTORY
            20220802 : v.0.1 -> Updated to PDO; structure to return single or multiple row.


*/

function detRowNP($table,$params,$lim=1,$foN=NULL, $foF='ASC'){ //duotics_lib -> php8
	global $dbh;
	$lP=null;
	$ret=null;
	if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
	else $paramOrd="";

	$limit="";
	if($lim!=0){
    	if(($lim<=0)||(!$lim)) $lim=1;
    	$limit=" LIMIT ".$lim;
	}
	$contParams=0;
	if($params){
		foreach($params as $x) {
			foreach($x as $y){
				$lP.=$y['cond'].' '.$y['field'].' '.$y['comp'].' :'.$contParams.$y['field'].' ';
				$contParams++;
			}
		}
	}
    $sql = sprintf("SELECT * FROM %s WHERE 1=1 %s %s %s",
	htmlentities($table),
	($lP),
	htmlentities($paramOrd),
    htmlentities($limit));
    $RS = $dbh->prepare($sql);
	$contParams=0;
	if($params){
		foreach($params as $x) {
			foreach($x as $y){
				$RS->bindValue($contParams.$y['field'],$y['val']);
				$contParams++;
			}
		}
	}
	$RS->setFetchMode(PDO::FETCH_ASSOC);
	$RS->execute();
    $tRS=$RS->rowCount();
    if((($tRS>1)&&($lim==0))||(($tRS>1)&&($lim>0))) $ret = $RS;
    else $ret = ($RS->fetch());
	$RS->closeCursor();
	return $ret;
}
/* HOW TO USE
$limit param two values possible retunrned:
    single row -> $dRS -> array with al fields of table -> accedd by $dRS['field']
    multiple row -> $RS -> asociative array with multiple rows -> accedd by PDO fetch()
                    can be loop results with 
                    while($dRS=$RS->fetch()){
                        echo $dRS['field']
                    }
*/
$paramsN=NULL;
$paramsN[]=array(
	array("cond"=>"AND","field"=>"fieldname1","comp"=>">=","val"=>$val1),
	array("cond"=>"AND","field"=>"fieldname2","comp"=>'<=',"val"=>$val2)
);
$RScr=detRowNP('database_table',$paramsN,0,"id","ASC");

?>