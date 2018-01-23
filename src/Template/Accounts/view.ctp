<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

		<div id="subheader" >
			<div class='ulmenu submenu'>
			<ul>
				<li><?php echo $this->Html->link('Add', '/accounts/add'); ?></li>
				<li><?php echo $this->Html->link('Edit', '/accounts/edit/' . $record['Account']['id']); ?></li>
				<li><?php echo $this->Html->link('Delete', '/accounts/delete/' . $record['Account']['id']); ?></li>				
			</ul>
			</div>
		</div>
	
<h3><?php echo __d('cake_dev', 'Account: ' . $record['Account']['name']); ?></h3>
	
<div class="users form">
<?php echo $this->Form->create('Account', ['class' => 'form-horizontal']); ?>
    <fieldset>		
		
	<table>
		<tr><td>ID:</td><td><?php echo $record['Account']['id']; ?></td></tr>
		<tr><td>Name:</td><td><?php echo $record['Account']['name']; ?></td></tr>
		<tr><td>User:</td><td><?php echo $record['Account']['user_id']; ?></td></tr>
		<tr><td>Starting Balance:</td><td><?php echo $record['Account']['starting_balance']; ?></td></tr>
		<tr><td>Current Balance:</td><td><?php echo $record['Account']['balance']; ?></td></tr>
		<tr><td>Account Type:</td><td><?php echo $record['Account']['account_type_name']; ?></td></tr>
		<tr><td>Notes:</td><td><?php echo $record['Account']['notes']; ?></td></tr>
		<tr><td>Password Hint:</td><td><?php echo $record['Account']['password_hint']; ?></td></tr>
		<tr><td>Linked Accounts:</td><td><?php echo $record['Account']['linked_accounts']; ?></td></tr>
		<tr><td>Hidden:</td><td><?php echo (intval($record['Account']['hidden']) == 0 ? 'No' : 'Yes'); ?></td></tr>
		<tr><td>Created:</td><td><?php echo $record['Account']['created']; ?></td></tr>
		<tr><td>Modified:</td><td><?php echo $record['Account']['modified']; ?></td></tr>		
	</table>
	
	    <div class="form-group" style="margin-top: 30px; margin-left: 0px;">
			<?php echo $this->Form->button('Close', ['class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'location.href=\'/accounts/index\'']); ?>			
        </div>	
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>

	






