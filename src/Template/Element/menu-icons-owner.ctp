<?php if ($userId === $article->user_id) : ?>
	<li><a href='<?= "/entries/edit/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a></li>
	<li><a href='<?= "/entries/delete/" . $article->id ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a></li>	
<?php endif; ?>
