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
				<li><?php echo $this->Html->link('Add', '/categories/add'); ?></li>
				<li><?php echo $this->Html->link('Subcategories', '/subcategories/'); ?></li>
			</ul>
			</div>
		</div>

<h3><?php echo __d('cake_dev', 'Categories (' . sizeof($records) . ')'); ?></h3>

	<table class='table table-striped'>
	
    <tr>
        <th>Actions</th>
        <th>Category</th>
        <th>Subcategory</th>
        <th>Notes</th>
        <th>Type</th>
    </tr>
	<?php foreach ($records as $rec): ?>
	<?php 	foreach ($rec['subcategories'] as $subcategories): ?>
		<tr>
			<td><?php echo $this->html->link('View', '/categories/view/' . $rec['id']); ?>&nbsp;&nbsp;
			<?php echo $this->html->link('Edit', '/categories/edit/' . $rec['id']); ?>&nbsp;&nbsp;
			<?php echo $this->html->link('Delete', '/categories/delete/' . $rec['id']); ?></td>

			<td><?php 
				$link = '/transactions/index?cat=' . $rec['id'];
				echo $this->Html->link($rec['name'], $link); 
			?></td>
			
			<td><?php 
				//dd($rec);
				$link = '/transactions/index?sub=' . $subcategories['id'];
				echo $this->Html->link($subcategories['name'], $link); 
			?></td>
			<td><?php echo $rec['notes']; ?></td>
	
			<td><?php 
				if ($rec['type'] == '1')
					echo 'Expense';
				else if ($rec['type'] == '2')
					echo 'Income';
				else if ($rec['type'] == '3')
					echo 'Transfer';
			
			?></td>
		</tr>
	<?php 	endforeach; ?>
	<?php endforeach; ?>
	<?php unset($rec); ?>

	</table>	






