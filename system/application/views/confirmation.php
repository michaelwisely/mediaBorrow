<?php /*****************************************************************************
 *  confirmation.php
 *  
 *  Displays a confirmation message to users to reiterate that the action they made
 *  happened successfully.
 *
 ****************************************************************************/?>

<?=$this->load->view('header')?>
<div id="container">
	<h1>Success!</h1>
	<h2><?=$message?></h2>
	<h3><?=anchor('', 'Return home')?></h3>
</div>
<?$this->load->view('footer')?>