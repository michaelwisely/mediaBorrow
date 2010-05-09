<?php /*****************************************************************************
 *  login.php
 *  
 *  Displays a login page for users to log into the system.
 *
 ****************************************************************************/?>

<html>

<head>
	<title>Please Login</title>
	
	<link href="<?=base_url().'css/main.css'?>" media="screen" rel="stylesheet" type="text/css" />
	
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
	<h1>Please Login</h1>

	<h3 style="color: red"><?=$error?></h3>

	<p>New to MediaBorrow? please <?=anchor('signup', 'sign up' )?>.</p>
	<?=form_open('login')?>
	<table>
		<tr>
			<td>Username:</td>
			<td><?=form_input('user_id', $user_id)?></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><?=form_password('password');?></td>
		</tr>
		<tr>
			<td><input type="submit" value="Login" /></td>
			<td></td>
		</tr>
	</table>
	</form>
</div>

<?$this->load->view('footer')?>