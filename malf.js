function autovisit(key){
    $('#visit').html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
    setInterval(function(){
                $('#visit').html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
                $("#visit").load("doVisit.php?key="+key);
            },5000);
}
function autoarena(key,hero){
    $('#arena'+hero).attr( 'href','#');
    $('#arena'+hero).html('<img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
    setInterval(function(){
                $('#arena'+hero).html('<img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
                $('#arena'+hero).load("doArena.php?key="+key+"&hero="+hero);
                //console.log('Got it!');
            },5000);
}




function autovisity(key){
    $('#visit').html('<br/><br/><img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
    $("#visit").load("doVisit.php?key="+key);
}

function autoarenay(key,hero){
    $('#arena'+hero).attr( 'href','#');
    $('#arena'+hero).html('<img src="jquery/demos/css/themes/default/images/ajax-loader.gif">');
    $('#arena'+hero).load("doArena.php?key="+key+"&hero="+hero);
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
                        str += "<tr><td><img src=http://holycrusades.com/build/img/hero/"+data['ret']['hero'][ctr]['gid']+".jpg /></td><td>"+data['ret']['hero'][ctr]['g']+"</td><td>"+data['ret']['hero'][ctr]['p']+"</td><td>"+data['ret']['hero'][ctr]['i']+"</td><td>"+data['ret']['hero'][ctr]['c1']+"</td><td>"+data['ret']['hero'][ctr]['f']+"</td><td>"+data['ret']['hero'][ctr]['e']+"</td><td>"+data['ret']['hero'][ctr]['c2']+"</td><td><span id=\"arena"+ctr+"\"><a href=\"JavaScript:autoarena(\'"+key+"\',"+ctr+")\">AutoArena</a></span></td></tr>";
                    } 
                    str+="</table>";
                    $('#heroList').html(str);
                    $('#login').html('');
                    $('#response').text('')
                    $('#visit').html('<br/><br/><a href="JavaScript:autovisit(\''+key+'\')">AutoVisit</a><br/><br/><br/>');
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