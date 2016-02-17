<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="jquery/demos/css/themes/default/jquery.mobile-1.4.5.min.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
<script src="jquery/demos/js/jquery.js"></script>
<script src="jquery/demos/_assets/js/index.js"></script>
<script src="jquery/demos/js/jquery.mobile-1.4.5.min.js"></script>
<style type="text/css">
table{color:#333;font-family:Helvetica,Arial,sans-serif;width:640px;border-collapse:collapse;border-spacing:0}td,th{border:1px solid transparent;height:30px;transition:all .3s}th{background:#DFDFDF;font-weight:700}td{background:#FAFAFA;text-align:center}tr:nth-child(even) td{background:#F1F1F1}tr:nth-child(odd) td{background:#FEFEFE}
</style>
<script>
function autovisit(t){$("#visit").html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">'),setInterval(function(){$("#visit").html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">'),$("#visit").load("doVisit.php?key="+t)},5e3)}function autoarena(t,e){$("#arena"+e).attr("href","#"),$("#arena"+e).html('<img src="jquery/demos/css/themes/default/images/ajax-loader.gif">'),setInterval(function(){$("#arena"+e).html('<img src="jquery/demos/css/themes/default/images/ajax-loader.gif">'),$("#arena"+e).load("doArena.php?key="+t+"&hero="+e)},5e3)}function autovisity(t){$("#visit").html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">'),$("#visit").load("doVisit.php?key="+t)}function autoarenay(t,e){$("#arena"+e).attr("href","#"),$("#arena"+e).html('<img src="jquery/demos/css/themes/default/images/ajax-loader.gif">'),$("#arena"+e).load("doArena.php?key="+t+"&hero="+e)}$(document).ready(function(){function t(t){$.get("getHero.php",{key:t},function(e,r){if("success"==r&&(e=JSON.parse(e),"0"==e.code)){for(str="<table border=1 cellpading=0 cellspacing=0><tr><th>Name</th><th>Level</th><th>Attack</th><th>Wisdom</th><th>Defense</th><th>Loyalty</th><th>Vigor</th><th>Maxtroop</th><th>Action</th></tr>",ctr=0;ctr<e.ret.hero.length;ctr++)str+="<tr><td><img src=http://holycrusades.com/build/img/hero/"+e.ret.hero[ctr].gid+".jpg /></td><td>"+e.ret.hero[ctr].g+"</td><td>"+e.ret.hero[ctr].p+"</td><td>"+e.ret.hero[ctr].i+"</td><td>"+e.ret.hero[ctr].c1+"</td><td>"+e.ret.hero[ctr].f+"</td><td>"+e.ret.hero[ctr].e+"</td><td>"+e.ret.hero[ctr].c2+'</td><td><span id="arena'+ctr+'"><a href="JavaScript:autoarena(\''+t+"',"+ctr+')">AutoArena</a></span></td></tr>';str+="</table>",$("#heroList").html(str),$("#login").html(""),$("#response").text(""),$("#visit").html("<br/><br/><a href=\"JavaScript:autovisit('"+t+"')\">AutoVisit</a><br/><br/><br/>")}})}$("button").click(function(){$.get("login.php",{uname:$("#username").val(),pass:$("#password").val()},function(e,r){"success"==r&&(e=JSON.parse(e),"0"==e.code?t(e.ret.key):$("#response").text("Invalid User or Password."))})})});
</script>
</head>
<body>
<center>
<div id="login"><br/><br/><br/>
    <input type="text"  id="username" name="username" placeholder="Username"><br/>
    <input type="password" id="password" name="password" placeholder="Password"><br/>
    <button>Login</button>
</div>
<br/>
<div id="heroList"></div>
<div id="response"></div>
<div id="visit"></div>
</center>
<br><br>
<center><img src="http://www.reliablecounter.com/count.php?page=52.35.48.228/&digit=style/plain/3/&reloads=0" alt="" title="" border="0">
</center>

</body>
</html>