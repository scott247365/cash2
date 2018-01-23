<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
	<table class='table table-striped'>
        <thead>
            <tr>
                <th class="actions"></th>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('user_type') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($users)): ?>
            <?php foreach ($users as $user): ?>
            <tr>
				<td style="width: 50px;">
					<table style="width: 50px;">
						<tr>
							<td style="padding-right: 10px;" class="actions"><a href='<?= '/users/editadmin/' . $user->id ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a></td>
							<td style="padding-right: 10px;" class="actions"><a href='<?= '/users/view/' . $user->id ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a></td>
						</tr>
					</table>
				</td>
			
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= $user->firstName . ' ' . $user->lastName ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->user_type) ?></td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->modified) ?></td>

				<td class="actions"><a href='<?= '/users/delete/' . $user->id ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a></td>				
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
	<?php if (isset($this->Paginator->numbers)): ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
	<?php endif; ?>
    </div>
</div>
