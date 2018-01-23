<nav class="large-3 medium-4 columns" id="submenu">
    <ul class="submenu">
		<?= $this->element('menu-icons-links'); ?>
		<li class="topMenuLiCenterInput"><?= $this->element('form-search') ?></li>
    </ul>
</nav>

<script>


function flogcall()
{
	var name = $('#name').val();
	var id = $('#property_id').val();
	var position = $('#other').val();
	var property_name = $('#property_name').prop('checked');
	
	var callback = $('#callback').checked;
	var reservation = $('#reservation').val();
	var newline = '\r\n';
	var arrow = '> ';
	//alert(name);
	
	var logPhone = '';
	if (name.length > 0)
		logPhone += arrow + 'Name: ' + name;
	if (id.length > 0)
		logPhone += newline + arrow + 'Property id: ' + id;

	logPhone += newline + arrow + 'Property name: ' + (property_name ? 'yes' : 'no');
		
	if (position.length > 0)
		logPhone += newline + arrow + 'Position: ' + position;
	if (reservation.length > 0)
		logPhone += newline + arrow + 'Reservation id: ' + reservation;
		
	$('#logcall').text(logPhone);
}

</script>

<div class="entries form large-9 medium-8 columns content">    
	<?= $this->Form->create() ?>
		<div style="height:800px;width:48%;display:block;float:left;" class="form-group form-control-big">	
			<fieldset>								
				<?php echo $this->Form->text('name', ['onfocusout' => 'flogcall()', 'placeholder' => 'Name', 'label' => true, 'id' => 'name', 'style' => '', 'class' => 'form-control marginBottom10']); ?>
				<?php echo $this->Form->text('property_id', ['onfocusout' => 'flogcall()', 'placeholder' => 'Property ID', 'label' => true, 'id' => 'property_id', 'style' => '', 'class' => 'form-control marginBottom10']); ?>
				<label for="property_name"><?= $this->Form->checkbox('property_name', ['onfocusout' => 'flogcall()', 'id' => 'property_name']) ?>&nbsp;Ask for Property Name</label><br/>
				
				<span style="margin-right:10px; font-size:20px;">Position:</span>
				<label for="owner" style="margin-right:10px;"><?= $this->Form->checkbox('owner', ['id' => 'owner']) ?>&nbsp;Owner</label>
				<label for="manager" style="margin-right:10px;"><?= $this->Form->checkbox('manager', ['id' => 'manager']) ?>&nbsp;Manager</label>
				<label for="frontdesk" style="margin-right:10px;"><?= $this->Form->checkbox('frontdesk', ['id' => 'frontdesk']) ?>&nbsp;Front Desk</label>
				<label for="reservations" style="margin-right:10px;"><?= $this->Form->checkbox('reservations', ['id' => 'reservations']) ?>&nbsp;Reservations</label>
				
				<?php echo $this->Form->text('other', ['id' => 'other', 'onfocusout' => 'flogcall()', 'placeholder' => 'Other Position', 'class' => 'form-control marginBottom10']); ?>

				<label for="callback"><?= $this->Form->checkbox('callback', ['onclick' => 'flogcall()', 'id' => 'callback']) ?>&nbsp;Security Callback</label>
				<label for="pin"><?= $this->Form->checkbox('pin', ['onclick' => 'flogcall()', 'id' => 'pin']) ?>&nbsp;New PIN Request</label>
				<label for="password_reset"><?= $this->Form->checkbox('password_reset', ['id' => 'password_reset']) ?>&nbsp;Reset Password</label><br/>

				<?php echo $this->Form->text('reservation', array('placeholder' => 'Reservation ID', 'label' => true, 'id' => 'reservation', 'style' => '', 'class' => 'form-control marginBottom10')); ?>
				<?= $this->Form->button('Go', array('id' => 'go', 'class' => 'btn btn-primary btn-sm')); ?>

			<div>
	
				<div style="xbackground-color: yellow; float:left; width:49%;margin-right: 1%;">
					<div style="">
						<?= $this->Form->textarea('description', ['id' => 'reason', 'value' => 'H called about ', 'style' => 'height:200px;', 'class' => 'form-control marginBottom10']); ?>
					</div>
				</div>
				
				<div style="xbackground-color: yellow; float:left; width:49%;margin-right: 1%;">
					<div style="">
						<?= $this->Form->textarea('description', ['id' => 'email', 'value' => 'You contacted us about ', 'style' => 'height:200px;', 'class' => 'form-control marginBottom10']); ?>
					</div>
				</div>
				
			</div>
							
			</fieldset>
		</div>			
								
    <?= $this->Form->end() ?>
</div>

<div style="background-color:yellow; float:left;width:48%;margin-right: 1%;">
	<div style="">
		<span id="logcall"></span>
	</div>
<div/>

<div style="clear:both;"></div>

<?php if ($allowTranslate) : ?>
	
<div style="padding-top: 10px;">
	<a href='#' onclick='javascript:copyFromTo("#trx", "#description");'><span style="padding-right: 10px;" class="glyphCustom glyphicon glyphicon-hand-left"></span></a>
	<a href='#' onclick='javascript:copyFromTo("#trx", "#description_esp");'><span class="glyphCustom glyphicon glyphicon-hand-right"></span></a>
</div>
		
<div id="google_translate_element"></div>

<script type="text/javascript">

function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}

</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
				
	<div id="trx">	
		<?php
		//$this->Text->autoParagraph(h($article->description)); 
		?>
	</div>
	
</div>

<?php endif; ?>