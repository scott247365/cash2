	<?= $this->Form->create('',['type' => 'post', 'url' => ['action' => 'index']]) ?>
		<?php echo $this->Form->input('search', array('placeholder' => __('Search'), 'value' => $search, 'label' => false, 'id' => 'search', 'class' => 'form-control')); ?>
	<?= $this->Form->end() ?>
