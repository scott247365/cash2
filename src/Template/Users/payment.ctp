<div class="container">
	
	<div class="sectionHeader text-center">	
		<h1 class="formHeaderBlue"><span class="formHeaderBlue glyphicon glyphicon-user"></span>&nbsp;Account Set Up</h1>
	</div>	
		
	<div class="row">	
		<div class="col-sm-6 col-sm-offset-3">				
		
			<?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'signup'], 'class' => 'form-horizontal']); ?>
							
				<div class="form-group form-control-big">	
				
					<label class="control-label" for="plan">Account Plan:</label>				
					<?php echo $this->Form->select('plan', ['Basic Hosting $5.95/month', 'Pro Hosting, $9.95/month'],  
						['empty' => '(Select Hosting Plan)', 'label' => false, 'class' => 'form-control marginBottom10']); ?>
					
				</div>
				
				<div class="form-group form-control-big">	
				
					<label class="control-label" for="company">Company Name <i>(optional)</i>:</label>
					<?= $this->Form->input('company', ['placeholder' => '', 'label' => false, 'class' => 'form-control required marginBottom10']) ?>
					
					<label class="control-label" for="street">Address Line 1:</label>
					<?= $this->Form->input('street', ['label' => false, 'class' => 'form-control required marginBottom10']) ?>

					<label class="control-label" for="street2">Address Line 2 <i>(optional)</i>:</label>
					<?= $this->Form->input('street2', ['placeholder' => '', 'label' => false, 'class' => 'form-control required marginBottom10']) ?>

					<label class="control-label" for="city">City:</label>
					<?= $this->Form->input('city', ['label' => false, 'class' => 'form-control required marginBottom10']) ?>

					<label class="control-label" for="country">Country</label>
					<?= $this->Form->input('country', ['label' => false, 'class' => 'form-control required marginBottom10']) ?>
					
					<label class="control-label" for="state">State/Province:</label>
					<?php echo $this->Form->select('state', $states, ['empty' => '(Select State/Province)', 'label' => false, 'class' => 'form-control marginBottom10']);  ?>

					<label class="control-label" for="zip">Zip/Postal Code</label>
					<?= $this->Form->input('zip', ['label' => false, 'class' => 'form-control required marginBottom10']) ?>

				</div>			

				<div class="form-group form-control-big">	
				
					<label class="control-label" for="payment">Payment:</label>
					<?php echo $this->Form->select('payment', ['PayPal (Credit Cards Accepted)'],  ['index' => 0, 'label' => false, 'class' => 'form-control marginBottom10']); ?>
					
				</div>			
				
				<div class="text-center">						
					<?= $this->Form->button(__('Make Payment'), ['class' => 'btn btn-primary btn-md']) ?>
				</div>
			
			<?= $this->Form->end() ?>
		</div>
	</div>
	
</div>

