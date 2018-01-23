<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

<!-- SEARCH FORM -->
	
<div style="margin-top: 20px;" class="users form">
<?php echo $this->Form->create('Transaction', array('style' => 'width: 200px;')); ?>
    <fieldset>

        <?php echo $this->Form->input('search', array('style' => 'font-size: 90%;', 'label' => 'Search:')); ?>
		
		<p style='margin-left: 20px;'><strong><?php 
			if (isset($hash))
				echo $hash; 
		?></strong><p>

    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
