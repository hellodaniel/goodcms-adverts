<?php 


	if (empty($count)) $count = 1; 
	if (empty($type)) return; 
	
	echo $this->element('ad', ['count' => $count, 'type' => $type]); 

	