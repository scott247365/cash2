
<?php echo $this->Html->script('setsub'); ?>

<script>

var subjump = [];
	
// create subcat lookup table
<?php $cnt = 0; foreach ($subjump as $rec): ?>
	
subjump[<?php echo $cnt++; ?>] = ["<?php echo $rec['Subcategory']['name']; ?>", <?php echo $rec['Subcategory']['id']; ?>, <?php echo $rec['Subcategory']['parent_id']; ?>, <?php echo $rec['Subcategory']['type']; ?>];
	
<?php endforeach; ?>	
	
</script>

<div class="users form">
<?php echo $this->Form->create('Transaction'); ?>
    <fieldset>
        <legend><?php echo __('Duplicate Transaction'); ?></legend>
		
        <?php 		
			echo $this->Form->input('date');
		
			echo $this->Form->input('description');
			
			echo $this->Form->input('parent_id', array('type' => 'select', 'options' => $accounts));
			echo $this->Form->input('category', array('type' => 'select', 'options' => $categories, 'onchange' => 'javascript:setSub(this.value)'));
			echo $this->Form->input('subcategory', array('type' => 'select', 'options' => $subcategories));

			//echo $this->Form->input('type', array('options' => array('1' => 'Debit', '2' => 'Credit', '3' => 'Transfer')));
			echo "<label style='vertical-align: middle; margin: 0 0 15px 10px;'>";
			echo $this->Form->radio('type', array('1' => '&nbsp;Debit', '2' => '&nbsp;Credit'), array('legend' => false));
			echo "</label>";			
			
			echo $this->Form->input('amount');
			echo $this->Form->input('notes');
		
		?>
    </fieldset>
<?php echo $this->Form->end(__('Save')); ?>
</div>