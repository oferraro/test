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
<script>
	
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
				$('#message').html ('<div style="color:red">Error:</div>');
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
			console.log('send move ' + val[0] + ' ' + val[1]);
		}); 
<?php
	endif; ?>
</script>
