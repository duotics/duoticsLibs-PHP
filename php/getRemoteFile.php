<?php //ALTERNATIVE TO file_get_content
function getRemoteFile($url, $timeout = 10) {
  $ch = curl_init();
  curl_setopt ($ch, CURLOPT_URL, $url);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $file_contents = curl_exec($ch);
  curl_close($ch);
  return ($file_contents) ? $file_contents : FALSE;
}

?>