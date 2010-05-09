<?php /*****************************************************************************
 *  media_list.php
 *  
 *  Lists media according to the type. This view is used by the User controller
 *  for the user's home page and profile, it is also used for the search page.
 *
 ****************************************************************************/?>

<?php $this->load->helper('friendship'); ?>
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
		<p><?php $uid = $this->session->userdata('user_id');?>
			<?php if (areFriends($uid, $book['user_id']) || $uid == $book['user_id']): ?>
			<strong><?=anchor('media/view/'.$book['media_id'], $book['title'])?></strong>
			<?php else: ?>
			<strong><?=$book['title']?></strong>
			<?php endif; ?>
			<?php if($this->session->userdata('user_id') == $book['user_id']): ?>
			 - <?=anchor('media/edit/'.$book['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$book['media_id'], 'delete')?>
			<?php else: ?>
			<?php if(!$profile) echo ' - belongs to '.anchor('profile/'.$book['user_id'], $book['user_id']); ?>
			<?php endif; ?>
		</p>
		<p><?php if($book['author'] != '') echo "By ".$book['author']; ?></p>
		<p><?=$book['genre']?></p>
		<p><?php if($book['publisher'] != '') echo "Published by ".$book['publisher']; ?></p>
		<p><?php if($book['ISBN'] != '') echo "ISBN: ".$book['ISBN']; ?></p>
		<p><?php if($book['rating'] != '') echo "Rating: ".$book['rating']; ?></p>
		<br /><br />
	<?php endforeach;?>
</div>
<div id="movielist" class="type" style="display:none;">
	<?php if(sizeof($movies) == 0) echo "No movies"; ?>
	<?php foreach($movies as $movie):?>
		<p><?php $uid = $this->session->userdata('user_id');?>
			<?php if (areFriends($uid, $movie['user_id']) || $uid == $movie['user_id']): ?>
			<strong><?=anchor('media/view/'.$movie['media_id'], $movie['title'])?></strong>
			<?php else: ?>
			<strong><?=$movie['title']?></strong>
			<?php endif; ?>
			<?php if($this->session->userdata('user_id') == $movie['user_id']): ?>
			 - <?=anchor('media/edit/'.$movie['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$movie['media_id'], 'delete')?>
			<?php else: ?>
			<?php if(!$profile) echo ' - belongs to '.anchor('profile/'.$movie['user_id'], $movie['user_id']); ?>
			<?php endif; ?>
		</p>
		<p><?php if($movie['writer'] != '') echo "Written by ".$movie['writer']; ?></p>
		<p><?php if($movie['director'] != '') echo "Directed by ".$movie['director']; ?></p>
		<p><?=$movie['genre']?></p>
		<p><?php if($movie['rating'] != '') echo "Rating: ".$movie['rating']; ?></p>
		<br /><br />
	<?php endforeach;?>
</div>
<div id="cdlist" class="type" style="display:none;">
	<?php if(sizeof($cds) == 0) echo "No CDs"; ?>
	<?php foreach($cds as $cd):?>
		<p><?php $uid = $this->session->userdata('user_id');?>
			<?php if (areFriends($uid, $cd['user_id']) || $uid == $cd['user_id']): ?>
			<strong><?=anchor('media/view/'.$cd['media_id'], $cd['title'])?></strong>
			<?php else: ?>
			<strong><?=$cd['title']?></strong>
			<?php endif; ?>
			<?php if($this->session->userdata('user_id') == $cd['user_id']): ?>
			 - <?=anchor('media/edit/'.$cd['media_id'], 'edit')?>&nbsp;&nbsp;<?=anchor('media/delete/'.$cd['media_id'], 'delete')?>
			<?php else: ?>
			<?php if(!$profile) echo ' - belongs to '.anchor('profile/'.$cd['user_id'], $cd['user_id']); ?>
			<?php endif; ?>
		</p>
		<p><?php if($cd['artist'] != '') echo "By ".$cd['artist']; ?></p>
		<p><?=$cd['genre']?></p>
		<p><?php if($cd['rating'] != '') echo "Rating: ".$cd['rating']; ?></p>
		<br /><br />
	<?php endforeach;?>
</div>