<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">		
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='<?= "/entries/view/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></li>
		<li><a href='<?= "/entries/gen/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-share"></span></a></li>
		<li><a href='<?= "/entries/edit/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a></li>
		<li><a href='#' onclick=javascript:save();><span class="glyphCustom glyphicon glyphicon-file"></span></a></li>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>		
   </ul>
</nav>

<div class="entries form large-9 medium-8 columns content">    
	<?= $this->Form->create($article) ?>
		<div class="form-group form-control-big">	
		
			<fieldset>
				<legend><?= __('Copy Entry') ?></legend>
				
				<?php echo $this->Form->text('title', array('label' => false, 'id' => 'title', 'class' => 'form-control marginBottom10')); ?>

				<?php echo $this->element('control-type'); ?>

				<?php echo $this->Form->input('description', array('div' => false, 'placeholder' => __('Description'), 'label' => false, 'id' => 'description', 'style' => 'margin-right: 2%; float:left; width:49%; height:400px;', 'class' => 'form-control marginBottom10')); ?>
				
				<?php echo $this->Form->input('description_esp', array('div'=> false, 'placeholder' => __('Description Spanish'), 'label' => false, 'id' => 'description_esp', 'style' => 'float:left; width: 49%; height:400px;', 'class' => 'form-control marginBottom10')); ?>
								
			</fieldset>
			
			
	<div class="formGroup text-center">
		<?= $this->Form->button('Save Changes', array('id' => 'save', 'class' => 'btn btn-primary btn-md')); ?>
	</div>	
				
		</div>
		
    <?= $this->Form->end() ?>
</div>
