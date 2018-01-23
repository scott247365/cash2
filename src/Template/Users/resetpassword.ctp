<div class="row">

	<div class="sectionHeader text-center">	
		<h1 class="sectionImageBlue">
		<span class="sectionImageBlue glyphicon glyphicon-edit glyphspaceright"></span><?= __('Reset Password') ?>
		</h1>
	</div>	
	
<div class="col-sm-6 col-sm-offset-3">

    <?= $this->Form->create() ?>
	
<div class="form-group form-control-big">		
	
    <fieldset>
		<label for="password" class="control-label"><?= __('Enter New Password:') ?></label>
        <?= $this->Form->input('password', ['label' => false, 'id' => 'password', 'class' => 'form-control marginBottom10']); ?>
		
		<label for="passwordConfirm" class="control-label"><?= __('Re-enter New Password:') ?></label>
        <?= $this->Form->input('passwordConfirm', ['label' => false, 'type' => 'password', 'id' => 'passwordConfirm', 'class' => 'form-control marginBottom10']); ?>

	</fieldset>
	
</div>
		
	<div class="formGroup text-center">			

	<?= $this->Form->button('Save New Password'
		, array('class' => 'btn btn-primary btn-md')); ?>

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

