<div class="row">	
	<div class="col-sm-6 col-sm-offset-3">				
			
		<?= $this->Form->create(null, ['id' => 'loginForm', 'class' => 'form-horizontal']) ?>
						
			<div class="form-group form-control-big">	
				
				<label for="email" class="control-label"><?= __('Email:') ?></label>
				<?php echo $this->Form->input('email', array('label' => false, 'id' => 'email', 'class' => 'form-control marginBottom10')); ?>

				<label for="password" class="control-label"><?= __('Password:') ?></label>
				<?php echo $this->Form->input('password', array('label' => false, 'id' => 'password', 'class' => 'form-control marginBottom10')); ?>
		
			<?= $this->Html->link('Forgot Password', '/users/forgot'); ?>
		
			</div>
				
			<div class="form-group text-center">
				<?= $this->Form->button(__('Submit'), array(
					'onclick' => 'saveEmail();'
					, 'class' => 'btn btn-primary btn-md'
					)); ?>
			</div>
			
		<?= $this->Form->end() ?>
		
	</div>
</div>