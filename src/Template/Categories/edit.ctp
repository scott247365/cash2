<div class="users form">
<?php echo $this->Form->create('Category'); ?>
    <fieldset>
        <legend><?php echo __('Edit'); ?></legend>
		
        <?php 			
		echo $this->Form->input(
			'name',
			array('label' => 'Category Name:')
		);			
		echo $this->Form->input('notes');
		
		?>
    </fieldset>
<?php echo $this->Form->end(__('Save')); ?>
</div>