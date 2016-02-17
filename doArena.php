<?php

function stripTojSon($json,$time){
	$jsonVar = "jsonp".$time."(";
	$json = str_replace($jsonVar,"",$json);
	$json = str_replace("})","}",$json);
	return json_decode($json,true);
}



function addVigor($id,$key,$city){
	addVigor:
	$time = time();
	$var = @file_get_contents("http://159.203.92.38/server1/game/my_gen_mod_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&id=".$id."&action=energy&city=".$city."&itemid=82&_l=en&_p=EW-DROID-KR-");
	if (!(strpos($var,'})') !== false)) {
		goto addVigor;
	}
}



$key  = $_REQUEST['key'];
$hero = $_REQUEST['hero'];
#Get City 1
# http://159.203.92.38/server1/game/get_userinfo_api.php?jsonpcallback=jsonp1455671957624&_=1455671978275&key=f087efde338f61ecd58cc409c8d4807a&_l=en&_p=EW-DROID-KR-

getCity:
$time = time();
$var = @file_get_contents("http://159.203.92.38/server1/game/get_userinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&_l=en&_p=EW-DROID-KR-");
if (!(strpos($var,'})') !== false)) {
	goto getCity;
}

$getCity = stripTojSon($var,$time);
if($getCity['code']==2){
	//header('Location: '.$_SERVER['HTTP_REFERER']);
	//print_r($_SERVER);die();
	echo "<script>window.location.href=window.location.href</script>";
}

$city = $getCity['ret']['user']['city'][0]['id'];


########################################################



getHero:
$time = time();
$var = @file_get_contents("http://159.203.92.38/server1/game/gen_conscribe_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&city=".$city."&action=gen_list&_l=en&_p=EW-DROID-KR-");
if (!(strpos($var,'})') !== false)) {
	goto getHero;
}

$getHero = stripTojSon($var,$time);
//print_r($getHero['ret']['hero'][$hero]);die();
$ex	=	$getHero['ret']['hero'][$hero]['ex'];
$te	=	$getHero['ret']['hero'][$hero]['te'];
$id	=	$getHero['ret']['hero'][$hero]['id'];
$vigor =	$getHero['ret']['hero'][$hero]['e'];




getOpponent:
$time = time();
$var = @file_get_contents("http://159.203.92.38/server1/game/gen_conscribe_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&lv=".$getHero['ret']['hero'][$hero]['g']."&_l=en&_p=EW-DROID-KR-");
if (!(strpos($var,'})') !== false)) {
	goto getOpponent;
}

$getOpponent = stripTojSon($var,$time);

//d($getOpponent);

$jay=0;
for($ctr=0;$ctr<count($getOpponent);$ctr++){

	if($getOpponent['ret']['hero'][$ctr]['g']>=$getHero['ret']['hero'][$hero]['g']){

		fight:
		$time = time();
		$var = @file_get_contents("http://159.203.92.38/server1/game/gen_conscribe_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&gid=".$getHero['ret']['hero'][$hero]['id']."&tgid=".$getOpponent['ret']['hero'][$ctr]['id']."&_l=en&_p=EW-DROID-KR-");
		if (!(strpos($var,'})') !== false)) {
			goto fight;
		}
		
		$result = stripTojSon($var,$time);


		# Get Vigor
		//sleep(2);
		//print_r($result);die();
		if(@$result['code']=="8303"){
			addVigor($id,$key,$city);
			//echo "Vigor";
			goto fight;
		}
		if(@$result['ret']['win']>0){
			echo "W1n!";
		}else{echo "Lose!<br>";}

		/*
		$ex = $ex+$result['ret']['exp'];

		if($ex>$te){goto getHero;}

		if(@$result['ret']['win']>0){
			echo ($jay++)." ".$getHero['ret']['hero'][$hero]['g']." ".
			$ex." ".
			$te."\n";
			goto fight;
		}else{echo "Owned!";}
		*/
		break;
	}
}
//header("Refresh: 5; URL=http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
?>