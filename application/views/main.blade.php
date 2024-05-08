@extends('index')
@section('content')
<?php 
$tmp= $this->CI->Dindex->getDataDetail(array(
    'table'=>'block',
    'where'=>array(array('key'=>'act','compare'=>'=','value'=>'1'))
));
$ret = array();
if(pGetLanguage() == 'vi'){
    foreach ($tmp as $key => $value) {
        $ret[$value['keyword']] = $value['vi_value'];
    }
}else{
    foreach ($tmp as $key => $value) {
        $ret[$value['keyword']] = $value['en_value'];
    }
}
?>
<h1 class="d-none">{[SITE_NAME]}</h1>
<main>
    <div class="body-alls__mains">
       @include('section.slide')
       @include('section.wedo')
       @include('section.partner')
    </div>
</main>
@stop
