<?=$this->load->view('header')?>
<div id="container">
	<div id="main">
		<h1>Search Results</h1>
		<p>
			<?=form_open('search/media')?>
			<?=form_input('search', $search)?>
			<input type="submit" value="search" />
		</p><br /><br />
		
		<?=$this->load->view('media_list')?>
	</div>
</div>
</body>
</html>