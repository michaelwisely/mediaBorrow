<?php /*****************************************************************************
 *  refer.php
 *  
 *  Allows users to refer non-users to the sustem. Loaded by Refers controller
 *
 ****************************************************************************/?>

<?=$this->load->view('header')?>

<script>
	$(document).ready(function(){
		$("#refer_form").validate({
			rules: {
				name: "required",
				email: {
					required: true,
					email: true
				}
			}
		});
	});
</script>

<div id="container">

		<h1><?=$title?></h1>
		<br /><br />
		<?=form_open('refer', array('id' => 'refer_form'))?>
		<table>
			<tr>
				<td>Your friend's name:</td>
				<td><?=form_input('name')?></td>
			</tr>
			<tr>
				<td>Your friend's email:</td>
				<td><?=form_input('email');?></td>
			</tr>
			<tr>
				<td><input type="submit" value="Send" />&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>" style="color:red">cancel</a></td>
				<td></td>
			</tr>
		</table>
		<?=form_hidden('user_id', $user_id)?>
		</form>
</div>
<?$this->load->view('footer')?>