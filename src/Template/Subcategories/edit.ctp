<div class="users form">
<?php echo $this->Form->create('Subcategory'); ?>
    <fieldset>
        <legend><?php echo __('Edit'); ?></legend>
		
		<div style="font-size: 1.5em;" class="form-group">
        <?php 			
			echo $this->Form->input('category', ['type' => 'select', 'selected' => 5, 'options' => $categories, 'label' => 'Categories:&nbsp;', 'div' => true]);
			echo $this->Form->input('name', ['label'=>'Subcategory:&nbsp;']);			
		?>
		</div>
		
    </fieldset>
<?php echo $this->Form->end(__('Save')); ?>
</div>