<?php //SET OF FUNCTIONS TO MANAGE COOKIES
/* FUNCTION setCookieArray: Create or set value for a cookie
v.0.1 :: begin create function
v.0.2 :: add PARAM $cookieIDtoVAL
v.0.3 :: add CONDITION if $cookieName :: verify if the param $cookieName exists
v.0.4 :: 20210406 :: in function "setCookieArray" define $LOG 
*/
//////////////////////////
/* BEG COOKIES FUNCTION v.0.4*/
function setCookieArray($cookieName,$cookieID,$cookieVal,$cookieIDtoVAL=TRUE,$limitItems=100,$cookieTime=NULL){//v.0.4
	$LOG=null;
	$LOG.= $cookieName.' - ';
	if(($cookieName)&&($cookieID)){
		if(array_key_exists($cookieName, $_COOKIE)) {
			$cookie = unserialize($_COOKIE[$cookieName]);
		} else {
			$cookie = array();
		}
		if($cookieIDtoVAL==TRUE) $cookieVal=$cookieID;
		if($cookie[$cookieID] != $cookieVal){
				$Newcookie[$cookieID] = $cookieVal;
				$cookie=$Newcookie+$cookie;
				$salida = array_slice($cookie, 0, $limitItems,true);   // devuelve "a", "b", y "c"
				$cookie = serialize($salida);
				if(!$cookieTime) $cookieTime=86400*30;
				if(setcookie($cookieName, $cookie, time()+$cookieTime,'/', ".mercoframes.com")){
					$LOG.='Value. '.$cookieID.' set in Cookie<br>';
				}else $LOG.='Error Value no set in Cookie<br>';
		}else $LOG.='Values for cookie exists, not set*<br>';
	}else $LOG.='No data for Cookie<br>';
	return $LOG;
}

function getCookieArray($cookieName,$limitItems=20){//v.0.4
	$cookieFIN=null;
	if (isset($_COOKIE[$cookieName])){
		$cookie=unserialize($_COOKIE[$cookieName]);
		$cookieFIN = array_slice($cookie, 0, $limitItems,true);
	}
	return $cookieFIN;
}
function delCookie($cookieName){//v.0.4
	unset($_COOKIE[$cookieName]);
	setcookie($cookieName, "", time() - (86400 * 30),'/', ".mercoframes.com");
}
/* END COOKIES FUNCTION */
//////////////////////////

?>
<?php /* HOW TO USE */ ?>
<div style="background: #ddd">
<div style="width: 50%; margin: 0 auto; padding: 10px; background: #fff">
	<?php
	
	$id=$_POST['id'];
	$val=$_POST['val'];
	$acc=$_POST['acc'];
	
	if($acc=='DEL'){
		delCookie('recViews');
	}else{
		if($id){
			echo '<p>RECEIVED VALUE. '.$id.'</p>';
			echo setCookieArray('recViews',$id,$val,FALSE,20);

		}else echo '<p>ONLY VIEW COOKIE recViews</p>';
	}
	//REVISION DE VALORES EN COOKIE
	$cookieView=getCookieArray('recViews');
	if($cookieView){
		foreach ($cookieView as $name => $value){
			echo "ID= $name :: Valor= $value <br />\n"; //right now just shows the posting_id
		}
	}
	
	?>
	<form action="#" method="post">
	<div style="background: eee; padding: 20px">
		<div style="margin: 10px 0;">
			<label for="id">ID para almacenar en Cookie</label>
			<input type="text" name="id" id="id" autofocus>
		</div>
		<div style="margin: 10px 0;">
			<label for="val">Valor para almacenar en Cookie</label>
			<input type="text" name="val" id="val" autofocus>
		</div>
		<div style="margin: 10px 0;">
			<button type="submit">ENVIAR</button>
		</div>
	</div>
	</form>
	<form action="test4.php" method="post">
	<div style="background: eee; padding: 20px">
		<div style="margin: 10px 0;">
			<button type="submit" name="acc" value="DEL">ELIMINAR COOKIE</button>
		</div>
	</div>
	</form>
</div>
</div>
<?php
var_dump($_COOKIE['recViews']);
?>
<script type="text/javascript">
	//SETEO LA COOKIE CON JS
	$.post("cookie.php", { cookieName: "recViews", cookieID: "<?php echo $dRSi['i_id'] ?>", cookieNum:20 }, 
	function(data){
		console.log(data.LOG);
	}, "json");
</script>