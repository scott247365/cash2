
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->firstName) . ' ' . h($user->lastName) ?></h3>
    <table class="vertical-table">
		<tr>
			<th><?= __('User ID') ?></th>
            <td><?= h($user->id) ?></td>
        </tr>
		
		<tr>
			<th><?= __('Email Address') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>

		<tr>
			<th><?= __('User Name') ?></th>
            <td><?= h($user->userName) ?></td>
        </tr>

		<tr>
			<th><?= __('User Type') ?></th>
            <td><?= h($user->user_type) ?></td>
        </tr>

		<tr>
			<th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
		
        <tr>
			<th><?= __('IP Registration') ?></th>
			<td><?= h($user->ip_register) ?></td>
		</tr>

		<tr>
			<th><?= __('IP Verify Email') ?></th>
			<td><?= h($user->ip_verify_email) ?></td>
		</tr>

        <tr>
			<th><?= __('IP Reset Password') ?></th>
			<td><?= h($user->ip_reset_password) ?></td>
		</tr>

        <tr>
			<th><?= __('Key Verify Email Expiration') ?></th>
			<td><?= h($user->key_verify_email_expire) ?></td>
		</tr>

        <tr>
			<th><?= __('Key Reset Password') ?></th>
			<td><?= h($user->key_reset_password) ?></td>
		</tr>

        <tr>
			<th><?= __('Key Reset Pasword Expiration') ?></th>
			<td><?= h($user->key_reset_password_expire) ?></td>
		</tr>
				
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
</div>
