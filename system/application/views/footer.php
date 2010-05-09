<?php /*****************************************************************************
 *  footer.php
 *  
 *  This is the footer displayed on all pages. has links and developer names.
 *
 ****************************************************************************/?>

<div class="clear"></div>
<div id="footer">
	<?php if($this->session->userdata('logged_in')): ?>
	<p class="links"><?=anchor('suggestion', 'Make a suggestion')?>&nbsp;&nbsp;&nbsp;<?=anchor('refer', 'Refer somone to MediaBorrow')?></p>
	<?php endif; ?>
	<p class="copyright">MediaBorrow is a project by Kyle Ellman, Michael Wisely, and Jared Simon.</p>
</div>
</body>
</html>