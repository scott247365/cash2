<div class="entries form large-9 medium-8 columns content">    
	<?= $this->Form->create($user) ?>
		<div class="form-group form-control-big">	
			<fieldset>
				<legend><?= __('Edit User') ?></legend>
				
				<?php echo $this->Form->input('email', ['label' => 'Email', 'class' => 'form-control marginBottom20']); ?>
				<?php echo $this->Form->input('userName', array('label' => 'User Name', 'class' => 'form-control marginBottom20')); ?>
				<?php echo $this->Form->input('firstName', array('label' => 'First Name', 'class' => 'form-control marginBottom20')); ?>
				<?php echo $this->Form->input('lastName', array('label' => 'Last Name', 'class' => 'form-control marginBottom20')); ?>
				<?php echo $this->Form->input('user_type', array('label' => 'Type', 'class' => 'form-control marginBottom20')); ?>
				<?php // echo $this->Form->input('password', array('label' => 'Password', 'class' => 'form-control marginBottom20')); ?>
				<input id='password' value='<?= $user->password ?>' label='Password' class='form-control marginBottom20' />

				<?php echo $this->Form->input('key_verify_email', array('label' => 'Key Verify Email', 'class' => 'form-control marginBottom20')); ?>
				<?php //echo $this->Form->input('key_verify_email_expire', array('label' => 'Key Verify Email Expire', 'class' => 'form-control marginBottom20')); ?>
				<?php echo $this->Form->input('key_reset_password', array('label' => 'Key Reset Password', 'class' => 'form-control marginBottom20')); ?>
				<?php //echo $this->Form->input('key_reset_password_expire', array('label' => 'Key Reset Password Expire', 'class' => 'form-control marginBottom20')); ?>
			</fieldset>
				
	<div class="formGroup text-center">
		<?= $this->Form->button('Save Changes', array('id' => 'save', 'class' => 'btn btn-primary btn-md')); ?>
	</div>	
			
		</div>
		
    <?= $this->Form->end() ?>
</div>
