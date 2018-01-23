<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-start'); ?>
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
    </ul>
</nav>

<script>

var loaded = false;
var template = null;


function loadTemplate(lang) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     //document.getElementById("preview3").innerHTML = this.responseText;
	 template = this.responseText;
    }
  };
  xhttp.open("GET", "/entries/get/" + lang, true);
  xhttp.send();
}

function flogcall()
{
	var name = $('#name').val().trim();
	var id = $('#property_id').val().trim().replace('(','').replace(')','');
	var position_other = $('#other').val();
	var property_name = $('#property_name').prop('checked');
	var callback = $('#callback').prop('checked');
	var reservation = $('#reservation').val().trim();
	var email = $('#email').val();

	//
	// sexo
	//
	var male = $('#sexo-male').prop('checked');
	var female = $('#sexo-female').prop('checked');
	var unknown = $('#sexo-unknown').prop('checked');

	//
	// position options
	//
	var position_owner = $('#position-owner').prop('checked');
	var position_manager = $('#position-manager').prop('checked');
	var position_frontdesk = $('#position-frontdesk').prop('checked');
	var position_reservations = $('#position-reservations').prop('checked');
	var position_other = $('#position-other').prop('checked');
	var position = '';	
	if (position_other)
	{
		position = $('#other').val();
	}
	else
	{
		if (position_owner) position = $('#position-owner').val();
		if (position_manager) position = $('#position-manager').val();
		if (position_frontdesk) position = $('#position-frontdesk').val();
		if (position_reservations) position = $('#position-reservations').val();
	}

	//
	// security callback options
	//
	var request_pin = $('#request-pin').prop('checked');
	var request_password = $('#request-password').prop('checked');
	var request_account = $('#request-account').prop('checked');
	var secure_request = '';	
	if (request_pin) secure_request = 'new ' + $('#request-pin').val();	
	if (request_password) secure_request = 'reset ' + $('#request-password').val();
	if (request_account) secure_request = $('#request-account').val() + ' related';

	var newline = '';
	newline = '\r\n';
	newline = '<br/>';
	var arrow = '+ ';
	//alert(name);
	
	// name and propety id
	var logPhone = '';
	if (name.length > 0)
		logPhone += arrow + 'Name: ' + name;
	if (id.length > 0)
		logPhone += newline + arrow + 'Property id: ' + id;

	// asked for property name
	logPhone += newline + arrow + 'Property name: ' + (property_name ? 'yes' : 'no');
		
	// position
	logPhone += newline + arrow + 'Position: ' + position;
		
	// security callback / reason
	logPhone += newline + arrow + 'Security Callback: ' + (callback ? 'yes' : 'no');
	if (secure_request.length > 0) 
		logPhone += newline + arrow + 'Request: ' + secure_request;
		
	// Optional: reservation
	if (reservation.length > 0)
		logPhone += newline + arrow + 'Reservation id: ' + reservation;
	
	var reason = $('#reason').val();
	if (reason.length > 0)
		logPhone += newline + reason;	
	
	if (request_pin)
	{
		logPhone += newline + 'H called to request a new security PIN.  Called them back and gave it to them.'
	}
	else if (request_password)
	{
		logPhone += newline + 'H called to request a password reset.  Called them back and gave it to them.'
	}	
			
	$('#preview').html(logPhone);
			
	var merge = template.replace('{{body}}', email);
	
	if (name.length > 0)
	{
		if (male)
		{
			merge = merge.replace('Estimado/a', 'Estimado');
			merge = merge.replace('colaborador/a', name);
			merge = merge.replace('Partner', name);
		}
		else if (female)
		{
			merge = merge.replace('Estimado/a', 'Estimada');
			merge = merge.replace('colaborador/a', name);
			merge = merge.replace('Partner', name);
		}
		else
		{
			merge = merge.replace('colaborador', name);
			merge = merge.replace('Partner', name);
		}
	
	}
	
	$('#preview2').html(merge);
	
	var email_lang1 = "You contacted us for help with ";
	var email_lang2 = "Nos ha contactado para pedir ayuda con ";
	if ($('#language-lang1').prop('checked') && $('#email').val().length == 0)
		$('#email').val(email_lang1);
	if ($('#language-lang2').prop('checked') && $('#email').val().length == 0)
		$('#email').val(email_lang2);
}

function openProperty()
{
	var id = $('#property_id').val();
	var link = "https://cs.booking.com/desktop/hotel/details/#!/hotel_id=" + id;
	window.open(link);	
}

function openPropertyTed()
{
	var id = $('#property_id').val();
	var link = "https://cs.booking.com/desktop/hotel/details/#!/hotel_id=" + id;
	window.open(link);	
}

function openReservation()
{
	var hotel = $('#property_id').val();
	var rez = $('#reservation').val();	
	var link = "https://admin.booking.com/hotel/hoteladmin/extranet_ng/manage/booking.html?hotel_id=" + hotel + "&lang=xu&res_id=" + rez;
	window.open(link);	
}

function openReservationTed()
{
	var id = $('#reservation').val();	
	var link = "https://cs.booking.com/desktop/reservation/details/#!/reservation_id=" + id;

	window.open(link);	
}


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

				<!------------------------------------------------------------------>
				<!-- Language -->
				<!------------------------------------------------------------------>
				
				<div style="float:left;">
				
					<?php echo $this->Form->radio(
						'language',
						[
							['value' => 'lang1', 'text' => 'English', 'onclick' => 'loadTemplate(1)'],
							['value' => 'lang2', 'text' => 'Spanish', 'onclick' => 'loadTemplate(2)'],
						],
						['onclick' => 'flogcall()']
					);?>
					
					&nbsp;&nbsp;&nbsp;<label for="toolate"><?= $this->Form->checkbox('toolate', ['onclick' => 'flogcall()', 'id' => 'toolate']) ?>&nbsp;Too Late To Call</label><br/>
					
				</div>

				<!------------------------------------------------------------------>
				<!-- Caller Name -->
				<!------------------------------------------------------------------>
				
				<div style="clear:both;">
					<?php echo $this->Form->text('name', ['onfocusout' => 'flogcall()', 'placeholder' => 'Name', 'label' => true, 'id' => 'name', 'style' => 'width:200px;float:left;', 'class' => 'form-control marginBottom10']); ?>
					
				<?php echo $this->Form->radio(
					'sexo',
					[
						['value' => 'male', 'text' => 'Male', 'onclick' => 'flogcall()'],
						['value' => 'female', 'text' => 'Female', 'onclick' => 'flogcall()'],
						['value' => 'unknown', 'text' => 'Unknown', 'onclick' => 'flogcall()'],
					],
					['onclick' => 'flogcall()', 'value' => 'male']
				);?>					
					
				</div>
				<!------------------------------------------------------------------>
				<!-- Property ID -->
				<!------------------------------------------------------------------>
				
				<div style="clear:both;">
					<?php echo $this->Form->text('property_id', ['onfocusout' => 'flogcall()', 'placeholder' => 'Property ID', 'div' => false, 'label' => true, 'id' => 'property_id', 'style' => 'width:200px;float:left;', 'class' => 'form-control marginBottom10']); ?>
					
					<span style="font-size:11px; margin:10px;"><a href='#' onclick="javascript:openPropertyTed();">Open in TED</a></span>
				</div>
				
				<div style="clear:both;">
					<label for="property_name"><?= $this->Form->checkbox('property_name', ['onclick' => 'flogcall()', 'id' => 'property_name']) ?>&nbsp;Asked for Property Name</label><br/>
				</div>
				
				<!------------------------------------------------------------------>
				<!-- Caller Position -->
				<!------------------------------------------------------------------>
				
				<span style="margin-right:10px; font-size:20px;">Position:</span>

				<?php echo $this->Form->radio(
					'position',
					[
						['value' => 'owner', 'text' => 'Owner', 'onclick' => 'flogcall()'],
						['value' => 'manager', 'text' => 'Manager', 'onclick' => 'flogcall()'],
						['value' => 'frontdesk', 'text' => 'Frontdesk', 'onclick' => 'flogcall()'],
						['value' => 'reservations', 'text' => 'Reservations', 'onclick' => 'flogcall()'],
						['value' => 'other', 'text' => 'Other', 'onclick' => 'flogcall()'],
					],
					['onclick' => 'flogcall()']
				);?>
								
				<?php echo $this->Form->text('other', ['id' => 'other', 'onfocusout' => 'flogcall()', 'placeholder' => 'Other Position', 'div' => false, 'class' => 'form-control marginBottom10']); ?>

				<!------------------------------------------------------------------>
				<!-- Security Call-back and Short-cuts -->
				<!------------------------------------------------------------------>
				
				<label for="callback"><?= $this->Form->checkbox('callback', ['onclick' => 'flogcall()', 'id' => 'callback']) ?>&nbsp;Security Callback</label>

				<?php echo $this->Form->radio(
					'request',
					[
						['value' => 'pin', 'text' => 'New PIN', 'onclick' => 'flogcall()'],
						['value' => 'password', 'text' => 'Reset Password', 'onclick' => 'flogcall()'],
						['value' => 'account', 'text' => 'Update Account', 'onclick' => 'flogcall()'],
						['value' => 'none', 'text' => 'None', 'onclick' => 'flogcall()'],
					],
					['onclick' => 'flogcall()']
				);?>
								
				<!------------------------------------------------------------------>
				<!-- Reservation ID -->
				<!------------------------------------------------------------------>
				
				<div style="min-width:500px;">
					<?php echo $this->Form->text('reservation', ['onfocusout' => 'flogcall()', 'placeholder' => 'Reservation ID', 'label' => true, 'id' => 'reservation', 'style' => 'width:300px;float:left;', 'class' => 'form-control marginBottom10']); ?>
					
					<span style="font-size:11px; margin:5px; padding-top:5px;"><a href='#' onclick="javascript:openReservationTed();">Open in TED</a></span>
					<span style="font-size:11px; margin:5px; padding-top:5px;"><a href='#' onclick="javascript:openReservation();">Open in Extranet</a></span>					
				</div>
				
				<!------------------------------------------------------------------>
				<!-- Big Text Boxes -->
				<!------------------------------------------------------------------>
				<div style="clear:both;">
				<div style="xbackground-color: yellow; float:left; width:40%;margin-right: 1%;">
					<div>
						<a href='#' onclick='javascript:clearText("#reason");flogcall();'><span style="" class="glyphCustom glyphicon glyphicon-remove"></span></a>
					</div>
					<div style="">
						<?= $this->Form->textarea('reason', ['onfocusout' => 'flogcall()', 'xonkeyup' => 'flogcall()', 'id' => 'reason', 'value' => 'H called about ', 'style' => 'height:200px;', 'class' => 'form-control marginBottom10']); ?>
					</div>
				</div>
				
				<div style="xbackground-color: orage; float:left; width:57%;margin-right: 1%;">
					<div>
						<a href='#' onclick='javascript:clearText("#email");'><span style="" class="glyphCustom glyphicon glyphicon-remove"></span></a>
					</div>
					<div style="">
						<?= $this->Form->textarea('email', ['onfocusout' => 'flogcall()', 'xonkeyup' => 'flogcall()', 'id' => 'email', 'style' => 'height:200px;', 'class' => 'form-control marginBottom10']); ?>
					</div>
				</div>
				</div>
				
				<!------------------------------------------------------------------>
				<!-- Save Button -->
				<!------------------------------------------------------------------>
				<div style="clear:both;">
				<?= $this->Form->button('Save', array('id' => 'go', 'class' => 'btn btn-primary btn-sm')); ?>
				</div>
				
			</fieldset>
								
		<?= $this->Form->end() ?>	
	</div>

	<!------------------------------------------------------------------>
	<!-- Right Panel - Preview -->
	<!------------------------------------------------------------------>
	
	<div class="panel" id="previewdiv">
		<div><a href='#' onclick="javascript:clipboardCopy('preview', 'preview');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a></div>
		<span id="preview"></span>
	</div>
	<div class="panel" id="previewdiv2">
		<div><a href='#' onclick="javascript:clipboardCopy('preview2', 'preview2');"><span class="glyphCustom glyphicon glyphicon-copy"></span></a></div>
		<span id="preview2"></span>
	</div>

</div>