<?php $this->extend('/Common/admin_edit'); ?>



	
<?php $this->append('primary-sidebar'); ?>
	


		 <?php 
		 
			 echo $this->GoodForm->input('Ad.enabled', ['type' => 'checkbox']);
		 echo $this->GoodForm->input('Ad.biller');
		 echo $this->GoodForm->input('Ad.ad_type_id');
		 echo $this->GoodForm->input('Ad.background', array('default' => 'FFFFFF', 'label' => 'Background colour'));
					
			 ?>
			 
				<?php $this->end(); ?>


    <?php
            
            
            echo $this->Form->input('Ad.id');
            
            
            echo $this->GoodForm->input('Ad.title');
            
            echo $this->GoodForm->input('Ad.destination_url');
			
			
            echo $this->GoodForm->input('Ad.type', array('options' => array('image' => 'Image', 'html' => 'HTML',)));
		  		
            echo $this->GoodForm->input('Ad.image', array('type' => 'image'));
	?>
	
	<h3>Mobile version</h3>
	
	<?php 
	
	        echo $this->GoodForm->input('Ad.imagemobile', array('type' => 'image'));
	        
		  	echo $this->GoodForm->input('Ad.html', ['type' => 'code']);
		  	
			
    
    ?>
  
	<?php $this->append('secondary-sidebar'); ?>
  
	<?=$this->GoodForm->input('Ad.start_date', ['type' => 'date', 'hint' => 'Blank for none']) ?>
	<?=$this->GoodForm->input('Ad.end_date', ['type' => 'date', 'hint' => 'Blank for none']) ?>
	
	<?php $this->end(); ?>