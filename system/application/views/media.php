<?php /*****************************************************************************
 *  media.php
 *  
 *  This view shows details for a single piece of media. Called by Media controller.
 *
 ****************************************************************************/?>

<?=$this->load->view('header')?>

<script type="text/javascript" src="<?=base_url().'js/jquery.scrollTo.js'?>"></script>
<script type="text/javascript">
	var commentVisible=new Boolean(false);
	
	function showHide()
	{
		$('#comment_form').animate({
			height: 'toggle'
		}, 300);
		commentVisible = ~commentVisible;
	}
	
	function editButton()
	{
		if(commentVisible == false)
		{
			showHide();
		}
		$.scrollTo($('#comment_form'), 350);
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
		<?php if($this->session->userdata('user_id') == $media['user_id']): ?>
			<p><?=anchor('media/edit/'.$media['media_id'], 'edit')?></p>
			<p><?=anchor('media/delete/'.$media['media_id'], 'delete')?></p>
		<?php else: ?>
			<p><?=anchor('borrow/request/'.$media['media_id'], 'request to borrow this '.$media['type'])?></p>
		<?php endif; ?>
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
		
		<?php
		//check if user has made a comment in the past
		$commented = false;
		$currentUser = $this->session->userdata('user_id');
		$theComment;
		
		foreach($comments as $comment)
			if($currentUser == $comment['user_id'])
			{
				$commented = true;
				$theComment = $comment;
				break;
			}
		
		if($commented):
		?>
			<h2>Comments (<?=sizeOf($comments)?>) &nbsp;&nbsp;<span style="font-size:60%;"><a href="#" onClick="showHide(); return false;">Edit Comment</a></span></h2>
			<?=form_open('comment/edit', array('id' => 'comment_form', 'style' => 'display: none;'))?>
			<br />
			Rating: <?=form_dropdown('rating', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), $theComment['rating'])?>
			<br /><br />
			<?=form_textarea(array('name' => 'comment', 'value' => $theComment['comment'], 'style' => 'width: 400px; display: block;'))?>
			<?=form_hidden('media_id', $media['media_id'])?>
			<br />
			<input type="submit" value="Save changes" />&nbsp;&nbsp;&nbsp;<a href="#" onClick="showHide(); return false;" style="color: red">cancel</a>
			</form>
			
		<?php else: ?>
			
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
		<?php endif;?>
		<br />
		<div id="comments">
			<?php foreach($comments as $comment): ?>
			<div class="<?php if($media['user_id'] == $comment['user_id']): ?>owner <?php endif; ?>comment">
				<h4><?=$comment['comment']?></h4>
				<p><strong>Rating:</strong> <?=$comment['rating']?></p>
				<p>Posted by <?php if($this->session->userdata('user_id') != $comment['user_id']): ?><?=anchor('profile/'.$comment['user_id'], $comment['user_id'])?> <? else: ?>you <?php endif; ?>at <?=date('g:i a', $comment['time_stamp'])?> on <?=date('M j, Y')?>.</p>
				<?php if($this->session->userdata('user_id') == $comment['user_id']): ?><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="editButton(); return false;">edit</a>&nbsp;&nbsp;<?=anchor('comment/delete/'.$media['media_id'], 'delete')?></p><?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		
	</div>
</div>
<?$this->load->view('footer')?>