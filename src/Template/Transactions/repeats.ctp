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
			<ul>
				<li><?php echo $this->Html->link('Add', '/transactions/add'); ?></li>
			</ul>
			</div>
		</div>

<h3><?php echo __d('cake_dev', 'Repeat Transactions (' . sizeof($records) . ')'); ?></h3>

	<table>
	
    <tr>
        <th>Actions</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Recipient</th>
        <th>Description</th>
        <th>Account</th>
        <th>Category</th>
        <th>Type</th>
    </tr>
	<?php foreach ($records as $rec): ?>
		<tr>
			<td>
			<?php echo $this->Html->link('Add', '/transactions/add/' . $rec['Transaction']['parent_id']); ?>&nbsp;&nbsp;
			<?php echo $this->Html->link('View', '/transactions/view/' . $rec['Transaction']['id']); ?>&nbsp;&nbsp;
			<?php echo $this->Html->link('Edit', '/transactions/edit/' . $rec['Transaction']['id']); ?>&nbsp;&nbsp;
			<?php echo $this->Html->link('Delete', '/transactions/delete/' . $rec['Transaction']['id']); ?>
			</td>

			<td><?php echo $rec['Transaction']['date']; ?></td>
			<td><?php echo $rec['Transaction']['amount']; ?></td>
			<td><?php echo $rec['Transaction']['description']; ?></td>
			<td style='width: 200px;'><?php echo $rec['Transaction']['notes']; ?></td>
			
			<td><?php 
				$parent_id = $rec['Transaction']['parent_id'];
				$link = "/transactions/index?sort=$sort&par=$parent_id&mon=$month&cat=$cat&sub=$sub";
				echo $this->Html->link($rec['Account']['name'], $link); 
			?></td>
			
			<?php if ($rec['Subcategory']['name'] != NULL) : ?>
					<td><?php 
						echo $this->Html->link($rec['Category']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&cat=' . $rec['Category']['id']);
						echo '::';
						echo $this->Html->link($rec['Subcategory']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&sub=' . $rec['Subcategory']['id']); ?>
						</td>
			<?php else: ?>
					<td><?php echo $this->Html->link($rec['Category']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&cat=' . $rec['Category']['id']); ?></td>
			<?php endif; ?>
			
			<td><?php 
				if ($rec['Transaction']['type'] == '1')
					echo 'Expense'; 
				else if ($rec['Transaction']['type'] == '2')
					echo 'Income'; 
				else if ($rec['Transaction']['type'] == '3')
					echo 'Transfer'; 
				else
					echo $rec['Transaction']['type'];
			?></td>
		</tr>
	<?php endforeach; ?>	
	<?php unset($rec); ?>
	
	</table>	
	
	<?php if (isset($total)) : ?>
		<h3 style='font-size: 14pt;'><?php echo __d('cake_dev', 'Total: $' . $total); ?></h3>
	<?php endif; ?>






