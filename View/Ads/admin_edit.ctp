<?php $this->extend('/Common/admin_edit'); ?>



	
<?php $this->append('primary-sidebar'); ?>
	


		 <?= $this->GoodForm->input('Ad.enabled', ['type' => 'checkbox']) ?>
		 <div data-visibility-control="#AdEnabled">
			 <?= $this->GoodForm->input('Ad.admin_only', ['type' => 'checkbox', 'label' => 'Visible only to admins']) ?>
		</div>
		
		
		<?php 
		 echo $this->GoodForm->input('Ad.biller');
		 echo $this->GoodForm->input('Ad.ad_type_id');
		 echo $this->GoodForm->input('Ad.background', array('default' => 'FFFFFF', 'label' => 'Background colour'));
					
			 ?>
			 
				<?php $this->end(); ?>


    <?php
            
            
            echo $this->Form->input('Ad.id');
            
            
            echo $this->GoodForm->input('Ad.title', ['class' => 'input-lg']);
            
            echo $this->GoodForm->input('Ad.destination_url', ['hint' => 'Include http(s):// for all external links']);
			
			   echo $this->GoodForm->input('Ad.type', array('options' => array('image' => 'Image', 'html' => 'HTML',)));
				
	?>
	
	<div class="row" data-visibility-control="#AdType==image">
		<div class="col-md-6">
			<h4>Ad image</h4>
			<?= $this->GoodForm->input('Ad.image', array('type' => 'image')) ?>
		</div>
		<div class="col-md-6">
			<h4>Alternate mobile version</h4>
			<?= $this->GoodForm->input('Ad.imagemobile', array('type' => 'image')) ?>
		</div>
		
	</div>
	
	<div data-visibility-control="#AdType==html">
		<?=$this->GoodForm->input('Ad.html', ['type' => 'code'])?>
	</div>
	
	
	
	
	<?php $this->append('secondary-sidebar'); ?>
  
	<?=$this->GoodForm->input('Ad.start_date', ['type' => 'date', 'label' => 'Display from', 'hint' => 'Blank for no start date']) ?>
	<?=$this->GoodForm->input('Ad.end_date', ['type' => 'date', 'label' => 'Display until', 'hint' => 'Blank for no end date']) ?>
	
	<?php $this->end(); ?>
	
	
	
	