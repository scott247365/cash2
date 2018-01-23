<?php $frontPage = (isset($frontPage) && $frontPage); ?>

<nav id="navMain" class="navbar navbar-default">
	<div class="container">
        <div class="navbar-header">
		
					<!-- the logo image --------------------------------------------------------->
					
					<!-- SMALL -->
					<!-- div class="hidden-xl hidden-lg hidden-md navbar-logo-xs">
						<a class="navbar-brand headerHeight" href="/"><img width="0" height="0" src="/img/logo_main.png" /></a>
					</div -->
										
					<!-- ALL OTHER SIZES -->
					<!-- div class="hidden-sm hidden-xs navbar-logo">
						<a class="navbar-brand headerHeight" href="/"><img width="0" height="0" src="/img/logo_main.png" /></a>
					</div -->
					
					<div class="navbar">
						<!-- a class="" href="/">CMS</a -->
					</div>

				
					<!-- the collapse hamburger --------------------------------------------------------->
					
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
							  
        </div>
		
        <div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
		  		  
				<!-- li class=""><a class="" href="/pages/about/"><?= __('CONTACT') ?></a></li -->
													
				<?php if ($isAdmin) : ?>
					<li><a class="" href="/"><?= __('HOME') ?></a></li>	
					<li class="dropdown mega-menu"><!-- USERS --><a href="/users/index">USERS</a></li>
					<li class="dropdown mega-menu"><!-- LOGIN/LOGOUT --><a class="" href="/users/logout">LOGOUT&nbsp;(<?php echo $userName; ?>)</a></li>
				<?php elseif ($isLoggedIn) : ?>
					<li><a class="" href="/"><?= __('HOME') ?></a></li>	
					<li class="dropdown mega-menu"><!-- LOGIN/LOGOUT --><a class="" href="/users/logout">LOGOUT&nbsp;(<?php echo $userName; ?>)</a></li>
				<?php else : ?>
					<li class="dropdown mega-menu"><a class="" href="/users/login"><?= __('LOGIN') ?></a></li>
					<li class=""><a class="" href="/users/signup"><?= __('REGISTER') ?></a></li>
				<?php endif; ?>								
				
				<li>
					<div class="dropdown">
						<a class="dropbtn"><?= $this->Custom->getLanguageName() ?></a>
						<div style="z-index: 100;" class="dropdown-content">
							<a href="/language/index/en"><?= __('English') ?></a>
							<a href="/language/index/es"><?= __('Spanish') ?></a>
							<a href="/language/index/ru"><?= __('Russian') ?></a>
							<a href="/language/index/hi"><?= __('Hindi') ?></a>
							<a href="/language/index/zh"><?= __('Chinese (Simplified)') ?></a>
							<!-- a href="/language/index/zh-Hant"><?= __('Chinese (Traditional)') ?></a -->
						</div>
					</div>								
				</li>
			</ul>
        </div><!--.nav-collapse -->
	</div><!-- container -->
</nav>
