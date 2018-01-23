

<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='<?= "/entries/view/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></li>
		<li><a href='<?= "/entries/gen/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-share"></span></a></li>
		<li><a href='<?= "/entries/copy/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a></li>
		<!-- li><a href='#' onclick="javascript:save();"><span class="glyphCustom glyphicon glyphicon-file"></span></a></li -->
		<!-- li><a href='#' onclick="javascript:flip('#description', '#description_esp', false);"><span class="glyphCustom glyphicon glyphicon-transfer"></span></a></li -->
		<!-- li><a href='#' onclick=javascript:stay();><span class="glyphCustom glyphicon glyphicon-ok"></span></a></li -->
		<!-- li><a href='#' onclick='javascript:copyFromToInput("#description", "#trx", "#description_esp");'><span class="glyphCustom glyphicon glyphicon-ok"></span></a></li -->
		<?= $this->element('menu-icons-owner'); ?>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
    </ul>
</nav>

<div class="entries form large-9 medium-8 columns content">    
	<?= $this->Form->create($article) ?>
		<div class="form-group form-control-big">	
			<fieldset>
				<legend><?= __('Edit Entry') ?></legend>
				
				<?= $this->Form->checkbox('stay', ['id' => 'stay', 'checked' => false, 'hidden' => true]); ?><!-- this is needed to flag the stay option -->
				
				<?php echo $this->Form->text('title', array('label' => false, 'id' => 'title', 'style' => '', 'div' => true, 'class' => 'form-control marginBottom10')); ?>

				<?php echo $this->element('control-type'); ?>
	
<div>
	
<div style="xbackground-color: yellow; float:left; width:49%;margin-right: 1%;">
		<div style="padding-top: 10px;">
			<?= $this->Form->button('Save', array('id' => 'save', 'style' => 'float:left; margin-right:10px;', 'div' => true, 'class' => 'btn btn-primary btn-xs')); ?>
			<?= $this->Form->button('Save and Stay', array('type' => 'button', 'onclick' => 'javascript:stay();', 'id' => 'stay', 'style' => 'float:left; margin-right:20px;', 'div' => true, 'class' => 'btn btn-primary btn-xs')); ?>
			<!-- a href='#' onclick=javascript:stay();><span class="glyphCustom glyphicon glyphicon-ok"></span></a -->
			<a href='#' onclick="javascript:flip('#description', '#description_esp', false);"><span style="padding-right: 10px;" class="glyphCustom glyphicon glyphicon-transfer"></span></a>
			<a href='#' onclick='javascript:clearText("#description");'><span style="padding-right: 10px;" class="glyphCustom glyphicon glyphicon-remove"></span></a>
			
	<?php if ($allowTranslate || $userName == 'Scott') : ?>
			<a href='#' onclick='javascript:copyFromTo("#trx", "#description");'><span style="padding-right: 10px;" class="glyphCustom glyphicon glyphicon-hand-left"></span></a>
	<?php endif; ?>
			
		</div>

	<div style="">
		<?php echo $this->Form->input('description', array('div' => false, 'placeholder' => __('English'), 'label' => false, 'id' => 'description', 'style' => 'height:400px;', 'class' => 'form-control marginBottom10')); ?>
	</div>
</div>

<div style="xbackground-color: orange; float:left; width:50%;">
	<div style="padding-top: 10px;">
		<a href='#' onclick="javascript:flip('#description', '#description_esp', false);"><span style="padding-right: 10px;" class="glyphCustom glyphicon glyphicon-transfer"></span></a>
		<a href='#' onclick='javascript:clearText("#description_esp");'><span style="padding-right: 10px;" class="glyphCustom glyphicon glyphicon-remove"></span></a>
<?php if ($allowTranslate || $userName == 'Scott') : ?>
		<a href='#' onclick='javascript:copyFromTo("#trx", "#description_esp");'><span class="glyphCustom glyphicon glyphicon-hand-right"></span></a>
<?php endif; ?>
	</div>
<div>
				<?php echo $this->Form->input('description_esp', array('div'=> false, 'placeholder' => __('Spanish'), 'label' => false, 'id' => 'description_esp', 'style' => 'height:400px;', 'class' => 'form-control marginBottom10')); ?>
</div>
</div>
</div>
				
			</fieldset>
			
			
	<div class="formGroup text-center">
		<?= $this->Form->button('Save Changes', array('id' => 'save', 'class' => 'btn btn-primary btn-md')); ?>
	</div>
			
			
		</div>
		
    <?= $this->Form->end() ?>

<?php if ($allowTranslate) : ?>
	
<div style="padding-top: 10px;">
	<a href='#' onclick='javascript:copyFromTo("#trx", "#description");'><span style="padding-right: 10px;" class="glyphCustom glyphicon glyphicon-hand-left"></span></a>
	<a href='#' onclick='javascript:copyFromTo("#trx", "#description_esp");'><span class="glyphCustom glyphicon glyphicon-hand-right"></span></a>
</div>
		
<div id="google_translate_element"></div>

<script type="text/javascript">

function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}

</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
				
	<div id="trx">	
		<?php
		//$this->Text->autoParagraph(h($article->description)); 
		$lines = mb_split('\r\n', $article->description);
		//debug($lines);die;
		foreach($lines as $line)
		{
			echo $line . '<br/>';
		}
		?>
	</div>
	
</div>

<?php endif; ?>
