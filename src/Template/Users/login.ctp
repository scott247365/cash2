
<div class="container">
	
	<div class="sectionHeader text-center">	
		<h1 class="sectionImageBlue">
		<span class="sectionImageBlue glyphicon glyphicon-log-in glyphspaceright"></span><?= __('Log-in') ?>
		</h1>
	</div>	
		
	<?= $this->element('form-login') ?>
	
</div>	

<script>

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

