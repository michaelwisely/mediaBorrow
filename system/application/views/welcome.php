<html>
<head>
<title>Welcome to MediaBorrow</title>
</head>
<body>

<h1>Welcome to MediaBorrow!</h1>

<p>New to MediaBorrow? please <?=anchor('signup', 'sign up' )?>.</p>

<p>Or, please sign in:</p>
<?=form_open('login')?>
Username: <?=form_input('user_id');?><br />
Password: <?=form_password('password');?><br />
<input type="submit" value="Sign in" />
</form>

</body>
</html>