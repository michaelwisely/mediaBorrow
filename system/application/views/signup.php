<html>
<head>
<title>Sign up on MediaBorrow</title>
</head>
<body>

<h1>Sign up on MediaBorrow!</h1>

<?=form_open('user/signup')?>
Username: <?=form_input('user_id');?><br />
Password: <?=form_password('password');?><br />
Repeat Password: <?=form_password('repeat_password');?><br />
<br />
First Name: <?=form_input('fname');?><br />
Last Name: <?=form_input('lname');?><br />
Email Address: <?=form_input('email');?><br />
<br/>
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

?>
Date of Birth: <?=form_dropdown('month', $month)?> <?=form_dropdown('day', $day)?> <?=form_input('year', 'year');?><br/>
City: <?=form_input('city');?><br />
State: <?=form_input('state');?><br />
Zip: <?=form_input('zip');?><br />
<input type="submit" value="Sign up" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=site_url('')?>" style="color:red">cancel</a>
</form>

</body>
</html>