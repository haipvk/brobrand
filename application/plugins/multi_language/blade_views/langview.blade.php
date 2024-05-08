<?php $value =  pgetLanguage() ?>
<?php $langs = pgetLanguages();
$flags = pflags();
?>
<?php foreach ($langs as $k => $lang):?>
	<?php $flag = array_key_exists($lang, $flags)? sprintf('<img style="max-width: 25px;" src="%s"/>',$flags[$lang]['flag']):$lang; ?>
	<a class="{{$lang == $value ? 'active':''}}" href="{{pChangeLanguageUrl($lang)}}">{!!$flag!!}</a>
<?php endforeach ?>