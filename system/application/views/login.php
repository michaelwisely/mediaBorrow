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
			<?=form_input('user_id', 'username')?>&nbsp;
			<?=form_password('password', 'password')?>&nbsp;
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

</body>
</html>