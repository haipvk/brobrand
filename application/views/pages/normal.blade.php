<?php /*Name: Trang mặc định*/ ?>
@extends('index')
@section('content')
<div class="banner">
    <div class="box-img page_normal_banner mb-3">
        [[dataitem.#W#img.1.-1]]
    </div>
    <div class="box-banner">
        <div class="container">
            <h1 class="title">{(name)}</h1>
        </div>
    </div>
</div>
<!-- <div class="breadcrumb">
  <div class="container">
    {%BREADCRUMB_V2%}
</div> -->
</div>
<div class="container py-lg-4 py-3">
    <div class="s-content">
        {(content)}
    </div>
</div>
@stop