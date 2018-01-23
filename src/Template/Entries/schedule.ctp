<script>

var loaded = false;
var template = null;

var curr_shift = null;

var times_shift1 = {
	'09:00' : '9:00', 
	'09:15' : '9:15',
	'09:30' : '9:30',
	'09:45' : '9:45',
	'10:00' : '10:00', 
	'10:15' : '10:15',
	'10:30' : '10:30',
	'10:45' : '10:45',
	'11:00' : '11:00', 
	'11:15' : '11:15',
	'11:30' : '11:30',
	'11:45' : '11:45',
	'12:00' : '12:00', 
	'12:15' : '12:15',
	'12:30' : '12:30',
	'12:45' : '12:45',
	'13:00' : '13:00', 
	'13:15' : '13:15',
	'13:30' : '13:30',
	'13:45' : '13:45',
	'14:00' : '14:00', 
	'14:15' : '14:15',
	'14:30' : '14:30',
	'14:45' : '14:45',
	'15:00' : '15:00', 
	'15:15' : '15:15',
	'15:30' : '15:30',
	'15:45' : '15:45',
	'16:00' : '16:00', 
	'16:15' : '16:15',
	'16:30' : '16:30',
	'16:45' : '16:45',
	'17:00' : '17:00', 
	'17:15' : '17:15',
	'17:30' : '17:30',
	'17:45' : '17:45',	
	};
				
var times_shift2 = {
	'15:00' : '3:00', 
	'15:15' : '3:15',
	'15:30' : '3:30',
	'15:45' : '3:45',
	'16:00' : '4:00', 
	'16:15' : '4:15',
	'16:30' : '4:30',
	'16:45' : '4:45',
	'17:00' : '5:00', 
	'17:15' : '5:15',
	'17:30' : '5:30',
	'17:45' : '5:45',
	'18:00' : '6:00', 
	'18:15' : '6:15',
	'18:30' : '6:30',
	'18:45' : '6:45',
	'19:00' : '7:00', 
	'19:15' : '7:15',
	'19:30' : '7:30',
	'19:45' : '7:45',
	'20:00' : '8:00', 
	'20:15' : '8:15',
	'20:30' : '8:30',
	'20:45' : '8:45',
	'21:00' : '9:00', 
	'21:15' : '9:15',
	'21:30' : '9:30',
	'21:45' : '9:45',
	'22:00' : '10:00', 
	'22:15' : '10:15',
	'22:30' : '10:30',
	'22:45' : '10:45',
	'23:00' : '11:00', 
	'23:15' : '11:15',
	'23:30' : '11:30',
	'23:45' : '11:45',	
	};
												
function start()
{
  setInterval(function() {
    var date = new Date(),
        time = date.toLocaleTimeString();
    $("#clock").html(time);
	
	setNextEvent();
	
  }, 1000);
};

function setNextEvent()
{
    var now = new Date();
    var target = new Date();
	
	// break1
	var timeAlarm = $("select#break1").val();
	var parts = timeAlarm.split(":");	
	target.setHours(parts[0]);
	target.setMinutes(parts[1]);
	
	var diff = target.getTime() - now.getTime();
	var diffTime = new Date(diff);
	
    //$("#show_break1").html(target.toLocaleTimeString());
    $("#countdown").html(diffTime.toLocaleTimeString());
}

function loadShift(shift)
{
	$("select#break1").empty();
	$("select#lunch").empty();
	$("select#break2").empty();
	
	if (shift == 1)
	{
		for (var key in times_shift1) 
		{
			let value = times_shift1[key];
			
			$("select#break1").append( $("<option>")
					.val(key)
					.html(value)
				);		
				
			$("select#lunch").append( $("<option>")
					.val(key)
					.html(value)
				);		
				
			$("select#break2").append( $("<option>")
					.val(key)
					.html(value)
				);		
		}
	}
	else if (shift == 2)
	{
		for (var key in times_shift2) 
		{
			let value = times_shift2[key];
			
			$("select#break1").append( $("<option>")
					.val(key)
					.html(value)
				);		
				
			$("select#lunch").append( $("<option>")
					.val(key)
					.html(value)
				);		
				
			$("select#break2").append( $("<option>")
					.val(key)
					.html(value)
				);		
		}
	}
	else 
	{
	}
}

start();

</script>

<style>

input[type="radio"] {
display: inline-block;
margin-left: 10px;
margin-right: 3px;
}

#body {
min-height:800px;
}
#form {
}
#preview {
}

.panel {
display: block;
float: left;
width: 45%;
margin:10px;
}

</style>

<div id="body">

	<!------------------------------------------------------------------>
	<!-- Left Panel - Form -->
	<!------------------------------------------------------------------>

	<div class="panel" id="form">

		<?= $this->Form->create() ?>
			<fieldset>		

				<?php		
					$times = null; //['' => ''];
				?>

				<div>
					<?php echo $this->Form->radio(
						'shift',
						[
							['value' => 'shift1', 'text' => 'Morning', 'onclick' => 'loadShift(1)'],
							['value' => 'shift2', 'text' => 'Afternoon', 'onclick' => 'loadShift(2)'],
							['value' => 'shiftall', 'text' => 'All Times', 'onclick' => 'loadShift(3)'],
						],
						['onclick' => 'flogcall()']
					);?>
				</div>
			
				<div style="">
					<label for="break1">First Break: 
						<?= $this->Form->select('break1', $times, ['id' => 'break1', 'onchange' => 'setNextEvent()', 'empty' => false, 'style' => 'font-size: 2em; font-weight:normal;']) ?>
					</label>
				</div>
				
				<div style="">
					<label for="lunch">Lunch: 
						<?= $this->Form->select('lunch', $times, ['id' => 'lunch', 'empty' => false, 'style' => 'font-size: 2em; font-weight:normal;']) ?>
					</label>
				</div>

				<div style="">
					<label for="break2">Second Break: 
						<?= $this->Form->select('break2', $times, ['id' => 'break2', 'empty' => false, 'style' => 'font-size: 2em; font-weight:normal;']) ?>
					</label>
				</div>
				
				<!------------------------------------------------------------------>
				<!-- Save Button -->
				<!------------------------------------------------------------------>
				<div style="clear:both;">
				<?= $this->Form->button('Go', array('id' => 'go', 'class' => 'btn btn-primary btn-sm')); ?>
				</div>
				
			</fieldset>
								
		<?= $this->Form->end() ?>	
	</div>

	<!------------------------------------------------------------------>
	<!-- Right Panel - Preview -->
	<!------------------------------------------------------------------>
	
	<div class="panel" id="previewdiv">
		<div id="clock" style="font-size:3em;"></div>
		<div><span id="show_break1" style="font-size:3em;"></span></div>
		<div><span id="countdown" style="font-size:3em;"></span></div>
	</div>
	<div class="panel" id="previewdiv2">
		<div>
		</div>
	</div>

</div>