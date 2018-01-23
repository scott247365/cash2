<h1>
    Entries tagged with
    <?= $this->Text->toList(h($tags)) ?>
</h1>

<section>
<?php foreach ($entries as $entry): ?>
    <article>
        <!-- Use the HtmlHelper to create a link -->
        <h4><?= $this->Html->link($entry->title, $entry->url) ?></h4>
        <small><?= h($entry->url) ?></small>

        <!-- Use the TextHelper to format text -->
        <?= $this->Text->autoParagraph(h($entry->description)) ?>
    </article>
<?php endforeach; ?>
</section>