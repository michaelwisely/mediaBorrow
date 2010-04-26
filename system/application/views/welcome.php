<html>

<head>
	<title>Welcome to MediaBorrow!</title>
	
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
	<h1>Welcome to MediaBorrow!</h1>

	<h3>New to MediaBorrow? please <?=anchor('signup', 'sign up' )?>.</h3>

	<p>Say you want to read a book, watch a movie, or listen to a CD, but you don't have it. You'd rather not buy it, the library doesn't have it in, and you don't want to sequentially call 30 friends to ask if they have it. Enter MediaBorrow (name tentative). MediaBorrow is a site where you can list all of your books, movies, and CDs, and view all of your friends' media. They have something you want? Ask to borrow it. They will be notified, and if they want to, they can lend you the book or Movie in the real world, all the while MediaBorrow keeps track of the transaction. Now, you will always have access to all the books, movies, and CDs you want, and simultaneously keep track of who has yours.</p>
</div>

</body>
</html>