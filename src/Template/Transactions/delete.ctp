<style>

label {
	margin-right: 20px;
}

</style>


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
        <legend><?php echo __('Delete Transaction'); ?></legend>
		
		<div style="font-size: 1.3em;" class="form-group">
			<table>
				<tr>
				<td><label for="date">Date:</label></td>
				<td><?php echo $this->data['Transaction']['date']; ?></td>
				</tr>

				<tr>
				<td><label for="description">Description:</label></td>
				<td><?php echo $this->data['Transaction']['description']; ?></td>
				</tr>
				
				<tr>
				<td><label for="amount">Amount:</label></td>
				<td><?php echo $this->data['Transaction']['amount']; ?></td>
				</tr>
			
			</table>
		</div>

		
    </fieldset>
<?php echo $this->Form->end(__('Confirm Delete')); ?>
</div>