<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<li><a href='<?= "/entries/view/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></li>
		<li><a href='<?= "/entries/copy/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a></li>
		<?= $this->element('menu-icons-owner'); ?>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
	</ul>		
  </ul>
</nav>

<style>
.entry {
	margin: 30px 20px 0px 0px; 
	font-size: 1.3em;
	background-color: white;
	float: left;
	width: 48%;
}

.entry2 {
	background-color: white;
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
    
	<div id="" style="" class="entry">
		<a href='#' onclick="javascript:clipboardCopy('entry', 'entryCopy');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a>

		<span style="" id="entry">
			<?php echo $description; ?>
		</span>
		
		<span style="display:none;" id="entryCopy">
			<?php echo $descriptionCopy; ?>
		</span>
		
	</div>

   <div style="" class="entry entry2">
		<a href='#' onclick="javascript:clipboardCopy('entry2', 'entryCopy2');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a>

		<span style="" id="entry2">
			<?php
			// working on displaying the link: [Link Text](link href)
			// $description2 = preg_replace("/(\[.*\])(\(.*\))/", "<a href='$2'>$1</a>", $description);
			?>
			<?php echo $description2; ?>
		</span>
		
		<span style="display:none;" id="entryCopy2">
			<?php echo $descriptionCopy2; ?>
		</span>
		
    </div>
	
</div>
