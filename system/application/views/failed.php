<?php /*****************************************************************************
 *  failed.php
 *  
 *  Infoms a user when they make illegal actions regarding borrows. Called by
 *  Borrow controller.
 *
 ****************************************************************************/?>
<?=$this->load->view('header')?>
<div id="container">
	<h1>D'oh!</h1>
	<h2 style='color:red'><?=$message?></h2>
	<h3><?=anchor('', 'Return home')?></h3>
</div>
<?$this->load->view('footer')?>