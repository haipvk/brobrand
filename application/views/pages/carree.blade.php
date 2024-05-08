<?php /*Name: Trang tuyển dụng*/ ?>

@extends('index')

@section('close_popup')
<div class="btn-close__pages">
   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
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

<?php 

    $CAREE_DES = getBlock("CAREE_DES","block");

    $CAREE_IMG = getBlock("CAREE_IMG","block");

?>

<main>

    <section class="body-pages pages_all">

        <div class="intros-carerr mb-100 ">

            <div class="container-fluid">

                <div class="text-career mb-65 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">

                    <p>{(CAREE_DES.CAREE_DES)}</p>

                </div>

                <div class="img-career wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">

                    [[CAREE_IMG.#W#CAREE_IMG.large_-1]]

                </div>

            </div>

        </div>

        <div class="list-career mb-100">

            <div class="container-fluid">

                <!--DBS-loop.carreer.1|where:act = 1|ord:ord asc|limit:-->

                <div class="items-careers ajax__carreer wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">

                    <a href="{(itemcarreer1.slug)}" title="{(itemcarreer1.name)}" class="name-itemss__career name-career__items __load" data-backgrounds="#3B4546" data-text="#CFD1CC">{(itemcarreer1.name)}</a>

                    <p class="time-offer__career name-career__items">Closing in: {{date('d/m/Y', $itemcarreer1['time_close'])}} </p>

                </div>

                <!--DBE-loop.carreer.1-->

            </div>

        </div>

    </section>

</main>

@stop

