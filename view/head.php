<?php
function head($title = '') {
  ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
  <html>
  <head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title><?php
  echo $title;
  ?></title>
  <link href="static/style.css" rel="stylesheet" media="screen" type="text/css" />
<script type="text/javascript" src="static/jquery-1.2.6.min.js"></script>	

<script type="text/javascript">

$(document).ready(function() {

	$("#loading").ajaxStart(function(){ $('#loading')[0].style.display = 'block' }).ajaxStop(function(){ $('#loading')[0].style.display = 'none' });
});

function delete_record( tableName, rowId){
	if(confirm('Are you sure you want to delete this row?')){
		$.get('dispatch.php', {action : "delete", table : tableName, id : rowId}, function(data){
			if( data.success == true ){
				location.reload(true);
			}else{
				alert(data.message);
			}
		},'json');
	}
}
$(document).ready(function() {
	setTimeout('$(".info").fadeOut("slow")',1000);
});

</script>

  </head>
  <body>
	<a href="."><img src="static/logo.png"/></a>
	
	<div id="loading" style="top:0; left:0; position:absolute;display:none; background:black; color:white; padding:2px">
	    Loading
	</div>
<?php
}
?>
