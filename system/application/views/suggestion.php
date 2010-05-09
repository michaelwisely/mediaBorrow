<?php /*****************************************************************************
 *  suggestion.php
 *  
 *  allows users to submit suggestions to site adimistrators. 
 *
 ****************************************************************************/?>

<?=$this->load->view('header')?>
<script>
	$(document).ready(function(){
		$("#suggestion_form").validate({
			rules: {
				topic: "required",
				suggestion: "required"
			}
		});
	});
</script>

<div id="container">
	<div id="main">
		<h1>Make a suggestion</h1>
	
		<?=form_open('suggestion', array('id' => 'suggestion_form'))?>
		<table>
		<tr>
			<td>Topic:</td>
			<td><?=form_input('topic');?></td>
		</tr>
		<tr>
			<td style="vertical-align:text-top;">Suggestion:</td>
			<td><?=form_textarea('suggestion');?></td>
		</tr>
		<tr>
			<td><input type="submit" value="Suggest" /></td>
			<td><a href="<?=base_url()?>" style="color:red">cancel</a></td>
		</tr>
		</table>
	
		</form>
	</div>
</div>
<?$this->load->view('footer')?>