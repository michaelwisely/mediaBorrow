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
			<?=form_input('user_id', 'username')?>&nbsp;
			<?=form_password('password', 'password')?>&nbsp;
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
