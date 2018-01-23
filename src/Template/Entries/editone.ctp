<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='<?= "/entries/view/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></li>
		<li><a href='<?= "/entries/gen/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-share"></span></a></li>
		<li><a href='<?= "/entries/copy/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a></li>
		<li><a href='#' onclick=javascript:save();><span class="glyphCustom glyphicon glyphicon-file"></span></a></li>
		<?= $this->element('menu-icons-owner'); ?>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
    </ul>
</nav>

<div id="google_translate_element"></div>

<!-- do google translate 
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

-->

<div class="entries form large-9 medium-8 columns content">    
	<?= $this->Form->create($article) ?>
		<div class="form-group form-control-big">	
			<fieldset>
				<legend><?= __('Edit Entry') ?></legend>
				
				<?php echo $this->Form->text('title', array('label' => false, 'id' => 'title', 'class' => 'form-control marginBottom10')); ?>

				<?php echo $this->element('control-type'); ?>
				
<div>				
				<?php echo $this->Form->input('description', array('div' => false, 'placeholder' => __('Description'), 'label' => false, 'id' => 'description', 'style' => 'height:400px;', 'class' => 'form-control marginBottom10')); ?>
				
			</fieldset>
			
			
	<div class="formGroup text-center">
		<?= $this->Form->button('Save Changes', array('id' => 'save', 'class' => 'btn btn-primary btn-md')); ?>
	</div>	
			
			
		</div>
		
    <?= $this->Form->end() ?>
</div>
