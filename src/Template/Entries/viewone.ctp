<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='<?= "/entries/copy/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a></li>
		<?= $this->element('menu-icons-owner'); ?>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
    </ul>
</nav>

<style>
.entry {
	min-width: 200px; 
	background-color: white; 
	float: left; 
	font-size: 1.3em;
	padding: 0px 20px 20px 0px;
	min-width: 400px;
}

.entry2 {
	background-color: white;
}

.glyphsub {
	height: 10px;
}

</style>


<div style="">
    <h3><?= h($article->title) ?></h3>
</div>

<div style="display: flex;" class="entries view large-9 medium-8 columns content">
	
    <div class="entry">
		<span id='entry' >
			<?= $this->Text->autoParagraph(h($article->description)); ?>
		</span>
    </div>

</div>
