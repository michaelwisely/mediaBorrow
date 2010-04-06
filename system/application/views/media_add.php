<html>
<head>
	<title>Add Media</title>
	<style>
		table {border-collapse: collapse;}
		tr {border-collapse: collapse;}
		td.outside{border-bottom: none;}
		td, th {padding: 0 5px 0 20px; text-align: left;}
	</style>
</head>

<body>
	<h1>Add Media</h1>
	
	<?=form_open('media/add')?>
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
				'cd' => 'CD',
				'movie' => 'Movie',
				);
			?>
			<?=form_dropdown('month', $types)?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><b>For Books</b></td>
	</tr>
	<tr>
		<td>Author:</td>
		<td><?=form_input('author');?></td>
	</tr>
	<tr>
		<td>Publisher:</td>
		<td><?=form_input('publisher');?></td>
	</tr>
	<tr>
		<td>ISBN:</td>
		<td><?=form_input('isbn');?></td>
	</tr>
	<tr>
		<td></td>
		<td><b>For Movies</b></td>
	</tr>
	<tr>
		<td>Writer:</td>
		<td><?=form_input('writer');?></td>
	</tr>
	<tr>
		<td>Director:</td>
		<td><?=form_input('director');?></td>
	</tr>
	<tr>
		<td></td>
		<td><b>For CDs</b></td>
	</tr>
	<tr>
		<td>Artist:</td>
		<td><?=form_input('artist');?></td>
	</tr>
	<tr>
		<td><input type="submit" value="Add" /></td>
		<td><a href="#" style="color:red">cancel</a></td>
	</tr>
	</table>
	
	</form>
</body>
</html>