<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="jquery/demos/css/themes/default/jquery.mobile-1.4.5.min.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
<script src="jquery/demos/js/jquery.js"></script>
<script src="jquery/demos/_assets/js/index.js"></script>
<script src="jquery/demos/js/jquery.mobile-1.4.5.min.js"></script>
<script>
function autovisit(key){
    $('#visit').html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
    setInterval(function(){
                $('#visit').html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
                $("#visit").load("doVisit.php?key="+key);
            },3000);
}

$(document).ready(function(){

    function loadAllHero(key){
        $.get("getHero.php",{key: key},
        function(data, status){
            if(status=="success"){
                data = JSON.parse(data);
                if(data['code']=="0"){
                    str = "<table border=1 cellpading=0 cellspacing=0><tr><th>Name</th><th>Level</th><th>Attack</th><th>Wisdom</th><th>Defense</th><th>Loyalty</th><th>Vigor</th><th>Maxtroop</th><th>Action</th></tr>";
                    for(ctr=0;ctr<data['ret']['hero'].length;ctr++){
                        //console.log(data['ret']['hero'][ctr]);
                        str += "<tr><td><img src=http://holycrusades.com/build/img/hero/"+data['ret']['hero'][ctr]['gid']+".jpg /></td><td>"+data['ret']['hero'][ctr]['g']+"</td><td>"+data['ret']['hero'][ctr]['p']+"</td><td>"+data['ret']['hero'][ctr]['i']+"</td><td>"+data['ret']['hero'][ctr]['c1']+"</td><td>"+data['ret']['hero'][ctr]['f']+"</td><td>"+data['ret']['hero'][ctr]['e']+"</td><td>"+data['ret']['hero'][ctr]['c2']+"</td><td><input type='button' value='Arena' data-enhanced='true'></td></tr>";
                    } 
                    str+="</table>";
                    $('#heroList').html(str);
                    $('#login').html('');
                    $('#response').text('')
                    $('#visit').html('<br/><br/><a href="JavaScript:autovisit(\''+key+'\')">AutoVisit</a>');
                }
            }
        });
    }



    $("button").click(function(){
        $.get("login.php",
    {
        uname: $('#username').val(),
        pass: $('#password').val()
    },
        function(data, status){
            if(status=="success"){
                data = JSON.parse(data);
                if(data['code']=="0"){
                    //console.log('jay');
                    loadAllHero(data['ret']['key']);
                }else{
                    $('#response').text('Invalid User or Password.')
                }
            }
        });
    });
});
</script>
</head>
<body>
<center>
<div id="login">
    <input type="text"  id="username" name="username" placeholder="Username"><br/>
    <input type="password" id="password" name="password" placeholder="Password"><br/>
    <button>Login</button>
</div>
<br/>
<div id="heroList"></div>
<div id="response"></div>
<div id="visit"></div>
</center>

</body>
</html>