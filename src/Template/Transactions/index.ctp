<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>
<?php echo $this->Html->script('setfiltercat'); ?>

		<div id="subheader">
			<div class='ulmenu submenu'>
			
			<?php 
				$active= array(
				'All Dates' => '',
				'Show All' => '',				
				'All Accounts' => '',				
				);
				
				if (!isset($month) || $month <= 0)
				{
					$active['All Dates'] = "class=\"active\"";
				}
				
				//echo $account_id;
				if (!isset($account_id) || $account_id <= 0)
				{
					$active['All Accounts'] = "class=\"active\"";
				}			
			?>
			
			<ul class="nav nav-pills" role="tablist">
				<li role="presentation"><?php echo $this->Html->link('Add', '/transactions/add'); ?></li>
				<li role="presentation"><?php echo $this->Html->link('Show All', "/transactions/"); ?></li>
				<li role="presentation" <?php echo $active['All Accounts']; ?>><?php echo $this->Html->link('All Accounts', "/transactions/index?mon=$month&cat=$cat&sub=$sub"); ?></li>
				
				<?php $parms = "par=$account_id&mon=$month&cat="; ?>
				
				<li>

				<?php echo $this->Form->input('category', array('selected' => $cat, 'label' => false, 'type' => 'select', 'options' => $categories, 'onchange' => "javascript:navTo(this.value, 'index?$parms')", 'style' => 'margin: 3px; padding: 5px; font-size: 15pt;'));
?>
</li>
				<li role="presentation" <?php echo $active['All Dates']; ?>><?php echo $this->Html->link('All Dates', "/transactions/index?allDates=1&par=$account_id&cat=$cat&sub=$sub"); ?></li>
			</ul>
			</div>
		</div>
		
        <!-- li role="presentation" class="active"><a href="#">Home</a></li -->
		<?php 
			// show which month menu item is active
			$queryMonth = 0;
			$queryYear = 0;
			if (isset($month) && $month > 0)
				$queryMonth = intval($month);
			if (isset($year) && $year > 0)
				$queryYear = intval($year);
				
			//debug(intval($month));die;	
		?>
		
		<div id="subheader">
			<div>
				<div class='visible-xs'><!-- only xs -->
				<?php 
					//
					// show month dropdown instead of month buttons
					//
					$parms = "par=$account_id";
					
					$months = ['All Dates', 'January', 'February','March','April','May','June','July','August','September','October','November','December'];
					
					$years = ['2015','2016','2017'];
					$year = '2016';
					
					echo $this->Form->input('month', array('selected' => 'October', 'label' => false, 'type' => 'select', 'options' => $months, 'onchange' => "javascript:navDate('index?$parms', this.value, $year)", 'style' => 'margin: 3px; padding: 5px; font-size: 15pt;')); 
					
					echo $this->Form->input('year', array('selected' => '2016', 'label' => false, 'type' => 'select', 'options' => $years, 'onchange' => "javascript:navDate('index?$parms', 2, this.value])", 'style' => 'margin: 3px; padding: 5px; font-size: 15pt;')); 
					
				?>
				</div>

				<!-------------------------------------------------------------
				// show month buttons instead of month dropdown
				-------------------------------------------------------------->
				
				<div class='visible-sm visible-md visible-lg visible-xl'><!-- all but xs -->

				<ul class="nav nav-pills" role="tablist">
					<?php foreach($monthLinks as $mon => $link) : 
					
						$linkMonth = $link['month'];
						$linkYear = $link['year'];
					
						$my = '&mon=' . $linkMonth . '&year=' . $linkYear;
						
						$active = '';
						if ($queryMonth == $linkMonth && $queryYear == $linkYear)
							$active = "class=\"active\"";					
					?>
						<li role="presentation" <?php echo $active; ?>><?php echo $this->Html->link($mon, "/transactions/index?par=$account_id&cat=$cat&sub=$sub&desc=$desc&$my"); ?></li>
					<?php endforeach; ?>
				</ul>
				</div>
			</div>
		</div>
		
	
	<!---------------------------------------------- -->
	<!-- big screen table ------------------------- -->
	<!---------------------------------------------- -->

<div class='visible-sm visible-md visible-lg visible-xl'>
	<h3><?php echo __d('cake_dev', 'Transactions (' . sizeof($records) . '), Total: ' . $total); ?></h3>
	<table class='table table-striped'>
	
	<?php foreach ($records as $rec): ?>
				
		<tr>
					
			<td style='min-width: 110px;' >
				<a href='<?= '/transactions/edit/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a>
				<a href='<?= '/transactions/dupe/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a>
				<a href='<?= '/transactions/delete/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a>
			</td>

			<td style='min-width: 100px;' ><?php echo $rec['date']; ?></td>
			
			<td><?php echo $rec['amount']; ?></td>
			
			<td>
				<?php
					$d = $rec['description'];
					$link = "/transactions/index?sort=$sort&par=$account_id&mon=$month&cat=$cat&sub=$sub&desc=$d ";
					echo $this->Html->link($rec['description'], $link); 
				?>
			</td>			
			
			<td style='width: 200px;'><?php echo $rec['notes']; ?></td>
			
			<td></td>
						
			<?php
				$parent_id = $rec['parent_id'];
				$link = "/transactions/index?sort=$sort&par=$parent_id&mon=$month&cat=$cat&sub=$sub&desc=$desc";			
			?>
						
			<td style="font-size:85%;"><?php echo $this->Html->link($rec['Account']['name'], $link); ?></td>			
			
			<?php if ($rec['Subcategory']['name'] != NULL) : ?>
				<td style="font-size:85%;"><?php 
					echo $this->Html->link($rec['Category']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&cat=' . $rec['Category']['id']);
					echo '::';
						echo $this->Html->link($rec['Subcategory']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&sub=' . $rec['Subcategory']['id']); ?>
				</td>
			<?php else: ?>
				<td style="font-size:85%;">
					<?php echo $this->Html->link($rec['Category']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&cat=' . $rec['Category']['id']); ?>
				</td>
			<?php endif; ?>
			
			<td class="visible-lg"><?php 
				if ($rec['type'] == '1')
					echo 'Expense'; 
				else if ($rec['type'] == '2')
					echo 'Income'; 
				else if ($rec['type'] == '3')
					echo 'Transfer'; 
				else
					echo $rec['type'];
			?></td>
			
		</tr>
						
	<?php endforeach; ?>	
	<?php unset($rec); ?>
	
	</table>
</div>
	
	<!---------------------------------------------- -->
	<!-- small screen table ------------------------- -->
	<!---------------------------------------------- -->

<div class='visible-xs'>
	<h4><?php echo __d('cake_dev', 'Transactions (' . sizeof($records) . '), Total: ' . $total); ?></h4>
	<table>
	
	<?php foreach ($records as $rec): ?>
		
		<tr>
			<table class='table table-striped table-condensed' style='font-size:75%;'>
				<tr>
		
			<td style='min-width: 95px; max-width: 95px;' >
				<a href='<?= '/transactions/edit/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-edit"></span></a>
				<a href='<?= '/transactions/dupe/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-duplicate"></span></a>
				<a href='<?= '/transactions/delete/' . $rec['id'] ?>'><span class="glyphCustom glyphicon glyphicon-trash"></span></a>
			</td>
			
			<td style='width: 300px; font-size: <?php echo (strlen($rec['description']) > 10) ? '100' : '100'; ?>%;'><?php echo $rec['description']; ?></td>

			<td style='width: 200px;'><?php echo $rec['amount']; ?></td>
			
				</tr>
				<tr>	
				
			<!-- td><empty cell></td -->

			<td style='width: 100px;' ><?php echo $rec['date']; ?></td>
			
			<td colspan="1">
				<?php if ($rec['Subcategory']['name'] != NULL) : ?>
					<?php 
						echo $this->Html->link($rec['Category']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&cat=' . $rec['Category']['id']);
						echo '::';
							echo $this->Html->link($rec['Subcategory']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&sub=' . $rec['Subcategory']['id']); 
					?>
				<?php else: ?>
					<?php echo $this->Html->link($rec['Category']['name'], '/transactions/index?par=' . $account_id . '&mon=' . $month . '&cat=' . $rec['Category']['id']); ?>
				<?php endif; ?>
			</td>
			
			<td colspan="1">
				<?php 
					$parent_id = $rec['parent_id'];
					$link = "/transactions/index?sort=$sort&par=$parent_id&mon=$month&cat=$cat&sub=$sub";
					echo $this->Html->link($rec['Account']['name'], $link); 
				?>
			</td>			
				
				</tr>		
			</table>
		</tr>
						
	<?php endforeach; ?>	
	<?php unset($rec); ?>
	
	</table>
</div>	
	
	<!---------------------------------------------- -->
	<!-- END OF transaction table ------------------ -->
	<!---------------------------------------------- -->	
	
	<?php if (isset($total)) : ?>
		<h3 style='font-size: 14pt;'><?php echo __d('cake_dev', 'Total: $' . $total); ?></h3>
	<?php endif; ?>






