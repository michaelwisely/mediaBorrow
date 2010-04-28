<?=$this->load->view('header')?>
<div id="container">
	<h1>Hello, <?=$userData['fname']?></h1>
	<h2>Books:</h2>
	<?php foreach($books as $book):?>
		<li><?=$book['title']?></li>
	<?php endforeach;?>
</div>
</body>
</html>