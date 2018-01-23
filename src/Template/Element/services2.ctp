<section id="services" style="background-color: #5BBC2E; color: white;">
	<div class="container">
		<div class="text-center" style="color: white;">
			<h1><span style="color: white;">Services</span></h1>
		</div>
					
		<?php foreach($kbase as $rec) : ?>
			<?php if ($rec['category'] == 'service'): ?>
				<div class="tech">
					<h2 style="color: white; margin-bottom: 20px;" class="weight-400"><?php echo $rec['title']; ?></h2>								
					<p style="font-size: 20px;"><?php echo $rec['description']; ?></p>
				</div>							
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<div class="container" style="text-align: center; margin-top: 50px;">
	</div>
</section>
