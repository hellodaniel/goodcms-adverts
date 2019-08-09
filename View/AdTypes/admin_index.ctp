<?php 

$this->extend('/Common/admin_index');

$this->set('options', [
	'create' => true, 
	'sortable' => true
]); 

?>
	
    <table class="table table-hover index_table">
     <thead>
     	<tr>
     		<th>Type</th>
     		<th> </th>
     		<th></th>
     	</tr>
     </thead>
     <tbody>
          <?php foreach ($this->data as $row) { ?>
		  <tr data-id="<?=$row['AdType']['id']?>">  
             <td>
             	<?=$row['AdType']['title']?>
             </td>
             <td>
             	<?=$row['AdType']['width']?> &times; <?=$row['AdType']['height']?>
			 	<?=$row['AdType']['notes']?>
             </td>
            <td class="actions">
                <div class="btn-group">
            	<?=$this->element('admin/index-actions', array('id' => $row['AdType']['id']))?>
                </div>
            </td>
            
        </tr>
        <?php } ?>
    </tbody>
</table>
