<?php
	$options = [0 => '(' . __('Select Type') . ')', TYPE1 => __(TAG1), TYPE5 => __(TAG5), TYPE3 => __(TAG3), TYPE6 => __(TAG6), TYPE7 => __(TAG7) ];
	echo $this->Form->select('type', $options, ['id' => 'type', 'style' => 'color:default; font-size:1.2em;', 'class' => 'form-control', 'empty' => false]);
?>