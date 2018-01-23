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
    <h3><?= h($article->title) ?></h3>
</div>
<div style="display: flex;" class="entries view large-9 medium-8 columns content">
    
	<div id="" style="" class="entry">
		<a href='#' onclick="javascript:clipboardCopy('entry', 'entry');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a>
		<span id="entry">
		<?php
			foreach($description as $line)
			{
				if (is_array($line))
				{
					echo $line[0];					
					echo '<br/><br/>';
				}
				else
				{
					echo $line;
				}
			}
		?>
		</span>
	</div>

   <div style="" class="entry entry2">
		<a href='#' onclick="javascript:clipboardCopy('entry2','entry2');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a>
		<span id="entry2">
		<?php
			foreach($description2 as $line)
			{
				if (is_array($line)) // not ready yet!!
				{
					if (false)
					{
						echo $line[0];
						echo '<div class="dropdown">';
						echo '<a class="dropbtn">more</a><br/><br/>';
						echo '<div style="z-index: 100;" class="dropdown-content">';
							foreach($line as $l)
							{
								//echo $l . '<br/>';
								echo '<a href="/language/index/es">' . $l . '</a>';
							}
						echo '</div>';
						echo '</div>';
					}
					else
					{
						echo $line[0];
					}
					
					echo '<br/><br/>';
				}
				else
				{
					echo $line;
				}
			}
		?>
		</span>
    </div>
	
</div>
