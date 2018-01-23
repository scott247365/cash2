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
				<li><?php echo $this->Html->link('Add', '/categories/add'); ?></li>
				<li><?php echo $this->Html->link('View', '/categories/view/' . $record['Category']['id']); ?></li>
				<li><?php echo $this->Html->link('Delete', '/categories/delete/' . $record['Category']['id']); ?></li>				
			</ul>
			</div>
		</div>
		
<div style="float: left;">
	<table>
		<tr><td>ID:</td><td><?php echo $record['Category']['id']; ?></td></tr>
		<tr><td>Name:</td><td><?php echo $record['Category']['name']; ?></td></tr>
	</table>
</div>

	






