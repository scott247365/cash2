
<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
	</ul>
</nav>

<?php if (false) : ?>

<div style='padding: 10px;' class=''>
	<table class='table table-striped'>
        <thead>
        </thead>
        <tbody>
            <?php foreach ($entries as $record): ?>
            <tr>
				<td>
				<?php
				
					$type = ' (new)';
					switch($record->type)
					{
						case 1: 
							$type = ' ' . __('(email)'); 
							break;
						case 2: 
							$type = ' ' . __('(eng)'); 
							break; 
						case 3: 
							$type = ' ' . __('(note)');  
							break;
						case 7: 
							$type = ' ' . __('(TPL)');  
							break;
						case 5: 
							$type = ' ' . __('(can)');  
							break;
						case 6: 
							$type = ' ' . __('(FAQ)');  
							break;
					}
					
					echo $this->Html->link(__($record->title) . $type, ['action' => 'gen', $record->id]);
					
					if ($showBody)
					{
						echo '<hr/>';
						echo $this->Text->autoParagraph(h($record->description)); 
					}
					
				?></td>
				<td style="width: 100px;">
					<table>
						<tr>
							<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/edit/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a></td>
							<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/copy/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a></td>
							<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/view/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></td>
							<td class="actions"><a href='<?= '/entries/delete/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a></td>
						</tr>
					</table>
				</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php endif; ?>

<section id="sectionReview" style='display: default; border: 0;'>

<?php $cnt = 0; foreach($entries as $rec) : ?>
	<div style="margin: 10px 0; background-color: <?php echo (($cnt % 2 == 0) ? '#EEF8DC' : 'white'); ?>; border: lightGray solid 1px">
		<div style="border-bottom: lightGray dashed 1px; padding: 5px; font-size: 130%; min-width: 200px; margin: 20px; padding-bottom: 20px;">
			<?= ++$cnt . '. &nbsp;' .  $this->Html->link(__($rec->title), ['style' => 'background-color: red;', 'action' => 'gen', $rec->id]); ?>
			<?php if (true) : ?>
				<span style='font-size: 60%; float: right;'>
					<a href=<?= '/entries/view/' . $rec['id'] ?> ><?= __('View') ?></a>&nbsp;&nbsp;
					<a href=<?= '/entries/edit/' . $rec['id'] ?> ><?= __('Edit') ?></a>&nbsp;&nbsp;
					<a href=<?= '/entries/copy/' . $rec['id'] ?> ><?= __('Copy') ?></a>&nbsp;&nbsp;
					<a href=<?= '/entries/delete/' . $rec['id'] ?> ><?= __('Delete') ?></a>
				</span>
			<?php endif; ?>			
		</div>
		<div style="padding: 5px; font-size: 120%; min-width: 200px; margin: 20px; xmargin-right: 20px;">
			<?= $this->Text->autoParagraph(h($rec->description)); ?>
			 
		</div>
	</div>
<?php endforeach; ?>

</section>

