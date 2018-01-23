
<?php echo $this->Form->create('Transaction'); ?>
	<div class="form-group">
        <legend><?php echo __('Transfer Between Accounts'); ?></legend>
		
		<div style="font-size: 1.3em;" class="form-group">
			<label>Date:</label>
			<?php echo $this->Form->input('date', ['label' => false]); ?>
			<?php echo $this->Form->input('account_from', ['class' => 'form-control', 'label' => 'From Account:&nbsp;', 'type' => 'select', 'options' => $accountFrom, 'selected' => $selected_parent]); ?>
			<?php echo $this->Form->input('account_to', ['class' => 'form-control', 'label' => 'To Account:&nbsp;', 'type' => 'select', 'options' => $accountTo, 'selected' => $selected_parent]); ?>
			<?php echo $this->Form->input('amount', ['class' => 'form-control', 'label' => 'Amount:&nbsp;']); ?>
			<?php echo $this->Form->input('notes', ['class' => 'form-control', 'label' => 'Notes:&nbsp;']); ?>
		</div>
    </div>
<?php echo $this->Form->end(__('Submit')); ?>
