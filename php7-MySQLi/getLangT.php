<?php
function getLangT($table,$field,$idr,$lang){
		$detLT=detRow('db_lang_table','table_name',$table);
		if($detLT){
			$idt=$detLT[id];
			$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
			$paramsN[]=array(
				array("cond"=>"AND","field"=>"idt","comp"=>"=","val"=>$idt),
				array("cond"=>"AND","field"=>"field_name","comp"=>'=',"val"=>$field),
				array("cond"=>"AND","field"=>"idr","comp"=>'=',"val"=>$idr),
				array("cond"=>"AND","field"=>"lang","comp"=>'=',"val"=>$lang),
			);
			$detT=detRowNP('db_lang_txt',$paramsN);
			$ret=$detT['txt'];
		}
		return $ret;
}