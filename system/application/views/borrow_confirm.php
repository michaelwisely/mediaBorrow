<?=$this->load->view('header')?>

<script>
	$(document).ready(function(){
		$(".selectors > a").click(function(event){
			$(".selectors > a").removeClass("selected");
			$(this).addClass("selected");
			
			$(".type").hide();
			$("#"+$(this).html()).show();
			
			
			
			return false;
		});
	});
</script>

<div id="container">
	<br /><br />
	<h2><?=$message?></h2>
	<br /><br />
	<?=form_open($function)?>
	<?=form_hidden('yes', 'yes')?>
	<?=form_hidden('id', $id)?>
	<?=form_hidden('borrower_id', $borrower_id)?>
	<?=form_hidden('start_date', $start_date)?>
	<input type="submit" value="Yes" />&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>" style="color:red">cancel</a>
</div>
</body>
</html>