<?php
$months = array(
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
	$days[$i+1] = $i+1; 
}

for($i = 1900; $i <= date('Y'); $i++)
{
	$years[$i] = $i;
}

?>


<html>

<head>
	<title>Install MediaBorrow</title>
	
	<link href="<?=base_url().'css/main.css'?>" media="screen" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="<?=base_url().'js/jquery.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/jquery.validate.js'?>"></script>
	<script>
		$(document).ready(function(){
			$("#install_form").validate({
				rules: {
					user_id: "required",
					password: "required",
					repeat_password: {
						equalTo: "#password"
					},
					fname: "required",
					lname: "required",
					email: {
						required: true,
						email: true
					},
					zip: {
						required: true,
						minlength: 5,
						maxlength: 5,
						digits: true
					}
				},
				messages: {
					zip: "must be a 5 digit zip code"
				}
			});
		});
	</script>
	
</head>
<body>

<div id="headerstrip">
	<div id="header">
		<h2><a href="<?=base_url()?>">MediaBorrow</a></h2>
	</div>
</div>

<div id="container">
	<h1>Install MediaBorrow</h1>
	<h3>Before Media Borrow is installed, please enter the information for the first user to be added to the database.</h3>
	<?=form_open('install/do_install', array('id' => 'install_form'))?>
	<table>
		<tr>
			<td>Username:</td>
			<td><?=form_input('user_id')?></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><?=form_password(array('name' => 'password', 'id' => 'password'))?></td>
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
			<td><?=form_dropdown('month', $months)?> <?=form_dropdown('day', $days)?> <?=form_dropdown('year', $years)?></td>
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
