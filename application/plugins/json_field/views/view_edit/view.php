<div class="row margin0">
	<div class="col-md-2 col-xs-12">
		<?php echo __('note',$field) ?>
	</div>
	<div class="col-md-10 col-xs-12">
		<?php $valueDatabase = isset($dataitem)? $dataitem[$field['name']]:'[]'; ?>
		<?php $jsons = json_decode($valueDatabase,true);$jsons = isset($jsons)?$jsons:[];
		?>
		<div class="json_field">
			<textarea class="hidden" name="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>" data-type="JSON_FIELD.VIEW"><?php  echo $valueDatabase ?></textarea>

			<div class="hidden hidden-item">
				<?php 
					$value = $field;
					$defaultData = $value['default_data'];
					$defaultData = json_decode($defaultData,true);
					$defaultData = is_array($defaultData)?$defaultData:[];
					$widthItem = (isset($defaultData['width']) && $defaultData['width']==1)?'col-100':'col-50';
					$subitems = isset($defaultData['data'])?$defaultData['data']:[];
				?>
				<div class="item <?php echo $widthItem ?> ">
				<?php foreach($subitems as $itemSubControl): ?>
					<?php $typeSubControl = $itemSubControl['type']; ?>
					
						<div class="json_field_control <?php echo (isset($itemSubControl['width'])&&$itemSubControl['width']==1)?'col-100':'col-50' ?> ">
							<div class="json_field_control_name">
								<label><?php echo isset($itemSubControl['text'])?$itemSubControl['text']:'' ?></label>
							</div>
							<div class="json_field_control_content col">
								<?php $this->load->view('json_field.sub_edit_'.$typeSubControl,['itemSubControl'=>$itemSubControl,'field'=>$field]); ?>
							</div>
						</div>
						
					
				<?php endforeach; ?>
				<span class="close icon-remove"></span>
				</div>

			</div>
			
			<div class="list-items list-items-<?php echo $field['name'] ?>">
				<?php foreach($jsons as $subValue): ?>
					<div class="item <?php echo $widthItem ?> ">
					<?php foreach($subitems as $itemSubControl): ?>
						<?php $typeSubControl = $itemSubControl['type']; ?>
							<div class="json_field_control <?php echo (isset($itemSubControl['width'])&&$itemSubControl['width']==1)?'col-100':'col-50' ?> ">
								<div class="json_field_control_name">
									<label><?php echo isset($itemSubControl['text'])?$itemSubControl['text']:'' ?></label>
								</div>
								<div class="json_field_control_content col">
									<?php $this->load->view('json_field.sub_edit_'.$typeSubControl,['itemSubControl'=>$itemSubControl,'subValue'=>$subValue,'field'=>$field]); ?>
								</div>
							</div>
					<?php endforeach; ?>
					<span class="close icon-remove"></span>
					</div>
				<?php endforeach ?>
			</div>
			<div class="text-center" style="width: 80%">
				<div class="btnadmin">
				<button type="button" class="btn add-<?php echo $field['name'] ?>"><?php echo alang("ADD") ?></button>
					
				</div>
			</div>		
		</div>
			
  	</div>
</div>
<style type="text/css">
	.json_field .list-items{
	    border: 1px solid #00923f;
	    width: 80%;
	    display: flex;
	    flex-wrap: wrap;
	    padding: 5px;
	}
	.json_field .json_field_control{
		display: flex;
		margin: 2px 0px;

	}
	.json_field .list-items .item{
		padding:0;
		position: relative;
		z-index: 9;
		padding: 10px;
	}
	.json_field .list-items .item span.close{
		    position: absolute;
    top: 0px;
    right: 0;
    background: red !important;
    opacity: 1;
    color: #fff;
    font-size: 12px;
    border-radius: 50%;
    padding: 3px;
    z-index: 13;
    width: 20px;
    height: 20px;
    text-align: center;
	}
	.json_field .list-items .item:before{
		background: rgba(192, 192, 192, 0.18);
    border: 1px solid rgba(0, 146, 63, 0.73);
    content: '';
    display: block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: -1;
	}
	.json_field .col-50{
		-ms-flex: 0 0 50%;
	    flex: 0 0 50%;
	    max-width: 50%;
	}
	.json_field .col-30{
		-ms-flex: 0 0 30%;
	    flex: 0 0 30%;
	    max-width: 30%;
	}
	.json_field .col-50:nth-child(even){
		padding-left: 30px;
	}
	.json_field .col-100{
		-ms-flex: 0 0 100%;
	    flex: 0 0 100%;
	    max-width: 100%;
	}
	.json_field .item{
		padding: 3px;
    	border: 3px solid transparent;
    	display: flex;
    flex-wrap: wrap;
	}
	.json_field .json_field_control .json_field_control_name{
		width: 100px;
	}
	.json_field .json_field_control  .col{
	    -ms-flex-preferred-size: 0;
	    flex-basis: 0;
	    -ms-flex-positive: 1;
	    flex-grow: 1;
	    max-width: 100%;
	}
	.json_field input,
	.json_field textarea{
		width:100% !important;
	}
</style>
<script type="text/javascript">
	$(function() {
		window['json_field_<?php echo $field['name'] ?>'] = new JSON_FIELD('<?php echo $field['name'] ?>');
		window['json_field_<?php echo $field['name'] ?>'].init();
	});
</script>