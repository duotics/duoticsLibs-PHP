<?php //SET OF FUNCTIONS TO MANAGE COOKIES
/* FUNCTION setCookieArray: Create or set value for a cookie
v.0.1 :: begin create function
v.0.2 :: add PARAM $cookieIDtoVAL
v.0.3 :: add CONDITION if $cookieName :: verify if the param $cookieName exists
*/
function setCookieArray($cookieName,$cookieID,$cookieVal,$cookieIDtoVAL=TRUE,$limitItems=100,$cookieTime){//v.0.3
	/*PARAMS
	$cookieName -> Name of the cookie to use
	$cookieVal -> ID (array) to set in a cookie
	$cookieVal -> Value to set in ID(array) in a cookie
	$cookieIDtoVAL -> define if it's TRUE the $cookieVal=$cookieID
	$limitItems -> Limit of items array to store in a cookie
	$cookieTime -> Time for the cookie expires :: 86400*30==2592000 -> 30 days is the DEFAULT VALUE
	*/
	if($cookieName){
		//verify is the cookie array exists
		if(array_key_exists($cookieName, $_COOKIE)) $cookie = unserialize($_COOKIE[$cookieName]); //Get the value of cookie in an array $cookie
		else $cookie = array();//Clean array

		if($cookieIDtoVAL==TRUE) $cookieVal=$cookieID;//BAN to set data  $cookieVal=$cookieID if is TRUE
		if($cookie[$cookieID] != $cookieVal){//if the value doesn't exist it will be stored in the cookie
			$Newcookie[$cookieID] = $cookieVal;//Set the new value in array $Newcookie
			$cookie=$Newcookie+$cookie;//Put the new value up to top of array, Combine arrays: $Newcookie+$cookie
			$salida = array_slice($cookie, 0, $limitItems,true);//Obtain only the Limit of items selected $limitItems
			$cookie = serialize($salida);//serialize cookie to store array
			if(!$cookieTime) $cookieTime=86400*30;
			if(setcookie($cookieName, $cookie, time()+$cookieTime)){//SET COOKIE 30 DAYS  ->  time()+(86400 * 30)
				$LOG.='Value set in Cookie<br>';
			}else $LOG.='Error Value no set in Cookie<br>';
		}else $LOG.='Values for cookie exists, not set<br>';
	}else $LOG.='No Cookie Selected<br>';
	return $LOG;//Return LOG of cookie
}
/* FUNCTION getCookieArray: Obtain value of a cookie
v.0.1 :: begin create function
*/
function getCookieArray($cookieName){//v.0.1
	//Verify if the cookie exists
	if (isset($_COOKIE[$cookieName])) $cookieFIN=unserialize($_COOKIE[$cookieName]);//unserialize cookie to obtain array
	return $cookieFIN;
}
/* FUNCTION delCookie: Delete a cookie
v.0.1 :: begin create function
*/
function delCookie($cookieName){//v.0.1
	unset($_COOKIE[$cookieName]);//UNSET COOKIE
	setcookie($cookieName, "", time() - 3600);//DELETE COOKIE
}
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