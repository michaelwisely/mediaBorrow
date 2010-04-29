<?=$this->load->view('header')?>

<script>
	$(document).ready(function(){
		$(".selectors > a").click(function(event){
			$(".selectors > a").removeClass("selected");
			$(this).addClass("selected");
			
			$(".type").hide();
			$("#"+$(this).html()).show();
			
			
			
			return false;
		});
	});
</script>

<div id="container">
	<div id="sidebar">
		sdf
		sdf
	</div>
	
	<div id="main">
		<h1>Hello, <?=$userData['fname']?></h1>
		<h2>Your Media</h2>
		<div class="selectors">
			<a href="#" class="selected">Books</a>
			<a href="#">Movies</a>
			<a href="#">CDs</a>
		</div>
		<div id="Books" class="type">
			<?php foreach($books as $book):?>
				<p><?=$book['title']?> - <?=anchor('media/delete/'.$book['media_id'], 'delete')?></p>
			<?php endforeach;?>
		</div>
		<div id="Movies" class="type" style="display:none;">
			<?php foreach($movies as $movie):?>
				<li><?=$movie['title']?></li>
			<?php endforeach;?>
		</div>
		<div id="CDs" class="type" style="display:none;">
			<?php foreach($cds as $cd):?>
				<li><?=$cd['title']?></li>
			<?php endforeach;?>
		</div>
		

	</div>
</div>
</body>
</html>