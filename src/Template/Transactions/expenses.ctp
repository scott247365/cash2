<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

<div id="expenses">

<div id="subheader">
	<div class='ulmenu submenu'>
		<ul class="nav nav-pills" role="tablist">
		
		<?php 
			// show which month menu item is active
			$queryMonth = 0;
			$queryYear = 0;
			if (isset($month) && $month > 0)
				$queryMonth = intval($month);
			if (isset($year) && $year > 0)
				$queryYear = intval($year);
							
			foreach($monthLinks as $mon => $link)
			{
				$linkMonth = $link['month'];
				$linkYear = $link['year'];
					
				$my = '&mon=' . $linkMonth . '&year=' . $linkYear;
						
				$active = '';
				if ($queryMonth == $linkMonth && $queryYear == $linkYear)
				{
					$active = "class=\"active\"";					
				}

				echo "<li $active>" . $this->Html->link($mon, "/transactions/expenses/$linkMonth/$linkYear") . '</li>';
			}
		?>
					
		</ul>
	</div>
</div>
		
<!-- ----------------------------------- -->
<!-- Expense Subcategory Breakdown graph -->
<!-- ----------------------------------- -->

<div style='max-width: 700px;' xclass='summary-box'>
	<div style='text-align: center;'><h4>
<?php if (!empty($expenses)) : ?>
	<?php echo $smonth; ?> Expenses: <?php echo $expenses[0]['total']; ?>
<?php else: ?>
	<?php echo $smonth; ?> Expenses
<?php endif; ?>
	</h4></div>
	<table>
	<th>Category</th>
	<th>Subcategory</th>
	<th>Sub Total</th>
	<th>Total</th>
		<?php 
		$count = 0;
		$colors = array('#A2FAA0', '#FAFC6B');
		$colors = array('#FAFC6B', '#A0FAF3');
		$colors = array('#FAFC6B', 'LightGreen');
		foreach ($expenses as $rec): 
		
			$color = $colors[$count % 2];
		?>
			<tr style='background: <?php echo $color; ?>;'>
				<?php if ($rec[0]['tcount'] > 1): // if more than one subcat ?>

					<td><?php echo $this->Html->link($rec['Category']['name'], "/transactions/index?par=0&mon=$month&year=$year&cat=" . $rec['Category']['id'], array('style' => ' font-size: 120%;')); ?></td>	
					<td></td>
					<td></td>
					<td><?php echo $rec[0]['amount']; ?>
					</tr>
					<?php foreach ($rec['subs'] as $sub): ?>
						<tr style='background: <?php echo $color; ?>;'>
						<td></td>
						<td>
							<?php echo $this->Html->link($sub['Subcategory']['name'], "/transactions/index?par=0&mon=$month&year=$year&sub=" . $sub['Subcategory']['id'], array('style' => ' font-size: 120%;')); ?>
						</td>					
						<td><?php echo $sub[0]['amount']; ?></td>
						<td></td>
						</tr>
					<?php endforeach; ?>	
					
				<?php else: ?>
				
					<td>
						<?php echo $this->Html->link($rec['Category']['name'], "/transactions/index?par=0&mon=$month&year=$year&cat=" . $rec['Category']['id'], array('style' => ' font-size: 120%;')); ?>					</td>	
					
					<?php if (isset($rec['subs'])) : ?>
					<?php foreach ($rec['subs'] as $sub): ?>
						<td>
							<?php echo $this->Html->link($sub['Subcategory']['name'], "/transactions/index?par=0&mon=$month&year=$year&sub=" . $sub['Subcategory']['id'], array('style' => ' font-size: 120%;')); ?>
						</td>			
						<td></td>	
					<?php endforeach; ?>				
					<?php endif; ?>
					<td><?php echo $rec[0]['amount']; ?></td>	
					
				<?php endif; ?>
			</tr>
		<?php 						
			$count++;
			endforeach; 
		?>
	<?php unset($rec); ?>
	</table>
</div>	

</div><!-- expenses -->