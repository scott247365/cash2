<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='<?= "/entries/view/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></li>
		<li><a href='<?= "/entries/gen/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-share"></span></a></li>
		<li><a href='<?= "/entries/edit/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a></li>
		<li><a href='<?= "/entries/copy/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a></li>		
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
				
    </ul>
</nav>

<div class="entries form large-9 medium-8 columns content">    
	<?= $this->Form->create($article) ?>
		<div class="form-group form-control-big">	
			<fieldset>
				<legend><?= __('Delete Entry') ?></legend>
				
				<div class="entries view large-9 medium-8 columns content">
					<h3 style="font-size: 1.3em;"><?= h($article->title) ?></h3>
					
					<div style="font-size: 1.2em;" class="">
						<?= $this->Text->autoParagraph(h($article->description)); ?>
					</div>
					
					<hr></hr>					
					
					<div style="font-size: 1.2em;" class="">
						<?= $this->Text->autoParagraph(h($article->description_esp)); ?>
					</div>					
					
				</div>

			</fieldset>
			
			
	<div class="formGroup text-center">
		<?= $this->Form->button('Confirm Delete', array('class' => 'btn btn-primary btn-md')); ?>
	</div>	
			
			
		</div>
		
    <?= $this->Form->end() ?>
</div>
