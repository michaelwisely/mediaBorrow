<script>
	$(document).ready(function(){
		$(".selectors > a").click(function(event){
			$(".selectors > a").removeClass("selected");
			$(this).addClass("selected");

			$(".type").hide();
			$("#"+$(this).attr('id')+'list').show();
			
			return false;
		});
	});
</script>
<div class="selectors">
	<a href="#" id="book" class="selected">Books (<?=sizeof($books)?>)</a>
	<a href="#" id="movie">Movies (<?=sizeof($movies)?>)</a>
	<a href="#" id="cd">CDs (<?=sizeof($cds)?>)</a>
</div>
<div id="booklist" class="type">
	<?php if(sizeof($books) == 0) echo "No books"; ?>
	<?php foreach($books as $book):?>
		<p><strong><?=$book['title']?></strong> - 
			<?php if((!isset($book['thisUser'])) || $book['thisUser']): ?>
			<?=anchor('media/edit/'.$book['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$book['media_id'], 'delete')?>
			<?php else: ?>
			belongs to <?=$book['user_id']?> <?=anchor('media/borrow/'.$book['media_id'], 'borrow')?>
			<?php endif; ?>
		</p>
		<p><?php if($book['author'] != '') echo "By ".$book['author']; ?></p>
		<p><?=$book['genre']?></p>
		<p><?php if($book['publisher'] != '') echo "Published by ".$book['publisher']; ?></p>
		<p><?php if($book['ISBN'] != '') echo "ISBN: ".$book['ISBN']; ?></p>
		<br /><br />
	<?php endforeach;?>
</div>
<div id="movielist" class="type" style="display:none;">
	<?php if(sizeof($movies) == 0) echo "No movies"; ?>
	<?php foreach($movies as $movie):?>
		<p><strong><?=$movie['title']?></strong> - 
			<?php if((!isset($movie['thisUser'])) || $movie['thisUser']): ?>
			<?=anchor('media/edit/'.$movie['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$movie['media_id'], 'delete')?>
			<?php else: ?>
			belongs to <?=$movie['user_id']?> <?=anchor('media/borrow/'.$movie['media_id'], 'borrow')?>
			<?php endif; ?>
		</p>
		<p><?php if($movie['writer'] != '') echo "Written by ".$movie['writer']; ?></p>
		<p><?php if($movie['director'] != '') echo "Directed by ".$movie['director']; ?></p>
		<p><?=$movie['genre']?></p>
		<br /><br />
	<?php endforeach;?>
</div>
<div id="cdlist" class="type" style="display:none;">
	<?php if(sizeof($cds) == 0) echo "No CDs"; ?>
	<?php foreach($cds as $cd):?>
		<p><strong><?=$cd['title']?></strong> - 
			<?php if((!isset($cd['thisUser'])) || $cd['thisUser']): ?>
			<?=anchor('media/edit/'.$cd['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$cd['media_id'], 'delete')?>
			<?php else: ?>
			belongs to <?=$cd['user_id']?> <?=anchor('media/borrow/'.$cd['media_id'], 'borrow')?>
			<?php endif; ?>
		</p>
		<p><?php if($cd['artist'] != '') echo "By ".$cd['artist']; ?></p>
		<p><?=$cd['genre']?></p>
		<br /><br />
	<?php endforeach;?>
</div>