<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

		<div id="subheader">
			<div class='ulmenu submenu'>
			<ul class="nav nav-pills" role="tablist">
				<li><?php echo $this->Html->link('Add', '/accounts/add'); ?></li>
				<li><?php echo $this->Html->link('Show All', '/accounts/hidden'); ?></li>
			</ul>
			</div>
		</div>

<h3><?php echo __d('cake_dev', 'Accounts (' . sizeof($records) . ')'); ?></h3>

	<table class='table table-striped'>
	
    <tr>
        <th>Actions</th>
        <th>Name</th>
        <th>Balance</th>
        <th>Notes</th>
        <th>Status</th>
        <th>Starting Bal</th>
    </tr>
	<?php foreach ($records as $rec): ?>
		<tr>
			<td>
				<!--
				<?php echo $this->html->link('View', '/accounts/view/' . $rec['id']); ?>&nbsp;&nbsp;
				<?php echo $this->html->link('Edit', '/accounts/edit/' . $rec['id']); ?>&nbsp;&nbsp;
				<?php echo $this->html->link('Delete', '/accounts/delete/' . $rec['id']); ?>&nbsp;&nbsp;
				-->
				
				<a href='<?= '/transactions/transfer/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-transfer"></span></a>
				<a href='<?= '/accounts/edit/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a>
				<a href='<?= '/accounts/view/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-eye-open"></span></a>
				<a href='<?= '/accounts/delete/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a>
			<td><?php 
				$parent_id = $rec['id'];
				$link = "/transactions/index?par=$parent_id";
				echo $this->Html->link($rec['name'], $link); 
			?></td>			
			
			<td><?php echo $rec['balance']; ?></td>
			<td><?php echo $rec['notes']; ?></td>
			<td><?php echo (intval($rec['hidden']) == 1 ? 'Hidden' : 'Normal'); ?></td>
			<td><?php echo $rec['starting_balance']; ?></td>
		</tr>
	<?php endforeach; ?>
	<?php unset($rec); ?>

	</table>	
	<h3 style='font-size: 14pt;'><?php echo __d('cake_dev', 'Total: $' . $total); ?></h3>






