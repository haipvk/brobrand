@extends('index')

@section('class_header')

  active-fixed__headers modals-fix__header

@stop
@section('css_popup')

  view_no_ajax

@stop
@section('popup')

@show

@section('close_popup')

<div class="btn-close__pages_project">

  <a href="{{\VthSupport\Classes\UrlHelper::exactLink('tuyen-dung')}}" title="Carree"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
            <g>
               <g>
                  <path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z"/>
               </g>
            </g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
            <g></g>
         </svg></a>

</div>

@stop

@section('content')

<div class="modal-prj__news modals-alls modals-careerss" id="modal-news__prjs" aria-hidden="true" aria-labelledby="modal" tabindex="-1" style="background-color: {(color_bg)};color:{(color_text)}">

   <div class="modal-dialog modal-fullscreen modal-dialog-centered">

      <div class="modal-content">

         @include('carreer.ajax')

      </div>

   </div>

</div>

@stop

@section('footer')

@stop