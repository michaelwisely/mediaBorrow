<?php /*****************************************************************************
 *  search_results.php
 *  
 *  Displays search resuts by calling the medialist view. Called by Media Controller.
 *
 ****************************************************************************/?>

<?=$this->load->view('header')?>
<div id="container">
	<div id="main">
		<h1>Search Results</h1>
		<p>
			<?=form_open('search/media')?>
			<?=form_input('search', $search)?>
			<input type="submit" value="search" />
		</p><br /><br />
		
		<?=$this->load->view('media_list', array('profile' => false))?>
	</div>
</div>
<?$this->load->view('footer')?>