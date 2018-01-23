<div class="users form">
<?php echo $this->Form->create('Category'); ?>
    <fieldset>
        <legend><?php echo __('Add'); ?></legend>
        <?php 
			echo $this->Form->input('name');
			echo $this->Form->input('notes');
		?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>