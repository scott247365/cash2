<section id="<?php echo $id; ?>" class="<?php echo $class; ?>">
	<div class="container" style="">	
		<div class="text-center">
			
			<h1><?php echo $title; ?></h1>
				
			<h2 class="col-sm-10 col-sm-offset-1 nomargin-bottom weight-400">
				<?php echo $description; ?>
			</h2>

			<?php if (isset($subtitle) && trim($subtitle) != '') : ?>
				<div style="clear: both; height: 20px;"></div>
				<h3><?php echo $subtitle; ?></h3>
			<?php endif; ?>
						
		</div><!-- text-center -->
	</div><!-- container -->
</section>
