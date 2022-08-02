<?php
//FUNCTIONS ACCESS USERS
//v.0.1 initial code
//v.0.2 mysqli updated -> 2020-09-18
function genCadSearchPac($term){
    if ($term){
        $cadBus=fnc_cutblanck($term);
        $cadBusT=explode(" ",$cadBus);
        $cadBusN=count($cadBusT);
        if($cadBusN>1){
        $qry=sprintf('SELECT *, MATCH (db_pacientes_nom.pac_nom, db_pacientes_nom.pac_ape) AGAINST (%s) AS Score FROM db_pacientes_nom
    INNER JOIN db_pacientes ON db_pacientes.pac_cod=db_pacientes_nom.pac_cod
    WHERE MATCH (db_pacientes_nom.pac_nom, db_pacientes_nom.pac_ape) AGAINST (%s)
    ORDER BY Score DESC ',
        SSQL($cadBus,'text'),
        SSQL($cadBus,'text'));
        }else{
            $qry=sprintf('SELECT * FROM db_pacientes_nom
    INNER JOIN db_pacientes ON db_pacientes.pac_cod=db_pacientes_nom.pac_cod
    WHERE db_pacientes.pac_nom LIKE %s OR db_pacientes.pac_ape LIKE %s ',
        SSQL('%'.$cadBus.'%','text'),
        SSQL('%'.$cadBus.'%','text'));
        }
    }else{
        $qry=sprintf('SELECT * FROM db_pacientes ORDER BY pac_cod DESC ');
    }
    return $qry;
    }
?>