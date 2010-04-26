<?php
$month = array(
			'01' => 'Jan',
			'02' => 'Feb',
			'03' => 'Mar',
			'04' => 'Apr',
			'05' => 'May',
			'06' => 'Jun',
			'07' => 'Jul',
			'08' => 'Aug',
			'09' => 'Sep',
			'10' => 'Oct',
			'11' => 'Nov',
			'12' => 'Dec',
			);
		
for ($i = 0; $i < 31; $i++)
{
	$day[$i] = $i+1; 
}

for($i = 1900; $i <= date('Y'); $i++)
{
	$year[$i] = $i;
}

?>

<html>

<head>
	<title>Please Sign Up</title>
	
	<link href="<?=base_url().'css/main.css'?>" media="screen" rel="stylesheet" type="text/css" />
	
</head>
<body>

<div id="headerstrip">
	<div id="header">
		<h2><a href="<?=base_url()?>">MediaBorrow</a></h2>
		<span id="right">
			<?=form_open('login')?>
			<?=form_input('user_id', 'username')?>&nbsp;
			<?=form_password('password', 'password')?>&nbsp;
			<input type="submit" value="Sign in" />
			</form>
		</span>
	</div>
</div>

<div id="container">
	<h1>Please Sign Up</h1>
	
	<h3 style="color:red"><?=$error?></h3>

	<?=form_open('user/signup')?>
	<table>
		<tr>
			<td>Username:</td>
			<td><?=form_input('user_id')?></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><?=form_input('genre');?></td>
		</tr>
		<tr>
			<td>Repeat Password:</td>
			<td><?=form_password('repeat_password')?></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><?=form_input('fname')?></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><?=form_input('lname')?></td>
		</tr>
		<tr>
			<td>Email Address:</td>
			<td><?=form_input('email')?></td>
		</tr>
		<tr>
			<td>Date of Birth:</td>
			<td><?=form_dropdown('month', $month)?> <?=form_dropdown('day', $day)?> <?=form_dropdown('year', $year)?></td>
		</tr>
		<tr>
			<td>Zip Code:</td>
			<td><?=form_input('zip');?></td>
		</tr>
		<tr>
			<td><input type="submit" value="Sign up" />&nbsp;&nbsp;&nbsp;<a href="#" style="color:red">cancel</a></td>
			<td></td>
		</tr>
	</table>
	</form>
</div>

</body>
</html>