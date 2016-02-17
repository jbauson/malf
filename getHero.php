<?php
function stripTojSon($json,$time){
	$jsonVar = "jsonp".$time."(";
	$json = str_replace($jsonVar,"",$json);
	$json = str_replace("})","}",$json);
	return json_decode($json,true);
}

function getHeroes($key,$city){
	getHero:
	$time = time();
	$var = @file_get_contents("http://159.203.92.38/server1/game/gen_conscribe_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&city=".$city."&action=gen_list&_l=en&_p=EW-DROID-KR-");
	if (!(strpos($var,'})') !== false)) {
		goto getHero;
	}
	$hero = stripTojSon($var,$time);
	echo json_encode($hero);
}

function getAllCity($key){
	start:
	$time = time();
	$var = @file_get_contents("http://159.203.92.38/server1/game/get_userinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&_l=en&_p=EW-DROID-KR-");
	if (!(strpos($var,'})') !== false)) {
	    goto start;
	}
	$city = stripTojSon($var,$time);
	if(count(@$city['ret']['user']['city'])>0){
		//for($ctr=0;$ctr<count($city['ret']['user']['city']);$ctr++){
			getHeroes($key,$city['ret']['user']['city'][0]['id']);
		//}
	}
}

getAllCity($_REQUEST['key']);
//echo json_encode($list);

?>