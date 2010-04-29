<?=$this->load->view('header')?>
<script>
	$(document).ready(function(){
		$("#edit_form").validate({
			rules: {
				title: "required",
				genre: "required"
			}
		});
	});
</script>

<div id="container">
	<h1>Edit <?=$media['title']?></h1>
	
	<?=form_open('media/edit', array('id' => 'edit_form'))?>
	<table>
	<tr>
		<?=form_hidden('media_id', $media['media_id'])?>
		
		<td>Title:</td>
		<td><?=form_input('title', $media['title']);?></td>
	</tr>
	<tr>
		<td>Genre:</td>
		<td><?=form_input('genre', $media['genre']);?></td>
	</tr>
	
	<?php if($media['type'] == 'book'): ?>
	<tr class="book type">
		<td>Author:</td>
		<td><?=form_input('author', $media['author']);?></td>
	</tr>
	<tr class="book type">
		<td>Publisher:</td>
		<td><?=form_input('publisher', $media['publisher']);?></td>
	</tr>
	<tr class="book type">
		<td>ISBN:</td>
		<td><?=form_input('ISBN', $media['ISBN']);?></td>
	</tr>
	<?=form_hidden('writer', $media['writer']);?>
	<?=form_hidden('director', $media['director']);?>
	<?=form_hidden('artist', $media['artist']);?>
	<?php endif; if($media['type'] == 'movie'): ?>
	<tr class="movie type">
		<td>Writer:</td>
		<td><?=form_input('writer', $media['writer']);?></td>
	</tr>
	<tr class="movie type">
		<td>Director:</td>
		<td><?=form_input('director', $media['director']);?></td>
	</tr>
	<?=form_hidden('author', $media['author']);?>
	<?=form_hidden('publisher', $media['publisher']);?>
	<?=form_hidden('ISBN', $media['ISBN']);?>
	<?=form_hidden('artist', $media['artist']);?>
	<?php endif; if($media['type'] == 'cd'): ?>
	<tr class="cd type">
		<td>Artist:</td>
		<td><?=form_input('artist', $media['artist']);?></td>
	</tr>
	<?=form_hidden('author', $media['author']);?>
	<?=form_hidden('publisher', $media['publisher']);?>
	<?=form_hidden('ISBN', $media['ISBN']);?>
	<?=form_hidden('writer', $media['writer']);?>
	<?=form_hidden('director', $media['director']);?>
	<?php endif; ?>
	<tr>
		<td><input type="submit" value="Save changes" /></td>
		<td><a href="<?=base_url()?>" style="color:red">cancel</a></td>
	</tr>
	</table>
	
	</form>
</div>
</body>
</html>