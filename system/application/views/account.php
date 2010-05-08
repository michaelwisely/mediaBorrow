<?php
$months = array(
			'01' => 'Jan',
			'02' => 'Feb',
			'03' => 'Mar',
			'04' => 'Apr',
			'05' => 'May',
			'06' => 'Jun',
			'07' => 'Jul',
			'08' => 'Aug',
			'09' => 'Sep',
			'10' => 'Oct',
			'11' => 'Nov',
			'12' => 'Dec',
			);
		
for ($i = 0; $i < 31; $i++)
{
	$days[$i+1] = $i+1; 
}

for($i = 1900; $i <= date('Y'); $i++)
{
	$years[$i] = $i;
}

?>

<?=$this->load->view('header')?>

<script>
	$(document).ready(function(){
		$("#account_form").validate({
			rules: {
				repeat_password: {
					equalTo: "#password"
				},
				fname: "required",
				lname: "required",
				email: {
					required: true,
					email: true
				},
				zip: {
					required: true,
					minlength: 5,
					maxlength: 5,
					digits: true
				}
			},
			messages: {
				zip: "must be a 5 digit zip code",
				repeat_password: "passwords must match"
			}
		});
	});
</script>

<div id="container">
	<h1>Edit account details for <?=$userData['user_id']?></h1>
	
	<?=form_open('account/edit', array('id' => 'account_form'))?>
	<table>
		<tr>
			<td></td>
			<td>Leave password blank if you don't wish to change it.</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><?=form_password(array('name' => 'password', 'id' => 'password'))?></td>
		</tr>
		<tr>
			<td>Repeat Password:</td>
			<td><?=form_password('repeat_password')?></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><?=form_input(array('name' => 'fname', 'value' => $userData['fname']))?></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><?=form_input(array('name' => 'lname', 'value' => $userData['lname']))?></td>
		</tr>
		<tr>
			<td>Email Address:</td>
			<td><?=form_input(array('name' => 'email', 'value' => $userData['email']))?></td>
		</tr>
		<tr>
			<td>Date of Birth:</td>
			<td><?=form_dropdown('month', $months, substr($userData['dob'], 5, 2))?> <?=form_dropdown('day', $days, substr($userData['dob'], 8))?> <?=form_dropdown('year', $years, substr($userData['dob'], 0, 4))?></td>
		</tr>
		<tr>
			<td>Zip Code:</td>
			<td><?=form_input(array('name' => 'zip', 'value' => $userData['zip']))?></td>
		</tr>
		<tr>
			<td><input type="submit" value="Save changes" />&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>" style="color:red">cancel</a></td>
			<td></td>
		</tr>
	</table>
	</form>
</div>

<?=$this->load->view('footer')?>