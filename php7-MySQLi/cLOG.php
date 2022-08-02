<?php
//FUNCTION TO WRITE CONSOLE LOG DEBUG
//v.0.1 initial code
//v.0.2 change function name console_log to cLOG
function cLOG($data){//v.0.2 -> duotics_lib
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}
//USAGE
console_log('Mensaje a mostrar en consola de depuracion');
?>