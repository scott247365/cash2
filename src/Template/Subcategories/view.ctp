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
				<li><?php echo $this->Html->link('Add', '/subcategories/add'); ?></li>
				<li><?php echo $this->Html->link('View', '/subcategories/view/' . $record['Subcategory']['id']); ?></li>
				<li><?php echo $this->Html->link('Delete', '/subcategories/delete/' . $record['Subcategory']['id']); ?></li>				
			</ul>
			</div>
		</div>
		
<div style="float: left;">
	<table>
		<tr><td>Id:</td><td><?php echo $record['Subcategory']['id']; ?></td></tr>
		<tr><td>Category:</td><td><?php echo $record['Subcategory']['parent_id']; ?></td></tr>
		<tr><td>Name:</td><td><?php echo $record['Subcategory']['name']; ?></td></tr>
	</table>
</div>

	






