<div class="users form">
<?php echo $this->Form->create('Account', ['class' => 'form-horizontal']); ?>
    <fieldset>
        <legend><?php echo __('Edit Account'); ?></legend>
		
        <?php 		
			echo $this->Form->input('name', ['label' => 'Name:', 'class' => 'form-control']);

			echo $this->Form->input('account_type', ['label' => 'Account Type:', 'class' => 'form-control', 'options' => ['1' => 'Debit', '2' => 'Credit']]);
			
			echo $this->Form->input('starting_balance', ['label' => 'Starting Balance:', 'class' => 'form-control']);

			echo $this->Form->input('notes', ['label' => 'Notes:', 'class' => 'form-control']);
			//echo $this->Form->input('password_hint');
			//echo $this->Form->input('linked_accounts');
			
			echo '<div><label for="hidden">Hide this account:</label>';
			echo $this->form->checkbox('hidden', ['label' => false, 'div' => false, 'checked' => $hidden, 'class' => 'form-control']);		
			echo '</div>';
			
			//echo $this->form->button('Save Changes', ['class' => 'btn btn-primary']);
		?>
		
	    <div class="form-group">
        <div class="">
            <button type="submit" class="btn btn-primary">Save</button>
			<?php echo $this->Form->button('Cancel', ['class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'location.href=\'/accounts/index\'']); ?>			
        </div>	
		
    </fieldset>
		
    </div>

	
	<?php echo $this->Form->end(); ?>
</div>