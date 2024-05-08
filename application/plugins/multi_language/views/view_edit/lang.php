<div class="row margin0 hidden">
	<div class="col-md-2 col-xs-12">
		<?php echo __('note',$field) ?>
	</div>
	<div class="col-md-10 col-xs-12">
		<?php if($type=='copy'): ?>
		<?php $get = $this->input->get(); ?>
		<?php $plang = isset($get['lang']) && $get['lang']!='' ? $get['lang']:$this->config->item('default_admin_language'); ?>
			<input type="hidden" name="plang" value="<?php echo $plang ?>">
			<input type="hidden" name="pobject" value="<?php echo isset($get['originId'])?$get['originId']:0 ?>">
		<?php else: ?>
		<?php $plang = isset($dataitem['plang']) && $dataitem['plang']!='' ? $dataitem['plang']:$this->config->item('default_admin_language'); ?>

			<input type="hidden" name="plang" value="<?php echo $plang ?>">
			<input type="hidden" name="pobject" value="<?php echo isset($dataitem)? $dataitem['pobject']:0 ?>">
		<?php endif; ?>
	</div>
</div>