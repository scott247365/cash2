<div class="users form">
<?php echo $this->Form->create('Subcategory'); ?>
    <fieldset>
        <legend><?php echo __('Add Subcategory'); ?></legend>
        <?php 
			echo $this->Form->input('category');
			echo $this->Form->input('name');
		?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>