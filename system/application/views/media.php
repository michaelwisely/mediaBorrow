<?=$this->load->view('header')?>

<script>
	function showHide()
	{
		$('#comment_form').animate({
			height: 'toggle'
		}, 300);
	}
	$(document).ready(function(){
		$("#comment_form").validate({
			rules: {
				comment: "required"
			}
		});
	});
</script>


<div id="container">
	<div id="sidebar">
		<p>this is where we will indicate wether or not it is available for borrowing, borrow button, edit button, delete button, ETC.</p>
	</div>
	
	<div id="main">
		<h1><?=$media['title']?></h1>
		<h3><?=$media['type']?></h3>
		<p style="font-size:80%;"><strong>Genre:</strong> <?=$media['genre']?></p>
		<?php
		if($media['type'] == 'book')
		{
			if($media['author'] != '')
				echo '<p><strong>Author</strong>: '.$media['author'].'</p>';
			if($media['publisher'] != '')
				echo '<p><strong>Publisher</strong>: '.$media['publisher'].'</p>';
			if($media['ISBN'] != '')
				echo '<p><strong>ISBN</strong>: '.$media['ISBN'].'</p>';
		}
		elseif($media['type'] == 'movie')
		{
			if($media['writer'] != '')
				echo '<p><strong>Writer</strong>: '.$media['writer'].'</p>';
			if($media['director'] != '')
				echo '<p><strong>Director</strong>: '.$media['director'].'</p>';
		}
		else
		{
			if($media['artist'] != '')
				echo '<p><strong>Artist</strong>: '.$media['artist'].'</p>';
		}
		?>
		
		<br /><br /><br />
		
		<h2>Comments (<?=sizeOf($comments)?>) &nbsp;&nbsp;<span style="font-size:60%;"><a href="#" onClick="showHide(); return false;">Write Comment</a></span></h2>
		<?=form_open('comment', array('id' => 'comment_form', 'style' => 'display: none;'))?>
		<br />
		Rating: <?=form_dropdown('rating', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'))?>
		<br /><br />
		<?=form_textarea(array('name' => 'comment', 'style' => 'width: 400px; display: block;'))?>
		<?=form_hidden('media_id', $media['media_id'])?>
		<br />
		<input type="submit" value="Comment" />&nbsp;&nbsp;&nbsp;<a href="#" onClick="showHide(); return false;" style="color: red">cancel</a>
		</form>
		<br />
		<div id="comments">
			<?php foreach($comments as $comment): ?>
			<h4><?=$comment['comment']?></h4>
			<p><strong>Rating:</strong> <?=$comment['rating']?></p>
			<p>Posted by <?=anchor('profile/'.$comment['user_id'], $comment['user_id'])?> at <?=date('g:i a', $comment['time_stamp'])?> on <?=date('M j, Y')?>.</p>
			<br /><br />
			<?php endforeach; ?>
		</div>
		
	</div>
</div>
</body>
</html>