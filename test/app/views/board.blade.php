@extends('layout')

@section('content')
<h1>Connect Four</h1>
<a onClick="return confirm('Do you want to resign?')" href="<?php echo URL::to('/'); ?>/resetgame">resetgame</a><br>
<?php 
	if (isset($user)): ?>
		<span style="color: <?php echo ($user==1)?'red':'blue'; ?>">User</span>: <?php echo $user; ?> (change <a href="<?php echo URL::to('/'); ?>/connectfour">user</a> )
<?php 
	else:?>
		Your session expired, choose your <a href="<?php echo URL::to('/'); ?>/connectfour">user</a> to continue.
<?php
	endif; ?><br><br>
	<div id="message"></div>
	<br><br>
	
<table border=1 id="board">
<tr>
	<th></th><th>0</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th>
</tr>
<?php 
	for ($i= 0; $i< 10; $i++): ?>
		<th><?php echo $i; ?></th>
<?php
		for ($j=0; $j<10; $j++): ?>
		<td style="width: 20px; height; 20px;" class="<?php
			switch ($board[$i][$j]):
				case 1:
					echo "red";
					break;
				case 2:
					echo "blue";
					break;
			endswitch;
		?>" id="field_<?php echo $i."_".$j; ?>">&nbsp;</td>
<?php
		endfor; ?>
	</tr>
<?php
	endfor; ?>
</table>
@stop

<style>

.red {
	background: red;
}

.blue {
	background: blue;
}

</style>
