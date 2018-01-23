		
<div class="row">	
	<div class="col-sm-6 col-sm-offset-3">				
		<form class="form-horizontal validate" action="/contacts/add/fp" method="post" data-success="Request sent, thank you!" data-toastr-position="bottom-right">
		
			<div class="form-group form-control-big">	
			
				<label class="control-label" for="name"><?= __('Name') ?>:</label>
				<input type="text" id="name" name="name" class="form-control marginBottom10 required" placeholder="<?= __('Your Name') ?>">

				<label class="control-label" for="email"><?= __('Email') ?>:</label>
				<input type="text" id="email" name="email" class="form-control marginBottom10 required" placeholder="<?= __('Your Email Address') ?>">

				<label class="control-label" for="message"><?= __('Message') ?>:</label>
				<textarea rows="5" id="message" name="message" class="form-control marginBottom10 required" placeholder="<?= __('Please enter a message') ?>"></textarea>
				
			</div>
			
			<div class="text-center">			
				<?= $this->Form->button(__(__('Send Message')), ['class' => 'btn btn-primary btn-md']) ?>
			</div>

		<?= $this->Form->end() ?>
	</div>
</div>
