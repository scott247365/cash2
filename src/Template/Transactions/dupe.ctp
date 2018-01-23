<?php echo $this->element('transactionAddCopy'); ?>

<?php if (false) : ?>

<?php echo $this->Html->script('setsub'); ?>

<script>

var subjump = [];
	
// create subcat lookup table
<?php $cnt = 0; foreach ($subjump as $rec): ?>
	
subjump[<?php echo $cnt++; ?>] = ["<?php echo $rec['Subcategory']['name']; ?>", <?php echo $rec['Subcategory']['id']; ?>, <?php echo $rec['Subcategory']['parent_id']; ?>, <?php echo $rec['Subcategory']['type']; ?>];
	
<?php endforeach; ?>	
	
</script>

<div class="">
<?php echo $this->Form->create('Transaction'); ?>
    <fieldset>
        <legend>Copy Transaction</legend>
		
		<div style="font-size: 1.3em;" class="form-group">
			<?php echo $this->Form->input('date'); ?>
		</div>
		
		<div style="font-size: 1.3em;" class="form-group">
			<label for="description">Description:</label>		
			<?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => false)); ?>
		</div>
			
		<div style="font-size: 1.5em;" class="form-group">
        <?php 		
			echo $this->Form->input('parent_id', array('type' => 'select', 'options' => $accounts, 'div' => false, 'label' => false));

			echo $this->Form->input('category', array('type' => 'select', 'options' => $categories, 'label' => false, 
				'div' => false, 'onchange' => 'javascript:setSub(this.value, "TransactionSubcategory")'));

				echo $this->Form->input('subcategory', array('type' => 'select', 'options' => $subcategories, 'div' => false, 'label' => false));
		?>
		</div>
			
		<div style="font-size: 1.3em;" class="form-group">
			<label for="type">Type:</label>
			<?php echo $this->Form->radio('type', array('1' => '&nbsp;Debit', '2' => '&nbsp;Credit'), ['style' => 'margin: 10px;', 'legend' => false, 'class' => '']); ?>
		</div>
		
		<div class="form-group">
			<label for="amount">Amount:</label>		
			<?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => false)); ?>

			<label for="notes">Notes:</label>		
			<?php echo $this->Form->input('notes', array('class' => 'form-control', 'label' => false)); ?>
		</div>
		
		<div class="form-group">
			<div class="col-xs-5 col-xs-offset-3">
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>	
			
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>

<?php endif; ?>