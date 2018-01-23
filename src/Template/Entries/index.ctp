
<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
	</ul>
</nav>

<div style='padding: 10px;' class=''>
	<table class='table table-striped'>
        <thead>
        </thead>
        <tbody>
            <?php foreach ($entries as $record): ?>
            <tr>
				<td style="width: 50px;">
					<table style="width: 50px;">
						<tr>
							<?php if ($userId !== $record->user_id) : ?>
								<td style="padding-right: 10px;" class="actions"><a style="color:red;" href='<?= '/entries/gen/' . $record->id ?>'><span style="color:red;" class="glyphCustom glyphicon glyphicon-lock"></span></a></td>
								<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/copy/' . $record->id ?>'><span style="color:red;" class="glyphCustom glyphicon glyphicon-duplicate"></span></a></td>
								<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/view/' . $record->id ?>'><span style="color:red;" class="glyphCustom glyphicon glyphicon-eye-open"></span></a></td>
							<?php else : ?>
								<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/edit/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a></td>
								<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/copy/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a></td>
								<td style="padding-right: 10px;" class="actions"><a href='<?= '/entries/view/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></td>
							<?php endif; ?>
							
						</tr>
					</table>
				</td>
				<td>
				<?php
				
					$type = ' (new)';
					switch($record->type)
					{
						case TYPE1: 
							$type = ' (' . __(TAG1) . ')'; 
							break;
						case TYPE2: 
							$type = ' (' . __(TAG2) . ')'; 
							break; 
						case TYPE3: 
							$type = ' (' . __(TAG3) . ')'; 
							break;
						case TYPE4: 
							$type = ' (' . __(TAG4) . ')'; 
							break;
						case TYPE7: 
							$type = ' (' . __(TAG7) . ')'; 
							break;
						case TYPE5: 
							//if ($userId !== $record->user_id)
							//	$type = ' (' . __(TAGSHARED) . ')'; 
							//else
								$type = ' (' . __(TAG5) . ')'; 
							break;
						case TYPE6: 
							$type = ' (' . __(TAG6) . ')'; 
							break;
					}
					
					echo $this->Html->link(__($record->title) . $type, ['action' => 'gen', $record->id]);
					
					if ($showBody)
					{
						echo '<hr/>';
						echo $this->Text->autoParagraph(h($record->description)); 
					}
					
				?></td>
				<?php if ($userId === $record->user_id) : ?>
					<td class="actions"><a href='<?= '/entries/delete/' . $record->id ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a></td>
				<?php else : ?>
					<td></td>
				<?php endif; ?>
				
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
