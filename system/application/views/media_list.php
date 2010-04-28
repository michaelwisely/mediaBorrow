<?=$this->load->view('header')?>
<div id="container">
	<h1>Search Results</h1>
	
	<?php foreach($results as $media): ?>
		<p>
			<?php foreach($media as $attribute => $value): ?>
			<?php if($value != '') {echo $attribute.' - '.$value.'<br />';} ?>
			<?php endforeach; ?>
		</p>
	<?php endforeach; ?>

	
	<table>
	<tr >
		<th>Title</t>
		<th>Type</th>
		<th>Additional Information</td>
	</tr>
	<tr>
		<td>A Great Movie</td>
		<td>movie</td>
		<td>Writer: Name</br>
			Director: Name</td>
		<td class="outside"><a href="#">borrow</a></td>
	</tr>
	<tr>
		<td>An Intriguing Book</td>
		<td>Book</td>
		<td>Author: Name</br>
			Publisher: Name
			ISBN: 0-943396-04-2</td>
		<td class="outside"><a href="#">borrow</a></td>
	</tr>
	<tr>
		<td>Great Music</td>
		<td>CD</td>
		<td>Artist: Name
			</td>
		<td class="outside"><a href="#">borrow</a></td>
	</tr>
	</table>
</div>
</body>
</html>