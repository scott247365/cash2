
<?php

if (!isset($bg))
	$bg = '#00A6F4';
if (!isset($fg))
	$fg = 'gray';
if (!isset($fg2))
	$fg2 = 'white';

?>

<div style='padding: 30px 0 50px 0; color:<?php echo $fg; ?>; background-color:<?php echo $bg; ?>;'>
		
	<?php echo $this->Form->create('', ['class' => 'form-horizontal', 'style' => 'padding-top: 50px;']); ?>
         	
		<div class="center" style="color: <?php echo $fg2; ?>; margin-bottom: 10px;">
			<span id="" style="font-size: 3em;"><span id='showRateFrontPage'>Loading...</span></span>
		</div>
		
		<div class="center" style="color: <?php echo $fg2; ?>; margin-bottom: 30px;">
			<span style="font-size: 2em;"><span id='rateQuote'></span></span>
		</div>
		
		<div class="form-group center">
			<?php echo $this->Form->input('conv', ['id' => 'TransactionAmount', 'div' => false, 'label' => false, 'value' => '1.00', 'style' => 'font-size:2em; padding: 10px; width: 150px;']); ?>
			<button id="btnCalculate">Go</button>
		</div>
		
		<div class="form-group center">
			<?php 
				echo $this->Form->input('convert', [
						'id' => 'TransactionConvert',
						'style' => 'padding:10px; font-size:2em;',
						'type' => 'select',
						'options' => ['EUR to USD','GBP to USD','USD to EUR','USD to GBP'], 
						'label' => false
					]); 
			?>
		</div>

	<?php echo $this->Form->end(); ?>
	
</div>

<script src="/js/currency_converter.js"></script>

<script>

$(document).ready(

	function()
	{
		convert();
	}
);

$("#btnCalculate").click 
(
    function (e)
    {
		loading('Calculating...');
        e.preventDefault(); 
		convert();
        return false;  
    } 
);

$("#TransactionConvert").change 
(
    function (e)
    {
		loading('Converting...');
 		convert();
    } 
);

function loading(msg)
{
	$("#showRateFrontPage").html(msg);
}

</script>