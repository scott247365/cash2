<?php if (isset($kbase) && $kbase != null) : ?>

<section id="services" style="">
	<div class="container">
					
			<?php foreach($kbase as $rec) : ?>
				<?php if ($rec['category']['nickname'] == 'services_header'): ?>
					<div class="text-center">
						<h1><span style=""><?php echo $rec['title']; ?></span></h1>
					</div>
				<?php elseif ($rec['category']['nickname'] == 'services'): ?>
					<div class="">
						<h2 style="" class="weight-400 services"><?php echo $rec['title']; ?></h2>								
						<p style=""><?php echo $rec['description']; ?></p>
						<p style=""><?php echo $rec['url']; ?></p>
					</div>							
				<?php endif; ?>
			<?php endforeach; ?>
	</div>
</section>

<?php endif; ?>
