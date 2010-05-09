<?php /*****************************************************************************
 *  signed_up.php
 *  
 *  confirmation page for a user who has just signed up. sends information back
 *  to User controller to add infomation to the database.
 *
 ****************************************************************************/?>

<html>

<head>
	<title>Signup Successful</title>
	
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
	<h1>Signup Successful</h1>
	<h3>Please <?=anchor('login', 'login')?> as <?=$user_id?></h3>
</div>

<?$this->load->view('footer')?>
