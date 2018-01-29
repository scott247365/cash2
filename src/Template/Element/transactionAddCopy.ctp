
<?php echo $this->Html->script('setsub'); ?>

<script>

var subjump = [];
	
// create subcat lookup table
<?php $cnt = 0; foreach ($subjump as $rec): ?>
	
subjump[<?php echo $cnt++; ?>] = ["<?php echo $rec['Subcategory']['name']; ?>", <?php echo $rec['Subcategory']['id']; ?>, <?php echo $rec['Subcategory']['parent_id']; ?>, <?php echo $rec['Subcategory']['type']; ?>];
	
<?php endforeach; ?>	
	
</script>


<div class="">
<?php echo $this->Form->create('Transaction', ['class' => 'form-horizontal']); ?>
    <fieldset>
        <legend><?php echo __('Add Transaction'); ?></legend>
        				
		<div class="form-group">
			<label class="col-xs-3 control-label">Date:</label>
			<div style="font-size: 1.3em;" class="col-xs-5">
				<?php echo $this->Form->input('date', ['label' => false]); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-3 control-label">Description:</label>
			<div class="col-xs-5">
				<?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => false)); ?>
			</div>	
		</div>

		<div class="form-group">
			<label class="col-xs-3 control-label">Account:</label>
			<div style="font-size: 1.5em;" class="col-xs-5">
				<?php //if (!isset($selected_parent)) $selected_parent = 0; ?>
				<?php echo $this->Form->input('parent_id', array('type' => 'select', 'options' => $accounts, /* removed line item add function: 'selected' => $selected_parent,*/ 'class' => 'form-control', 'label' => false)); ?>
				<?php echo $this->Form->input('category', array('type' => 'select', 'options' => $categories, 
					'onchange' => 'javascript:setSub(this.value, "subcategory")', 'class' => 'form-control', 'label' => false)); ?>
				<?php echo $this->Form->input('subcategory', array('type' => 'select', 'options' => $subcategories, 'class' => 'form-control', 'label' => false)); ?>
			</div>	
		</div>
		
		<div class="form-group">
			<label class="col-xs-3 control-label"></label>
			<div class="col-xs-5">
				<?php echo $this->Form->radio('type', array('1' => 'Debit', '2' => 'Credit'), array('style' => 'margin: 0px 10px;', 'legend' => false)); ?>
			</div>	
		</div>	
					
		<div class="form-group">
			<label class="col-xs-3 control-label">Amount:</label>
			<div class="col-xs-5">
				<?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => false)); ?><span id='showRate'></span>
			</div>	
		</div>
		
		<div class="form-group">
			<label class="col-xs-3 control-label">Convert:</label>
			<div class="col-xs-5">
				<?php 
					echo $this->Form->input('convert', array('type' => 'select', 'options' => ['(select)','EUR to USD','GBP to USD'], 
						'onchange' => 'convert()', 
						'class' => 'form-control', 
						'label' => false
					)); 
				?>
			</div>	
		</div>
		
		<div class="form-group">
			<label class="col-xs-3 control-label">Notes:</label>
			<div class="col-xs-5">
				<?php echo $this->Form->input('notes', array('class' => 'form-control', 'label' => false)); ?>
			</div>	
		</div>
		
		<div class="form-group">
			<label class="col-xs-3 control-label">Save and Add More:</label>
			<div class="col-xs-5">
				<?php echo $this->form->checkbox('checkboxsaveandadd', array('class' => 'form-control')); ?>
			</div>	
		</div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-primary">Submit</button>
			<?php echo $this->Form->button('Cancel', ['class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'location.href=\'/transactions/index?filter\'']); ?>			
        </div>
    </div>


    </fieldset>
<?php echo $this->Form->end(); ?>
</div>

<script src="/js/currency_converter.js"></script>
