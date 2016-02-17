<?php
function d($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	die();
}

function stripTojSon($json,$time){
	$jsonVar = "jsonp".$time."(";
	$json = str_replace($jsonVar,"",$json);
	$json = str_replace("})","}",$json);
	return json_decode($json,true);
}
$key = $_REQUEST['key'];
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


########################################################################################################################


getList:
$time = time();
$var = @file_get_contents("http://159.203.92.38/server1/game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&_l=en&_p=EW-DROID-KR-");
if (!(strpos($var,'})') !== false)) {
	goto getList;
}

$getList = stripTojSon($var,$time);

#########################################################################################################################

$visitedList = explode(",",$getList['ret']['visited_list']);
#Auto Claim 5 the same hero
if(count($visitedList)==5){
	start:
	$time = time();
	$var = @file_get_contents("http://159.203.92.38/server1/game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&action=getprice&price_type=5_same&_l=en&_p=RE");
	if (!(strpos($var,'})') !== false)) {
	    goto start;
	}
	//echo "Claimed";
}
###########################################################################################################################

# Get the hero list that a player can visit
$genList = explode(",",$getList['ret']['can_visit_list']);
for($ctr=0;$ctr<count($genList);$ctr++){
	if (strpos($genList[$ctr],"b") !== false) {
		visit:
		$time = time();
		$var = @file_get_contents("http://159.203.92.38/server1/game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&action=visit&visit_gen=".($ctr+1)."&city=".$city."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto visit;
		}
		break;
	}
}
#echo "here";
#############################################################################################################################

refresh:
$time = time();
$var = @file_get_contents("http://159.203.92.38/server1/game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&action=refresh_time&_l=en&_p=EW-DROID-KR-");
if (!(strpos($var,'})') !== false)) {
    goto refresh;
}
##################################################################################
//echo $getList['ret']['visited_list'];
echo "<br /><table><tr>";
//print_r($getList['ret']['can_visit_list']);
echo "<br/>";

$cvl = explode(",",$getList['ret']['can_visit_list']);
for($jay=0;$jay<count($cvl);$jay++){
	$tmp = explode("|",$cvl[$jay]);
echo "<img src=\"http://holycrusades.com/build/img/hero/".$tmp[1].$tmp[2].".png\"/>&nbsp;&nbsp;";
}

echo "<br/>";
if(strlen(trim($getList['ret']['visited_list']))>0){
	$vl = explode(",",$getList['ret']['visited_list']);
}
else{
	$vl = 0;
}

$total=0;
if($vl!=0){
	for($jay=0;$jay<count($vl);$jay++){
		$tmp = explode("|",$vl[$jay]);
	echo "<img src=\"http://holycrusades.com/build/img/hero/".$tmp[1].$tmp[2].".png\"/>&nbsp;&nbsp;";
		$total++;
	}
}
if($total==5){echo "<br/>Claimed!";}



#if((strpos($getList['ret']['visited_list'],',,') !== false)){
if(substr($getList['ret']['visited_list'], -1 )==","){
	clear:
	$time = time();
	$var = @file_get_contents("http://159.203.92.38/server1/game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&action=clear&_l=en&_p=EW-DROID-KR-");
	if (!(strpos($var,'})') !== false)) {
	    goto clear;
	}
	echo "Cleared";
}

if (strpos($getList['ret']['visited_list'],'a') !== false) {
	goto clear;
	}
if (strpos($getList['ret']['visited_list'],'c') !== false) {
	goto clear;
	}
if (strpos($getList['ret']['visited_list'],'d') !== false) {
	goto clear;
	}
if (strpos($getList['ret']['visited_list'],'e') !== false) {
	goto clear;
	}


//d($_SERVER);
//die("Location: ".$_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI']);
//header("Refresh: 5; URL=http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
//header("Location: http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
?>