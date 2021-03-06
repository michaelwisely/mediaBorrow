<?php/*****************************************************************************
 *  installed.php
 *  
 *  A confirmation page for the first user who installs the system. Also sends
 *  back information to the install controller for the installation.
 *
 ****************************************************************************/?>

<head>
	<title>Installation Complete</title>
	
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
	<h1>Installation Complete</h1>
	<h3>MediaBorrow has been successfully installed at <span style="font-family:monospace"><?=base_url()?></span></h3>
	<h3>Please <?=anchor('login', 'login')?> as <?=$user_id?></h3>
</div>

</body>
</html>
