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
				<li><?php echo $this->Html->link('Add', '/transactions/add'); ?></li>
				<li><?php echo $this->Html->link('Edit', '/transactions/edit/' . $record['Transaction']['id']); ?></li>
				<li><?php echo $this->Html->link('Delete', '/transactions/delete/' . $record['Transaction']['id']); ?></li>				
			</ul>
			</div>
		</div>
	
<h3><?php echo __d('cake_dev', 'Transaction: ' . $record['Transaction']['description']); ?></h3>
	
<div style="float: left;">
	<table>
		<tr><td>ID:</td><td><?php echo $record['Transaction']['id']; ?></td></tr>
		<tr><td>Date:</td><td><?php echo $record['Transaction']['date']; ?></td></tr>
		<tr><td>Name:</td><td><?php echo $record['Transaction']['description']; ?></td></tr>
		<tr><td>Account:</td><td><?php echo $record['Transaction']['parent_id']; ?></td></tr>
		<tr><td>Amount:</td><td><?php echo $record['Transaction']['amount']; ?></td></tr>
		<tr><td>Category:</td><td><?php echo $record['Transaction']['category']; ?></td></tr>
		<tr><td>Subcategory:</td><td><?php echo $record['Transaction']['subcategory']; ?></td></tr>
		<tr><td>Type:</td><td><?php echo $record['Transaction']['type']; ?></td></tr>
		<tr><td>Type:</td><td><?php echo $record['Transaction']['notes']; ?></td></tr>
	</table>
</div>

	






