<?php require_once(PLUGIN_PATH."/multi_language/classes/LanguageProvider.php"); ?>
<div class="col-md-4 col-xs-12 itemsearch">
	<span><?php echo __('note',$value) ?>: </span>
	<?php 
		$gt = (isset($datasearch) && array_key_exists("search_".$value['name'], $datasearch))?$datasearch["search_".$value['name']] : "";
		 $langs = \MultiLanguage\Classes\LanguageProvider::instance()->getLanguages();
		 $flags = \MultiLanguage\Classes\LanguageProvider::instance()->flags();
	 ?>
	 <select style="height:23px" class="select2" placeholder="<?php echo __('note',$value) ?>" name="search_<?php echo $value['name'] ?>">
	 	<option value="">Tất cả ngôn ngữ</option>
	 	<?php foreach($langs as $lang): ?>
	 	<option <?php echo $lang ==$gt?'selected':''  ?> value="<?php echo $lang ?>"><?php echo isset($flags[$lang])?$flags[$lang]['name']:$lang ?></option>
	 	<?php endforeach ?>
	 </select>
</div>