<?php $this->extend('/Common/admin_edit'); ?>


    <?php
            
            
            echo $this->Form->input('AdType.id');
            
            
            echo $this->GoodForm->input('AdType.title');
			?>
			
			<div class="row">
				<div class="col-md-6">
            <?= $this->GoodForm->input('AdType.width', ['hint' => 'For admin purposes only', 'append' => 'px', 'default' => 0]) ?>
				</div>
            <div class="col-md-6">
            <?= $this->GoodForm->input('AdType.height', ['append' => 'px', 'default' => 0] ) ?>
				</div>
         </div>
			
          <?= $this->GoodForm->input('AdType.notes') ?>
			
