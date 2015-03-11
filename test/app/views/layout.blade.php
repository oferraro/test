<!Doctype html>
<html>
	<head>
		<title>Header Text</title>
		
		<script type="text/javascript" src="<?php echo URL::to('/'); ?>/assets/js/jquery-last.min.js"></script>

		
		
	</head>
	<body>
		@yield ('content')
	</body>	
</html>
<script src="<?php echo URL::to('/'); ?>/assets/js/jquery-last.min.js"></script>
<script src="http://<?php echo $_SERVER('HTTP_HOST'); ?>:3000/socket.io/socket.io.js"></script>
<script>   
	var connectionStatus = false; 
		socket = io.connect("http://<?php echo $_SERVER('HTTP_HOST'); ?>:3000");
		socket.on("connect", function () {
			connectionStatus = true;
		});
		socket.on("mensaje_servidor", function (message) {
			var res = jQuery.parseJSON(message);
//			console.log(message + " change " + "#field_"+res.x+"_"+res.y + " to " + res.color);
			$("#field_"+res.x+"_"+res.y).removeClass();
			$("#field_"+res.x+"_"+res.y).addClass(res.color);
		});
	
function makeMove (userID, x, y) {
	$.ajax({
		type: "POST",
		url: "<?php echo URL::to('/'); ?>/connectfour/makeMove",
		async: false,
		data: { user: userID, xVal: x , yVal: y}
		})
		.done(function( msg ) {
			var res = jQuery.parseJSON(msg);
			$('#message').html ('');
			if (res.error == 1) {
				$('#message').html ('<span style="color:red">Error:</span> ');
			} else {
				if (user == 1) {
					color 	= 'red';
					remove 	= 'blue';
				} else {
					color 	= 'blue';
					remove 	= 'red';
				}
				$("#field_"+res.next+"_"+y).removeClass(remove);
				$("#field_"+res.next+"_"+y).addClass(color);
				
				var msg = JSON.stringify({"color":color,"x":res.next,"y":y});
				socket.emit("mensaje_cliente", msg);
			}
			$('#message').append (res.message);
			if (res.winner != 0) {
				$('#message').html ("<span style='color:green'>"+res.winner+"</span>");
			}
	});
}
	
<?php 
	if (isset($user)): ?>
		var user = '<?php echo $user; ?>';
		$('#board td').click(function () {
			var val = ($(this).attr('id'));
			val = val.replace('field_','');
			val = val.split('_');
			makeMove(user, val[0], val[1]);
//			console.log('send move ' + val[0] + ' ' + val[1]);
		}); 
<?php
	endif; ?>
</script>
