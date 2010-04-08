<html>
<head>
<title>Login Failed</title>
</head>
<body>

<h1>Login Failed</h1>

<h3 style="color: red"><?=$error?></h3>

<p>New to MediaBorrow? please <?=anchor('signup', 'sign up' )?>.</p>

<p>Please reenter your information</p>
<?=form_open('login')?>
Username: <?=form_input('user_id', $user_id);?><br />
Password: <?=form_password('password');?><br />
<input type="submit" value="Sign in" />
</form>

</body>
</html>