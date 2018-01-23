<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

<!-- ------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------ -->
<!-- THIS IS THE LOGGED-IN HOME / SUMMARY PAGE                                            -->
<!-- ------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------ -->

<div style='margin: 20px;'><!-- TODO: put a little space below the main menu --></div>


<!-- ------------------------------------------------------------------------------------ -->
<!-- -- Annual Totals box ------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------ -->
<?php if (true && isset($annual)) : ?>

<?php
	$sum = 0;
	foreach ($annual as $rec)
	{
		$amount = intval($rec[0]['total']);
		$sum += $amount;
	}
?>

<div class='summary-box'>
<div style='text-align: center;'><h4>Annual Net (<?= $sum ?>)</h4></div>
	<table class='table table-striped'>
	<th>Year</th>
	<th>Amount</th>
	
	<?php foreach ($annual as $rec): 	
		$year = $rec[0]['year'];
		$amount = intval($rec[0]['total']);
	?>
		<tr>				
			<td><?php echo $year; ?></td>
			<td><?php echo $amount; ?></td>			
		</tr>
		
	<?php endforeach; ?>
	<?php unset($rec); ?>
	</table>
</div>	
<?php endif; ?>
		
		

<!-- ----------------------- -->
<!-- netto Monthly Net graph -->
<!-- ----------------------- -->

<div class='summary-box' style='min-height: 200px; min-width: 190px; '>
<div style='text-align: center;' >
	<h4 style="margin-bottom:0px;">Monthly Net</h4>
	<p><a style="margin-left:10px; font-size: .6em;" href="/accounts/home/all">(Show All)</a></p>
</div>

	<?php
		$cnt = 0;
		$graphWidth = 250;
		$fullWidth = 365;
		$graphStart = $fullWidth - $graphWidth;
		$width = $graphWidth / 2;
		$left_margin = 3;
		$scale = $maxgraph / $width; // 1 pixel = $scale amount
		
		// start loop through months
		foreach ($netto as $rec): 
		
		$credit = ($rec['net'] > 0.0);
	?>
		<?php if ($rec['date'] != 'YTD') : ?>			
			<canvas id="myCanvas<?php echo $cnt; ?>" width="<?php echo $fullWidth; ?>" height="30" style="border:1px solid #DADAED;">Your browser does not support the HTML5 canvas tag.</canvas><br />

<script>

var c = document.getElementById("myCanvas<?php echo $cnt; ?>");
var ctx = c.getContext("2d");

<?php if ($credit): ?>
	ctx.fillStyle = "blue";
<?php else : ?>
	ctx.fillStyle = "red";
<?php endif; ?>

// fill from middle to positive or negative value, scaled by 20
ctx.fillRect(<?php echo $width + $graphStart; ?>, 0, <?php echo $rec['net'] / $scale; ?>, 50);

ctx.fillStyle = "#6AB851";
ctx.fillRect(0, 0, <?php echo $graphStart; ?>, 50);

// show the Month and Net Amount on the graph bar
ctx.font = "18px Arial";
ctx.font = "18px Verdana";

ctx.fillStyle = "white";

<?php if (true): ?>
	ctx.fillText("<?php echo ($rec['date2']->format('M')) . ' $' . intval($rec['net']); ?>", <?php echo $left_margin; ?>, 22);
<?php endif; ?>
</script>
			<?php else: ?>	
			<!-- ?? -->
			<?php endif; ?>
			
	<?php $cnt++; endforeach; ?>
	<?php unset($rec); ?>
	
</div>
		
<!-- ------------------------------------------------------------------------------------ -->
<!-- -- Daily Net History box ------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------ -->
<?php if (false && isset($netto)) : ?>

<div class='summary-box'>
<div style='text-align: center;'><h4>Daily Net</h4></div>
	<table class='table table-striped'>
	<th>Month</th>
	<th>Daily Net</th>
	<th>Extrapolated Month</th>
	
	<?php foreach ($netto as $rec): 
	
		$dt = $rec['date2'];
		
		if (strtolower($rec['date']) == 'ytd')
			continue;
		
		$nettoMonth = intval($rec['net']);
		$daysInMonth = intval($dt->format('t'));
		$month = intval($dt->format('m'));
		$year = intval($dt->format('Y'));

		$currDate = intval(date('d'));
		$currMonth = intval(date('m'));
		$currYear = intval(date('Y'));
		
		$date = $currDate;
		
		// for other months use $daysInMonth
		if ($currMonth != $month || $currYear != $year) // not current month || not current year
			$date = $daysInMonth;
	
		$avgSpent = $nettoMonth / $date; // net spent per day
		$avgSpentMonthly = $avgSpent * $daysInMonth;
		
		$avgSpent = number_format($avgSpent, 2);
		$avgSpentMonthly = number_format($avgSpentMonthly, 2);
		
		$rec['avgSpent'] = $avgSpent;
		$rec['avgSpentMonthly'] = $avgSpentMonthly;	
		
		//Debugger::dump($rec);
	?>
		<tr>				
			<td style='font-weight:bold; background: #6AB851; color: white;'><?php echo $rec['date2']->format('M Y'); ?></td>
			<td><?php echo $rec['avgSpent']; ?></td>
			<td><?php echo $rec['avgSpentMonthly']; ?></td>			
		</tr>
	<?php endforeach; ?>
	<?php unset($rec); ?>
	</table>
</div>	
<?php endif; ?>

<!-- ------------------------------------------------------------------------------------ -->
<!-- -- Daily Average Widget               ----------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------ -->
<?php if (false && isset($netto)) : ?>

<div class='summary-box' style='min-height: 200px; min-width: 190px; text-align: center;'>

<h4>Daily Net</h4>

<?php 
	// get the index of the current/max month in the results list
	$month_idx = $maxDate->format('Y-m'); 		// get '2015-04' from date
	$month = strtoupper($maxDate->format('M')); // get 3 letter month names from date: APR
	$year = $maxDate->format('Y');				// get year
	$nettoMonth = intval($netto[$month_idx]['net']);
	$nettoYtd = intval($netto['ytd']['net']);
	
	$daysInMonth = date('t');
	$date = intval(date('d'));
	
	$avgSpent = $nettoMonth / $date; // net spent per day
	$avgSpentMonthly = $avgSpent * $daysInMonth;
	
	$avgSpent = number_format($avgSpent, 2);
	$avgSpentMonthly = number_format($avgSpentMonthly, 2);
		
	//Debugger::dump($netto);die;
?>

<div class='popout'><?php echo $month; ?></div>

<div style='font-size: 100%; color: #6AB851;'>Average Daily Net:</div>
<span style='font-size: 150%; padding: 0; margin: 0;'>$</span><span style='font-size: 250%;padding: 0; margin: 0;'><?php echo $avgSpent; ?></span>

<div style='font-size: 100%; color: #6AB851;'>Extrapolated Monthly Net:</div>
<div style='color: black; font-size: 150%;'>$<?php echo $avgSpentMonthly; ?></div>

</div>

<?php endif; ?>

<!-- ------------------------------------------------------------------------------------ -->
<!-- -- Monthly Netto Detail list box --------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------ -->

<?php if (true) : ?>

<div class='summary-box'>
<div style='text-align: center;'><h4>Monthly Net</h4></div>
	<table class='table table-striped'>
	<th>Month</th>
	<th>In</th>
	<th>Out</th>
	<th>Netto</th>
	<th></th>
	<?php foreach ($netto as $rec): ?>
		<tr>
			<?php if ($rec['date'] != 'YTD') : ?>
				<td style='background: #6AB851; color: white;'><?php echo strtoupper($rec['date2']->format('Y-M')); ?></td>
			<?php else: ?>			
				<td style='background: #6AB851; color: white;'><?php echo $rec['date']; ?></td>
			<?php endif; ?>
			
			<td><?php echo $rec['inc']; ?></td>			
			<td><?php echo $rec['exp']; ?></td>						
			<td><?php echo $rec['net']; ?></td>			

			<?php if ($rec['date'] != 'YTD') : ?>
				<td><?php 
					$mon = intval($rec['date2']->format('m'));
					$link = "/transactions/index?mon=$mon";				
					//echo $this->Html->link('Show', '/transactions/index/' . $link);				
					?>
					<a href='<?= '/transactions/index/' . $link ?>'><span style="font-size:1em"  class="glyphCustom glyphicon glyphicon-eye-open"></span></a>					
				</td>
			<?php else: ?>			
				<td>
					<?php //echo $this->Html->link('Show', '/transactions/index/' ); ?>
					<a href='<?= '/transactions/index/' ?>'><span style="font-size:1em"  class="glyphCustom glyphicon glyphicon-eye-open"></span></a>					
				</td>
			<?php endif; ?>
			
		</tr>
	<?php endforeach; ?>
	<?php unset($rec); ?>
	</table>
</div>	

<?php endif; ?>

<!-- ------------------------------------------------------------------------------------ -->
<!-- -- Netto MTD Box                     ----------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------ -->
<?php if (false && isset($nettoytd)) : ?>

<div class='summary-box' style='min-height: 200px; min-width: 190px; text-align: center;'>

<h4>Net MTD</h4>

<?php 
	// get the index of the current/max month in the results list
	$month_idx = $maxDate->format('Y-m'); 		// get '2015-04' from date
	$month = strtoupper($maxDate->format('M')); // get 3 letter month names from date: APR
	$year = $maxDate->format('Y');				// get year
	$nettoMonth = intval($netto[$month_idx]['net']);
	$nettoYtd = intval($netto['ytd']['net']);
?>

<?php if ($nettoMonth >= 0): ?>
	<span style='font-size: 150%; color: black; padding: 0; margin: 0;'>$</span><span style='font-size: 250%;padding: 0; margin: 0;'><?php echo $nettoMonth; ?></span>
<?php else : ?>
	<span style='font-size: 150%; color: red; padding: 0; margin: 0;'>$</span><span style='color: red; font-size: 250%;padding: 0; margin: 0;'><?php echo $nettoMonth; ?></span>
<?php endif; ?>

<div class='popout'><?php echo $month; ?></div>

<span style='color: black; font-size: 110%;'>$<?php echo intval($netto[$month_idx]['inc']); ?></span>

<span style='color: red; font-size: 110%;'> - $<?php echo abs(intval($netto[$month_idx]['exp'])); ?></span>

</div>

<?php endif; ?>

<!-- ------------------------------------------------------------------------------------ -->
<!-- -- Netto YTD Box                     ----------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------ -->

<?php if (false && isset($nettoytd)) : ?>

<div class='summary-box' style='min-height: 200px; min-width: 190px; text-align: center;'>

<h4>Net YTD</h4>

<?php if ($nettoYtd >= 0): ?>
<span style='font-size: 150%; color: black; padding: 0; margin: 0;'>$</span><span style='font-size: 250%;padding: 0; margin: 0;'><?php echo $nettoYtd; ?></span>
<?php else : ?>
<span style='font-size: 150%; color: red; padding: 0; margin: 0;'>$</span><span style='color: red; font-size: 250%;padding: 0; margin: 0;'><?php echo $nettoYtd; ?></span>
<?php endif; ?>


<div class='popout'><?php echo $year; ?></div>

<span style='color: black; font-size: 110%;'>$<?php echo intval($netto['ytd']['inc']); ?></span>

<span style='color: red; font-size: 110%;'> - $<?php echo abs(intval($netto['ytd']['exp'])); ?></span>

</div>

<?php endif; ?>

<!-- ------------------------------------------------------------------------------------ -->
<!-- -- Account Balances box ------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------ -->

<div class='summary-box'>
<div style='text-align: center;'><h4>Account Balances</h4></div>
	<table class='table table-striped'>
	<!-- th></th -->
	<th>Account</th>
	<th>Balance</th>
	<th>Transactions</th>
	<?php foreach ($records as $rec): ?>
		<tr>
			<!-- ?php if (isset($rec['Account']['id'])) : ?>
				<td><?php echo $this->Html->link('Edit', '/accounts/edit/' . $rec['Account']['id']); ?></td>
			< ?php else: ?>			
				<td></td>
			< ?php endif; ? -->
				
			<?php if (isset($rec['Account']['id'])) : ?>
				<td style='background: #6AB851; color: white;'><?php echo $rec['Account']['name']; ?></td>
				<td><?php echo $rec['Account']['balance']; ?></td>
			
				<td>
					<?php //echo $this->Html->link('Add', '/transactions/add/' . $rec['Account']['id']) . '&nbsp;&nbsp;'; ?>					
					<a href='<?= '/transactions/add/' . $rec['Account']['id'] ?>'><span class="glyphCustom glyphicon glyphicon-plus-sign"></span></a>
					<a href='<?= '/transactions/transfer/' . $rec['Account']['id'] ?>'><span class="glyphCustom glyphicon glyphicon-transfer"></span></a>
					
					<?php 
						$parent_id = $rec['Account']['id'];
						$link = "/transactions/index?par=$parent_id";				
						//echo $this->Html->link('Show', '/transactions/index/' . $link);				
					?>
					<a href='<?= '/transactions/index/' . $link ?>'><span style="font-size:1em"  class="glyphCustom glyphicon glyphicon-eye-open"></span></a>					
					
				</td>

			<?php else: ?>
				<td><b><?php echo $rec['Account']['name']; ?></b></td>
				<td><b><?php echo $rec['Account']['balance']; ?></b></td>
				<td></td>
			<?php endif; ?>
			
		</tr>
	<?php endforeach; ?>
	<?php unset($rec); ?>
	</table>
</div>	

<!-- ----------------------------------- -->
<!-- Expense Subcategory Breakdown graph -->
<!-- ----------------------------------- -->

<?php if (!empty($expenses)) : ?>

<div class='summary-box'>
<div style='text-align: center;'><h4>
<?php if (!empty($expenses)) : ?>
	<?php echo $smonth; ?> Expenses: <?php echo $expenses[0]['total']; ?>
<?php else: ?>
	<?php echo $smonth; ?> Expenses
<?php endif; ?>
</h4></div>
	<table class='table table-striped'>
	<th>Category</th>
	<th>Subcategory</th>
	<th>Sub Total</th>
	<th>Total</th>
		<?php 
		$count = 0;
		$colors = array('#A2FAA0', '#FAFC6B');
		$colors = array('#FAFC6B', '#A0FAF3');
		
		foreach ($expenses as $rec): 
			$color = $colors[$count % 2];
		?>
			<tr style='background: <?php echo $color; ?>;'>
				
				<?php if ($rec[0]['tcount'] > 1): // if more than one subcat ?>

					<td><?php echo $rec['Category']['name']; ?></td>	
						<td></td>
						<td></td>
					<td><?php echo $rec[0]['amount']; ?>
					</tr>
					<?php foreach ($rec['subs'] as $sub): ?>
						<tr style='background: <?php echo $color; ?>;'>
						<td></td>
						<td><?php echo $sub['Subcategory']['name']; ?></td>			
						<td><?php echo $sub[0]['amount']; ?></td>
						<td></td>
						</tr>
					<?php endforeach; ?>	

				<?php else: ?>
				
					<td><?php echo $rec['Category']['name']; ?></td>	
					<?php foreach ($rec['subs'] as $sub): ?>
						<td><?php echo $sub['Subcategory']['name']; ?></td>			
						<td><?php //echo $sub[0]['amount']; ?></td>	
					<?php endforeach; ?>				
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

<?php endif; ?>

<div>
<!-- block amazon ad 
<iframe src="http://rcm-na.amazon-adsystem.com/e/cm?t=wwwwiltekincom&o=1&p=12&l=ur1&category=amazonhomepage&f=ifr&linkID=A3SSCD3C53APLV2U" width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
-->

</div>