<html>
<head>
	<title><?=$title?></title>
	
	<link href="<?=base_url().'css/main.css'?>" media="screen" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="<?=base_url().'js/jquery.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/jquery.validate.js'?>"></script>
	
</head>
<body>

<div id="headerstrip">
	<div id="header">
		<h2><a href="<?=base_url()?>">MediaBorrow</a></h2>
		<span id="right">
			<?=anchor('logout', 'Logout')?>
		</span>
	</div>
</div>