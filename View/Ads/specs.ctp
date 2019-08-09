		<div class="container">
         <!-- Main Left side -->
         <div class="main-left-side">
            <!-- The Article -->
            <div class="article-main float-width">
               <div class="artcl-body float-width">
                  <h1>Ad specs</h1>
                  
                  <article class="float-width articl-data">
                     
                     <?php foreach ($this->data as $spec) { ?>
                     
                     	<div class="row">
                     		
                     		<div class="col-md-12">
                     			<h2><?=$spec['AdType']['title'] ?></h2>
                     			
                     			<p><?=$spec['AdType']['width'] ?> &times; <?=$spec['AdType']['height'] ?></p>
                     			<p><?=$spec['AdType']['notes'] ?></p>
                     			
                     		</div>
                     		<div class="col-md-12">
                     		
                     			
                     			<?php if (isset($spec['Ad'][0])) { ?>
                     				<?=$this->Html->image($spec['Ad'][0]['image'])?> 
                     			<?php } else { ?>
                     				<div style="background: #CCCCCC; border: 1px solid #AAA; width: <?=$spec['AdType']['width'] ?>px; height: <?=$spec['AdType']['height'] ?>px;">
                     				
                     				</div>
                     			<?php } ?>
                     			
                     		</div>
                     		                		
                     			
                     	</div>
					 	<hr />
                     <?php } ?>
                     
                  </article>
               </div>
            </div>
            </div>
      </div>