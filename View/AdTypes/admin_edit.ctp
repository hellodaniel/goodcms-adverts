<?php $this->extend('/Common/admin_edit'); ?>

<div class="row">

	<div class="col-md-8">
    <?php
            
            
            echo $this->Form->input('AdType.id');
            
            
            echo $this->GoodForm->input('AdType.title');
            echo $this->GoodForm->input('AdType.width');
            echo $this->GoodForm->input('AdType.height');
            
            echo $this->GoodForm->input('AdType.notes');
			
			        
    
    ?>
    </div>
       
</div>
