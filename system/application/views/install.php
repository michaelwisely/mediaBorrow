<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Install Media Borrow</title>
	</head>
	<body>
		<h3>Before Media Borrow is installed, please enter the information for the first user to be added to the database.</h3>
		<?=form_open('install/do_install')?>
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
			
			for($i = 1900; $i <= date('Y'); $i++)
			{
				$year[$i] = $i;
			}

			?>
			Date of Birth: <?=form_dropdown('month', $month)?> <?=form_dropdown('day', $day)?> <?=form_dropdown('year', $year)?><br/>
			Zip: <?=form_input('zip');?><br />
			
			
			<input type="submit" value="Install MediaBorrow" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=site_url('')?>" style="color:red">cancel</a>
		</form>
	</body>
</html>
