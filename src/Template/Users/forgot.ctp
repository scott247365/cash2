<div class="row">

	<div class="sectionHeader text-center">	
		<h1 class="sectionImageBlue">
		<span class="sectionImageBlue glyphicon glyphicon-envelope glyphspaceright"></span><?= __('Forgot Password') ?>
		</h1>
	</div>	

	<div class="col-sm-6 col-sm-offset-3">				

    <?= $this->Form->create() ?>
    
	<div class="form-group form-control-big">		
	
	<fieldset>
	
		<label for="email" class="control-label"><?= __('Email:') ?></label>
		<?php echo $this->Form->input('email', array('label' => false, 'id' => 'email', 'class' => 'form-control marginBottom10')); ?>
	
    </fieldset>
	
	</div>
	
	<div class="text-center">			

	<?= $this->Form->button('Email Password Reset'
		, array(
			'onclick' => 'saveEmail();',
			'class' => 'btn btn-primary btn-md'
    )); ?>

	</div>
	
    <?= $this->Form->end() ?>

	</div>
</div>

<script>

// Save the email address in local storeage so user doesn't have 
// to type it in every time

//localStorage["email"] = '';

var found = getEmail();

if (found)
	document.getElementById("password").focus();
else
	document.getElementById("email").focus();

function getEmail()
{
	var ret = false;
	
	if (typeof(Storage) !== "undefined")
	{
		if (typeof(localStorage["email"]) !== "undefined")
		{
			var emailField = document.getElementById("email");
			emailField.value = localStorage["email"];
			ret = true;
		}
	}
	
	return ret;
}

function saveEmail() 
{
	if (typeof(Storage) !== "undefined")
	{
		var email = document.getElementById("email").value;
		localStorage["email"] = email;
	}
}

</script>

