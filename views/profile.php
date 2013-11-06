<?php if(isset($user_name)): ?>
    <h1>This is the profile for <?=$user->first_name?></h1>
<?php else: ?>
    <h1>No user specified</h1>
<?php endif; ?>
<section class="content">
	<h2>Edit Profile</h2>
	<form method='POST' action='/users/p_profile_edit'>

		<div class="avatar"></div>
		<input type='file' name='file' value='submit'><br />

		<input type='text' name='first_name' placeholder='<?=$user->first_name;?>'><br />
		<input type='text' name='last_name' placeholder='<?=$user->last_name;?>'><br />
		<input type='text' name='email' placeholder='<?=$user->email;?>'><br /> <!-- Query database to be sure email doesn't already exist -->
		<input type='password' name='password' placeholder='Password'><br />


		<div class="button"><input type='Submit' value='Save'></div>

	</form>
</section>

