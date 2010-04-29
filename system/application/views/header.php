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
			<?=anchor('profile', 'Profile')?>
			&nbsp;&nbsp;&nbsp;
			<?=anchor('account/edit', 'Account')?>
			&nbsp;&nbsp;&nbsp;
			<?=anchor('logout', 'Logout')?>
			&nbsp;&nbsp;&nbsp;
			<?php
				echo form_open('search/media', array('style'=>'display:inline;'));
				$search_form = array(
					'name' => 'search',
					'value' => 'search media...',
					'onfocus' => "if(this.value == 'search media...') this.value = '';",
					'onblur' => "if(this.value == '') this.value = 'search media...'"
				);
				echo form_input($search_form);
			?>
			</form>
		</span>
	</div>
</div>