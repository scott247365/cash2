<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='#' onclick=javascript:save();><span class="glyphCustom glyphicon glyphicon-file"></span></a></li>
		<li><a href='#' onclick=javascript:stay();><span class="glyphCustom glyphicon glyphicon-ok"></span></a></li>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>		
		</ul>
</nav>

<div class="entries form large-9 medium-8 columns content">
    <?= $this->Form->create($article) ?>
	
		<div class="form-group form-control-big">	
	
			<fieldset>
				<legend><?= __('Add Entry') ?></legend>

				<?= $this->Form->checkbox('stay', ['id' => 'stay', 'checked' => false, 'hidden' => true]); ?><!-- this is needed to flag the stay option -->

				<?php echo $this->Form->text('title', array('placeholder' => __('Title'), 'label' => false, 'id' => 'title', 'class' => 'form-control marginBottom10')); ?>

				<?php echo $this->element('control-type'); ?>

				<?php echo $this->Form->input('description', array('div' => false, 'placeholder' => __('Description'), 'label' => false, 'id' => 'description', 'style' => 'margin-right: 2%; float:left; width:49%; height:400px;', 'class' => 'form-control marginBottom10')); ?>
				
				<?php echo $this->Form->input('description_esp', array('div'=> false, 'placeholder' => __('Description Spanish'), 'label' => false, 'id' => 'description_esp', 'style' => 'float:left; width: 49%; height:400px;', 'class' => 'form-control marginBottom10')); ?>

				</fieldset>
				
		</div>

		<div class="formGroup text-center">
			<?= $this->Form->button('Submit', array('id' => 'save', 'class' => 'btn btn-primary btn-md')); ?>
		</div>	
	
    <?= $this->Form->end() ?>
	
	
<?php if ($allowTranslate) : ?>
	
	<nav class="large-3 medium-4 columns" id="submenu">
		<ul class="submenu">
			<li><a href='#' onclick='javascript:copyFromTo("#trx", "#description");'><span class="glyphCustom glyphicon glyphicon-open"></span></a></li>
			<li><a href='#' onclick='javascript:copyFromTo("#trx", "#description_esp");'><span class="glyphCustom glyphicon glyphicon-export"></span></a></li>
		</ul>
	</nav>

<div id="google_translate_element"></div>

<script type="text/javascript">

function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}

</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

	<div id="trx">	
		<?= $this->Text->autoParagraph(h($article->description)); ?>
	</div>	
	
</div>

<?php endif; ?>
