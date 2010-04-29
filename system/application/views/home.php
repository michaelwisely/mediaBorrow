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
		This is where friend requests and borrow requests will be viewed.
	</div>
	
	<div id="main">
		<h1>Hello, <?=$userData['fname']?></h1>
		<h2>Your Media</h2>
		<h4><?=anchor('add/media', 'Add media')?></h4><br />
		<div class="selectors">
			<a href="#" class="selected">Books</a>
			<a href="#">Movies</a>
			<a href="#">CDs</a>
		</div>
		<div id="Books" class="type">
			<?php foreach($books as $book):?>
				<p><strong><?=$book['title']?></strong> - <?=anchor('media/edit/'.$book['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$book['media_id'], 'delete')?></p>
				<p><?php if($book['author'] != '') echo "By ".$book['author']; ?></p>
				<p><?=$book['genre']?></p>
				<p><?php if($book['publisher'] != '') echo "Published by ".$book['publisher']; ?></p>
				<p><?php if($book['ISBN'] != '') echo "ISBN: ".$book['ISBN']; ?></p>
				<br /><br />
			<?php endforeach;?>
		</div>
		<div id="Movies" class="type" style="display:none;">
			<?php foreach($movies as $movie):?>
				<p><strong><?=$movie['title']?></strong> - <?=anchor('media/edit/'.$movie['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$book['media_id'], 'delete')?></p>
				<p><?php if($movie['writer'] != '') echo "Written by ".$movie['writer']; ?></p>
				<p><?php if($movie['director'] != '') echo "Directed by ".$movie['director']; ?></p>
				<p><?=$movie['genre']?></p>
				<br /><br />
			<?php endforeach;?>
		</div>
		<div id="CDs" class="type" style="display:none;">
			<?php foreach($cds as $cd):?>
				<p><strong><?=$cd['title']?></strong> - <?=anchor('media/edit/'.$cd['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$book['media_id'], 'delete')?></p>
				<p><?php if($cd['artist'] != '') echo "By ".$cd['artist']; ?></p>
				<p><?=$cd['genre']?></p>
				<br /><br />
			<?php endforeach;?>
		</div>
		

	</div>
</div>
</body>
</html>