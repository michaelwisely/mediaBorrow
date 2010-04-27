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
	<title>Please Sign Up</title>
	
	<link href="<?=base_url().'css/main.css'?>" media="screen" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="<?=base_url().'js/jquery.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/jquery.validate.js'?>"></script>
	<script>
		$(document).ready(function(){
			$("#signup_form").validate({
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
		<span id="right">
			<?=form_open('login')?>
			<?php
				$user_id_field = array(
					'name' => 'user_id',
					'value' => 'username',
					'onfocus' => "if(this.value == 'username') this.value = '';",
					'onblur' => "if(this.value == '') this.value = 'username'"
				);
				$password_field = array(
					'name' => 'password',
					'value' => 'password',
					'onfocus' => "if(this.value == 'password') {this.value = ''; this.type='password'}",
					'onblur' => "if(this.value == '') {this.type='type'; this.value = 'password';}"
				);
			?>
			<?=form_input($user_id_field)?>&nbsp;
			<?=form_input($password_field)?>&nbsp;
			<input type="submit" value="Sign in" />
			</form>
		</span>
	</div>
</div>

<div id="container">
	<h1>Please Sign Up</h1>
	
	<h3 style="color:red"><?=$error?></h3>

	<?=form_open('signup', array('id' => 'signup_form'))?>
	<table>
		<tr>
			<td>Username:</td>
			<td><?=form_input(array('name' => 'user_id', 'value' => $user_id))?></td>
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
			<td><?=form_input(array('name' => 'fname', 'value' => $fname))?></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><?=form_input(array('name' => 'lname', 'value' => $lname))?></td>
		</tr>
		<tr>
			<td>Email Address:</td>
			<td><?=form_input(array('name' => 'email', 'value' => $email))?></td>
		</tr>
		<tr>
			<td>Date of Birth:</td>
			<td><?=form_dropdown('month', $months, $month)?> <?=form_dropdown('day', $days, $day)?> <?=form_dropdown('year', $years, $year)?></td>
		</tr>
		<tr>
			<td>Zip Code:</td>
			<td><?=form_input(array('name' => 'zip', 'value' => $zip))?></td>
		</tr>
		<tr>
			<td><input type="submit" value="Sign up" />&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>" style="color:red">cancel</a></td>
			<td></td>
		</tr>
	</table>
	</form>
</div>

</body>
</html>