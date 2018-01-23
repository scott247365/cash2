<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'ClearCash');
$cakeVersion = __d('cake_dev', 'ClearCash.info %s', '1.0')
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

	<?php echo $this->element('favicon'); ?>

    <title>Clear Cash - Financial Management</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap-theme.min.css">
	
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('theme'); // extra bootstrap theme
		//echo $this->Html->css('cake'); // original cake style

		// this is for the project
		echo $this->Html->css('custom');
		echo $this->Html->css('footer');
	?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script src="/assets/plugins/jquery/js/jquery.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<?php if (!$isLoggedIn) : ?>
	<script src="/assets/plugins/formValidation/js/formValidation.min.js"></script>
	<script src="/assets/plugins/formValidation/js/formValidationBootstrap.min.js"></script>
	<script src="/assets/plugins/formValidation/js/bootbox.min.js"></script>
<?php endif; ?>

</head>

<?php 
	if ($show_slider)
		echo '<body role="document" onload="xonLoad()">';
	else
		echo '<body role="document">';
?>

<!----------------------------------------------------------------->
<!----------------------------------------------------------------->
<!-------------------------- MAIN MENU ---------------------------->
<!----------------------------------------------------------------->
<!----------------------------------------------------------------->

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">  
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Clear Cash</a>
        </div>
		
        <div id="navbar" class="navbar-collapse collapse" style='font-size: 17px;'>
			<ul class="nav navbar-nav">
            
					<li><?php echo $this->Html->link('Transactions', '/transactions/index?mon=curr'); ?></li>
					<li><?php echo $this->Html->link('Expenses', '/transactions/expenses'); ?></li>
					<li><?php echo $this->Html->link('Accounts', '/accounts/'); ?></li>
					<li><?php echo $this->Html->link('Forex', '/pages/forex'); ?></li>

					<?php if ($isLoggedIn) : ?>
						<li><?php echo $this->Html->link('Sign Out (' . $username . ')', '/users/logout'); ?></li>								
					<?php else : ?>
						<li><?php 
							//login button: doesn't look good with min menu
							//echo '<button style="padding: 5px 10px; margin-top: 9px;" class="btn btn-primary" id="loginButton">Login</button>';
							echo $this->Html->link('Sign In', '#', array('id' => 'loginButton'));							
						?></li>				
					<?php endif; ?>

			</ul>
        </div><!--/.nav-collapse -->
	</div>
</nav>
	
<!----------------------------------------------------------------->
<!----------------------------------------------------------------->
<!-------------------- MAIN SLIDER ------------------------------->
<!----------------------------------------------------------------->
<!----------------------------------------------------------------->
    
<?php 
	//if ($show_slider)
		//echo $this->element('slider'); 
		echo $this->element('header'); 
?>

<!----------------------------------------------------------------->
<!----------------------------------------------------------------->
<!-------------------- LOGIN FORM POPUP --------------------------->
<!----------------------------------------------------------------->
<!----------------------------------------------------------------->

<?php if (!$isLoggedIn) : ?>
	
<!-- The login modal. Don't display it initially -->
<form id="loginForm" action="/users/loginapi" method="post" class="form-horizontal" style="display: none;">

    <div class="form-group">
        <label class="col-xs-3 control-label">Username:</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="username" id="username" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Password:</label>
        <div class="col-xs-5">
            <input type="password" class="form-control" name="password" />
        </div>
    </div>
	
        <?php 
			//echo $this->Form->input('username', array('label' => 'User Name:', 'name' => 'username'));
			//echo $this->Form->input('password', array('label' => 'Password:'));
		?>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </div>
	
</form>

<script>
$(document).ready(function() {
 
     $('#loginForm')
		.formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    }
                }
            }
        }
		})
        .on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

            var $form = $(e.target),                  // The form instance
                bv    = $form.data('formValidation'); // FormValidation instance
 
            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                					
				window.location = '/';
				
                // Hide the modal containing the form
                $form.parents('.bootbox').modal('hide');
				
            }, 'html')			
        });

    // Login button click handler
    $('#loginButton').on('click', function() {
        bootbox
            .dialog({
                title: 'Login',
                message: $('#loginForm'),
                show: false // We will show it manually later
            })
            .on('shown.bs.modal', function() {
                $('#loginForm')
                    .show()                             // Show the login form
                    .formValidation('resetForm', true); // Reset form
				
				$('#username').focus();
            })
            .on('hide.bs.modal', function(e) {
                // Bootbox will remove the modal (including the body which contains the login form)
                // after hiding the modal
                // Therefor, we need to backup the form
                $('#loginForm').hide().appendTo('body');
            })
            .modal('show');
    });
});

</script>
<?php endif; ?>
					
<!----------------------------------------------------------------->
<!----------------------------------------------------------------->
<!-------------------- CONTENT ------------------------------------>
<!----------------------------------------------------------------->
<!----------------------------------------------------------------->
		
<?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>		

<!----------------------------------------------------------------->
<!----------------------------------------------------------------->
<!-------------------- FOOTER ------------------------------------>
<!----------------------------------------------------------------->
<!----------------------------------------------------------------->

<?php echo $this->element('footer', array('isLoggedIn' => $isLoggedIn)); ?>		

<script src="/js/slider.js"></script>
<script src="/js/main.js"></script>
    	
</body>
</html>
