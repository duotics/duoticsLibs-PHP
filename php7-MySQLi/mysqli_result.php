<?php /*
La clase mysqli_result
Representa el conjunto de resultados obtenidos a partir de una consulta en la base de datos.
source. http://php.net/manual/es/class.mysqli-result.php
Note. reemplaza mysql_result debido a que mysql se va a volver obsoleta
*/
//v.0.1 -> initial code
function mysqli_result($res, $row, $field=0){//v.0.1 -> duotics_lib
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
?>