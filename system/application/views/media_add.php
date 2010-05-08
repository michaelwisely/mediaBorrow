<?=$this->load->view('header')?>
<script>
	function typeChange()
	{
		//alert($("#mediaType").val());
		$(".type").hide();
		$("."+$("#mediaType").val()).show();
	}
	$(document).ready(function(){
		$("#add_form").validate({
			rules: {
				title: "required",
				genre: "required"
			}
		});
	});
</script>

<div id="container">
	<h1>Add new media</h1>
	
	<?=form_open('add/media', array('id' => 'add_form'))?>
	<table>
	<tr>
		<td>Title:</td>
		<td><?=form_input('title');?></td>
	</tr>
	<tr>
		<td>Genre:</td>
		<td><?=form_input('genre');?></td>
	</tr>
	<tr>
		<td>Media Type:</td>
		<td>
			<?php
			$types = array(
				'book' => 'Book',
				'movie' => 'Movie',
				'cd' => 'CD'
				);
			?>
			<?=form_dropdown('type', $types, 'book', 'id="mediaType" onChange="typeChange();"')?>
		</td>
	</tr>
	<tr class="book type">
		<td>Author:</td>
		<td><?=form_input('author');?></td>
	</tr>
	<tr class="book type">
		<td>Publisher:</td>
		<td><?=form_input('publisher');?></td>
	</tr>
	<tr class="book type">
		<td>ISBN:</td>
		<td><?=form_input('ISBN');?></td>
	</tr>
	<tr class="movie type" style="display: none;">
		<td>Writer:</td>
		<td><?=form_input('writer');?></td>
	</tr>
	<tr class="movie type" style="display: none;">
		<td>Director:</td>
		<td><?=form_input('director');?></td>
	</tr>
	<tr class="cd type" style="display: none;">
		<td>Artist:</td>
		<td><?=form_input('artist');?></td>
	</tr>
	<tr>
		<td><input type="submit" value="Add" /></td>
		<td><a href="<?=base_url()?>" style="color:red">cancel</a></td>
	</tr>
	</table>
	
	</form>
</div>
<?$this->load->view('footer')?>