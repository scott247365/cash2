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
				<li><?php echo $this->Html->link('Add', '/subcategories/add'); ?></li>
				<li><?php echo $this->Html->link('Categories', '/categories/'); ?></li>
			</ul>
			</div>
		</div>

<h3><?php echo __d('cake_dev', 'Subcategories (' . sizeof($records) . ')'); ?></h3>

	<table class='table table-striped'>
	
    <tr>
        <th>Actions</th>
        <th>Subcategory</th>
        <th>Category</th>
        <th>Notes</th>
    </tr>
	<?php foreach ($records as $rec): ?>
		<tr>
			<td><?php echo $this->html->link('View', '/subcategories/view/' . $rec['id']); ?>&nbsp;&nbsp;
			<?php echo $this->html->link('Edit', '/subcategories/edit/' . $rec['id']); ?>&nbsp;&nbsp;
			<?php echo $this->html->link('Delete', '/subcategories/delete/' . $rec['id']); ?></td>
			
			<td><?php 
				$link = '/transactions/index?sub=' . $rec['id'];
				echo $this->Html->link($rec['name'], $link); 
			?></td>

			<td><?php 
				$link = '/transactions/index?cat=' . $rec['Categories']['id'];
				echo $this->Html->link($rec['Categories']['name'], $link); 
			?></td>
			
			<td><?php echo $rec['notes']; ?></td>
		</tr>
	<?php endforeach; ?>
	<?php unset($rec); ?>

	</table>	






