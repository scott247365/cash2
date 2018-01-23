<?php 
	$this->layout = 'default'; 
?>

<!--------------------------------------------------------------------------------------->
<!-- Header -->
<!--------------------------------------------------------------------------------------->

<div id="headerBg">
<div id="header" class="header">
	<div style="" class="container text-center">

		<h1 class="marginBottom30 font-open-sans-400"><span><?= __('Welcome to') . ' ' . __('CMS') ?></span></h1>
						
		<div style="max-width: 700px; margin: auto;">
			<!-- h2 id="" class="font-open-sans-400" ><span class="">Entries, Forum, Shopping Cart, and much more.</span></h2 -->
			
			<img src="/img/logo-header.png" />
			
		</div>

		<!-- for XS this part jumps down to section 1 -->
		<div class="hidden-xs" style="max-width: 700px; margin: auto;">
		
			<h3 id="" class="marginBottom40 font-open-sans-400" ><span class=""></span><?= __('Content Management System') ?></h2>
						
			<form action="/users/register">
				<button class="textWhite marginBottom20 btn btn-submit btn-lg bgBlue"><span class="glyphicon glyphicon-hand-right"></span>&nbsp;<?= __('Get It Now') ?></button>
			</form>
			
		</div>				

		<!-- XS only after button jumps down -->
		<div class="hidden-xl hidden-lg hidden-md hidden-sm" style="margin: auto;">
			<h2 style="color: white; font-size: 1.8em; " class="font-open-sans-400" ><?= __('Content Management System') ?></h2>
		</div>

		
	</div>
</div>
</div>

<!--------------------------------------------------------------------------------------->
<!-- SECTION: 0 - thin row at the top for the tech logos -->
<!--------------------------------------------------------------------------------------->
<section id="techLogos" class="">
	<div class="container">	
		<div class="row text-center">			
		
			<div class="col-md-2 col-sm-4 col-xs-4">
				<img src="/img/theme1/wordpress.png" />
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<img src="/img/theme1/joomla.png" />
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<img src="/img/theme1/drupal.png" />
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<img src="/img/theme1/cpanel.png" />
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<img src="/img/theme1/magento.png" />
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<img src="/img/theme1/concrete5.png" />
			</div>
				
		</div>
	</div>
</div>

<!--------------------------------------------------------------------------------------->
<!-- SECTION: 1 - Cols with topper glyph -->
<!--------------------------------------------------------------------------------------->

<section id="sectionFeatures" class="sectionGray">
	<div class="container">	
		<div class="text-center">			
			
			<div class="hidden-xl hidden-lg hidden-md hidden-sm" style="max-width: 700px; margin: auto;">
				<form action="/users/register">
					<button class="textWhite marginBottom20 btn btn-submit btn-lg bgBlue"><span class="glyphicon glyphicon-hand-right"></span>&nbsp;<?= __('Get It Now') ?></button>
				</form>
			</div>				
			
			<h1 class="font-open-sans-300">
				<?= __('Feature Bullet List') ?>
			</h1>
			
			<h3 class="marginBottom30 font-open-sans-300">
				<?= __('CMS is a content management system with the following list of features') ?>:
			</h3>
			
			<div class="clearfix">
				
				<div class="row font-open-sans-400">
				
					<div class="col-md-3 col-sm-6">
						<div class="">
							<div class="sectionImage sectionImageBlue"><span class="glyphicon glyphicon-signal"></span></div>
							<h2><?= __('Components') ?></h2>
							<ul>
								<li><?= __('Blog') ?></li>
								<li><?= __('Forum') ?></li>
								<li><?= __('Photo Gallery') ?></li>
								<li><?= __('Classified Ads') ?></li>
								<li><?= __('Financial Management') ?></li>
								<li><?= __('Flash Cards Learning System') ?></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="">
							<div class="sectionImage sectionImageBlue"><span class="glyphicon glyphicon-lock"></span></div>
							<h2><?= __('Features') ?></h2>
							<ul>
								<li><?= __('Multiple Languages') ?></li>
								<li><?= __('API Web Services Design') ?></li>
								<li><?= __('Open Platform: Web, App, Console, Device, etc') ?></li>
								<li><?= __('Offline Access') ?></li>
								<li><?= __('Geolocation') ?></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="">
							<div class="sectionImage sectionImageBlue"><span class="glyphicon glyphicon-user"></span></div>
							<h2><?= __('Similar Sites') ?></h2>
							<ul>
								<li><a target="_blank" href="http://msn.com"><?= __('msn.com') ?></a></li>
								<li><a target="_blank" href="http://timeout.com/kualalumpur"><?= __('Timeout.com') ?></a></li>
								<li><a target="_blank" href="http://geoexpat.com"><?= __('Geoexpat.com') ?></a></li>
								<li><a target="_blank" href="http://duolingo.com"><?= __('Duolingo.com') ?></a></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="">
							<div class="sectionImage sectionImageBlue"><span class="glyphicon glyphicon-scale"></span></div>
							<h2><?= __('Support') ?></h2>
							<ul>
								<li><?= __('Full Customer Support') ?></li>
								<li><?= __('Fast response time') ?></li>
								<li><?= __('24x7x365 Support') ?></li>
								<li><?= __('Support by Email, Skype, and Phone') ?></li>
							</ul>
						</div>
					</div>
					
				</div><!-- row -->			

			</div>
						
		</div><!-- text-center -->
	</div><!-- container -->
</section>

<!--------------------------------------------------------------------------------------->
<!-- SECTION: 2 - 2 columns, 1 is image -->
<!--------------------------------------------------------------------------------------->
<?php if (false) : ?>

<section id="sectionMap" class="sectionWhite">
<div class="container">	
	<div class="row font-open-sans-300">

		<div class="col-sm-6 text-center">
			<img style="width: 100%; max-width: 500px;" src="/img/theme1/world-map.png" />
		</div>

		<div class="col-sm-6">
			<div class="text-center">	
				<h3>Section with Image Column</h3>
			</div>

			<p>The sections have a bunch of text.  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

		</div><!-- col -->

</div><!-- row -->
</div>
</section>

<?php endif; ?>
<!--------------------------------------------------------------------------------------->
<!-- SECTION: 3 - Plain text section -->
<!--------------------------------------------------------------------------------------->

<?php if (false) : ?>

<section class="sectionWhite">
<div class="container">	

	<div class="sectionHeader text-center">	
	
		<h1 class="sectionImageBlue">Section With Plain Text</h1>

	</div>

	<h3>The sections have a bunch of h3 text.  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h3>
	
	<div class="text-center marginTop30"><h3><a class="sectionImageBlue" href="#">Click Here for More Details</a></h3></div>
	
	<div class="row text-center marginTop50">
		<div class="header">
			<form action="/users/register">
				<button class="textWhite marginBottom20 btn btn-submit btn-lg bgGreen"><span class="glyphicon glyphicon-user"></span>&nbsp;Call to Action!</button>
			</form>
			
		</div>		
	</div>
	
</div>
</section>

<?php endif; ?>

<!--------------------------------------------------------------------------------------->
<!-- SECTION: 4 - 2 columns with side glyphs -->
<!--------------------------------------------------------------------------------------->
		
<section id="sectionFeatures2" class="sectionYellow">
	<div class="container">	
		<div class="">							
			
			<div class="text-center">
				<h1 class="font-open-sans-300">
					<?= __('Columns with Side Glyphs') ?>
				</h1>
				
				<h2 class="marginBottom30 font-open-sans-300">
					<?= __('Glyphs always look good') ?>
				</h2>
			</div>
			
			<div class="clearfix font-open-sans-400">
				
				<div class="row">
				
					<div class="col-sm-6 minHeight100">
					
						<div class="glyphSide">
							<span class="glyphicon glyphicon-glass"></span>
						</div>
						
						<div class="glyphSideText">
							<p>
								<?php $t = __('This is the column text next to the glyph'); ?>
								<?= $t ?>. <?= $t ?>. <?= $t ?>. <?= $t ?>. <?= $t ?>. <?= $t ?>. 
							</p>
						</div>

					</div><!-- col -->
					
					<div class="col-sm-6 minHeight100">

						<div class="glyphSide">
							<span class="glyphicon glyphicon-globe"></span>
						</div>
						
						<div class="glyphSideText">
							<p>
								<?= $t ?>. <?= $t ?>. <?= $t ?>.
							</p>
						</div>
						
					</div><!-- col -->

				</div><!-- row -->			
				
				<div class="row">

					<div class="col-sm-6 minHeight100">

						<div class="glyphSide">
							<span class="glyphicon glyphicon-apple"></span>
						</div>
						
						<div class="glyphSideText">
							<p>
								<?= $t ?>. <?= $t ?>.
							</p>
						</div>
						
					</div><!-- col -->

					<div class="col-sm-6 minHeight100">

						<div class="glyphSide">
							<span class="glyphicon glyphicon-fire"></span>
						</div>
						
						<div class="glyphSideText">
							<p>
								<?= $t ?>.
							</p>
						</div>
						
					</div><!-- col -->
					
				</div><!-- row -->			

			</div><!-- clearfix -->
						
		</div><!-- text-center -->
	</div><!-- container -->
</section>
		
<!--------------------------------------------------------------------------------------->
<!-- SECTION: Contact -->
<!--------------------------------------------------------------------------------------->
			
<section id="contact" class="sectionWhite">
	<div class="container">

		<div class="sectionHeader text-center">	
			<div class="sectionImage sectionImageBlue"><span class="sectionImageBlue glyphicon glyphicon-pencil"></span></div>
			<h1 class="sectionImageBlue"><?= __('Contact Us') ?></h1>
		</div>
		
		<div class="clearfix marginTop40">
			<?php echo $this->element('form-contact'); ?>
		</div>
	
	</div>
</section>





