<?php /*Name: Trang về chúng tôi*/ ?>
@extends('index')
@section('content')
<?php
$ABOUT_IMG = getBlock('ABOUT_IMG', 'block');
$FAQ_CONTENT = getJsonBlock('faq_content', 'block');
$ABOUT_VIDEO = getJsonBlock('ABOUT_VIDEO', 'block');
?>
<main>
    <section class="body-pages page__works pages_all">
        <div class="container-fluid mb-4 mb-md-5 pb-lg-3 pb-xl-4 pb-xxl-5 pt-3 pt-sm-0 pt-md-4 pt-lg-0">
            <h1 class="big-title-page mb-0">{(dataitem.name)}</h1>
        </div>
        <div class="motto-agains mb-100 ">
            <div class="container-fluid">
                @if ($ABOUT_VIDEO != '' || $ABOUT_VIDEO != null)
                {@
                $url = base_url().$ABOUT_VIDEO['path'].$ABOUT_VIDEO['file_name'];
                @}
                <div class="about_video">
                    <video src="{{ $url }}" autoplay="" muted="" loop="" playsinline=""></video>
                </div>
                @else
                <div class="img-motto__agian wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    [[ABOUT_IMG.#W#ABOUT_IMG.large_-1]]
                </div>
                @endif
            </div>
        </div>
        <div class="container-fluid mb-100">
            @if (count($FAQ_CONTENT) > 0)
            <div class="accordion tab-pane" role="tabpanel">
                @foreach ($FAQ_CONTENT as $k => $item)
                <div class="accordion-item">
                    <button id="accordion-button-1" aria-expanded="false">
                        <span class="accordion-title">
                            <span class="d-inline-block stt">{{ $k < 9 ? '0'.($k+1) : $k+1 }}</span>
                            {(item.name)}
                        </span>
                        <span class="icon" aria-hidden="true"></span>
                    </button>
                    <div class="accordion-content s-content">
                        <p>{(item.content)}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @include('section.form_contact')
    </section>
</main>
@stop