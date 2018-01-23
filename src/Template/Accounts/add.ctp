<div class="users form">
<?php echo $this->Form->create('Account'); ?>
    <fieldset>
        <legend><?php echo __('Add Account'); ?></legend>
        <?php 
			echo $this->Form->input('name');

			echo $this->Form->input('account_type', array('options' => array('1' => 'Debit', '2' => 'Credit', '3' => 'Other')));				
			
			echo $this->Form->input('starting_balance');
			
			echo $this->Form->input('notes');
			echo $this->Form->input('password_hint');
			echo $this->Form->input('linked_accounts');
		?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>