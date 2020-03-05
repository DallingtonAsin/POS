<?php 
$success = array();
if (count($success)>0):
	?>
     <div class="success">
     	<?php foreach ($success as $val):?> 
     		<p><?php echo "$val";?></p>
   <?php endforeach ?>
     </div>
<?php endif ?>