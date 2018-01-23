<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='<?= "/entries/gen/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-share"></span></a></li>
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
	width: 48%;
}

.entry2 {
	background-color: white;
}

.glyphsub {
	height: 10px;
}

</style>

<div style="">	
	<?php if ($userId === $article->user_id) : ?>
		<h3><?= h($article->title) ?></h3>
	<?php else : ?>
		<h3 style="color:red;"><?= h($article->title) . ' (' . h('Shared') . ')' ?></h3>
	<?php endif; ?>	
</div>

<div style="display: flex;" class="entries view large-9 medium-8 columns content">
	
    <div class="entry">
		<a href='#' onclick="javascript:clipboardCopy('entry','entry');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a>
		<span id='entry' >
			<?= $this->Text->autoParagraph(h($article->description)); ?>
		</span>
    </div>

    <div class="entry entry2">
		<a href='#' onclick="javascript:clipboardCopy('entry2','entry2');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a>
		<span id='entry2' >
			<?= $this->Text->autoParagraph(h($article->description_esp)); ?>
		</span>
    </div>
</div>
