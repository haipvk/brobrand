<?php 
	$name = isset($itemSubControl['name'])?$itemSubControl['name']:'';
	$type = $itemSubControl['type'];
	$rows = isset($itemSubControl['rows'])?$itemSubControl['rows']:'3';
	$default = isset($itemSubControl['default'])?$itemSubControl['default']:'';
	$value = isset($subValue[$name])?$subValue[$name]:$default;
 ?>
<?php  $this->load->helper(array('string'));  $idfile = $name."_".random_string() ?>
<div class="<?php echo $idfile ?>">
 	<textarea data-variable="json_field_<?php echo $field['name'] ?>" cols="30" data-name="<?php echo $name ?>"  data-type="<?php echo $type ?>" rows="<?php echo $rows ?>" class="control <?php echo $idfile ?> <?php echo $name ?> hidden <?php echo $type ?>" value="<?php echo $default ?>"><?php echo $value ?></textarea>
 	<?php 
		$tmp = json_decode($value,true);
		$file = isset($tmp) && is_array($tmp) ?$tmp["path"].$tmp["file_name"]:'';  
	?>
	<input type="text" class="<?php echo $idfile ?>" value="<?php echo $file ?>">
	<div class="btnadmin">
		<a href="<?php echo base_url() ?>Techsystem/Media/media?istiny=<?php echo $idfile ?>&callback=JSON_FIELD_PROVIDER.callbackFile" class="btn iframe-btn" type="button">Browse File ...</a>
	</div>
</div>