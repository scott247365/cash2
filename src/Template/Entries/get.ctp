<?php if ($lang == 1) : ?>
<?= $this->Text->autoParagraph(h($article->description)); ?>
<?php else : ?>
<?= $this->Text->autoParagraph(h($article->description_esp)); ?>
<?php endif; ?>
