<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
        <!-- li class="heading"><?= __('Actions') ?></li -->
        <!-- li><?= $this->Html->link(__('New Entry'), ['action' => 'add']) ?></li -->
		<li><a href='/entries/add/'><span class="glyphCustom glyphicon glyphicon-plus-sign"></span></a></li>
		<li><span class="entriesHeader middle">Entries&nbsp;<span class="middle" style="font-size:.75em;"><?= '(' . $recordCount . ')' ?></span></span></li>
	</ul>
</nav>

<div style='padding: 10px;' class=''>
	<table class='table table-striped'>
        <thead>
        </thead>
        <tbody>
            <?php foreach ($entries as $record): 
			
			//print_r($record);die;
			$id = $record[0];
			?>
            <tr>
                <td class="actions"><a href='<?= '/entries/edit/' . $id ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a></td>
                <td><?= $this->Html->link(__($record['title']), ['action' => 'view', $id]) ?></td>
                <td class="actions"><a href='<?= '/entries/delete/' . $id ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
