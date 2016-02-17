<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="jquery/demos/css/themes/default/jquery.mobile-1.4.5.min.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
<script src="jquery/demos/js/jquery.js"></script>
<script src="jquery/demos/_assets/js/index.js"></script>
<script src="jquery/demos/js/jquery.mobile-1.4.5.min.js"></script>
<script>
$(document).ready(
	$(function(){
	   setInterval(function(){$("#visit").load("doVisit.php")},1000);
	});
);

</script>
</head>
<body>
<center>
<div id="visit"></div>

</center>

</body>
</html>