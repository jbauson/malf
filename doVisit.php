<?php
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
	echo "Claimed";
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
echo "<br /><table><tr><td>";
$ar = explode(",",$getList['ret']['visited_list']);
for($jay=0;$jay<count($ar);$jay++){
	$tmp = explode("|",$ar[$jay]);
	//print_r($tmp);
	# http://holycrusades.com/build/img/hero/b4.png
	echo "<img src='http://holycrusades.com/build/img/hero/".$tmp[0].".jpg'/>&nbsp";
	echo "<img src='http://holycrusades.com/build/img/hero/".$tmp[1].$tmp[2].".png'/>";
	echo "<br/>";
}
echo "</td></tr></table>";

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

?>