<?php
function stripTojSon($json,$time){
	$jsonVar = "jsonp".$time."(";
	$json = str_replace($jsonVar,"",$json);
	$json = str_replace("})","}",$json);
	return json_decode($json,true);
}

function login($userName,$password){
	start:
	$time = time();
	$var = @file_get_contents("http://159.203.92.38/server1/game/login_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&username=".urlencode($userName)."&password=".urlencode($password)."&picture=&session=temp&_l=en&_p=EW-DROID-KR-");
	if (!(strpos($var,'})') !== false)) {
	    goto start;
	}
	$key = stripTojSon($var,$time);
	return $key;
}

$key = login($_REQUEST['uname'],$_REQUEST['pass']);
echo json_encode($key);




?>