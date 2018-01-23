<div class="row">	
	<div class="col-sm-6 col-sm-offset-3">				
	
		<?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'signup'], 'id' => 'signup', 'class' => 'form-horizontal']); ?>
		
			<!-- ACCOUNT INFO ---------------------------------------------------->
			
			<div class="form-group form-control-big">	
			
				<label class="control-label" for="firstName">First Name:</label>
				<?= $this->Form->input('firstName', ['label' => false, 'class' => 'form-control required marginBottom10']) ?>

				<label class="control-label" for="lastName">Last Name:</label>
				<?= $this->Form->input('lastName', ['label' => false, 'class' => 'form-control required marginBottom10']) ?>

				<label class="control-label" for="name">Email:</label>
				<?= $this->Form->input('email', ['label' => false, 'class' => 'form-control required']) ?>
				<div class="controlHelp marginBottom10">(Email address will be verified)</div>

				<label class="control-label" for="name">Password:</label>
				<?= $this->Form->input('password', ['label' => false, 'class' => 'form-control form-control-big required']) ?>
				<div class="controlHelp marginBottom10">(At least 6 upper and lower case letters and numbers)</div>
			
			</div><!-- form-group -->
					
			<div class="form-group text-center">			
				<?= $this->Form->button(__('Create Account'), ['class' => 'btn btn-primary btn-md']) ?>
			</div>
		
		<?= $this->Form->end() ?>
	</div>
</div>
