<div class="swiper-container slider-banner-main mb-5">

    <div class="swiper-wrapper">

        <!--DBS-loop.slide.1|where:act = 1|ord:ord asc|limit:-->

        <div class="swiper-slide">

            <div class="banner-mains videos-mains__plays d-flex align-items-end">

                @if ($itemslide1['video'] != '' || $itemslide1['video'] != null)

                    {@

                    $json = json_decode($itemslide1['video'],true); $url= @$url ? $url : [];

                    $url = base_url().$json['path'].$json['file_name'];

                    @}

                    <video src="{{ $url }}" autoplay="" muted="" loop="" playsinline=""></video>

                @else

                    [[itemslide1.#W#img.large_-1]]

                @endif

                <div class="intros-bannner-mains mb-3 mb-lg-4 pb-md-4 w-100">

                    <div class="container-fluid d-flex justify-content-center justify-content-lg-between align-items-center flex-wrap">

                        <h3 class="mx-2 wow fadeInLeft" data-wow-delay="0.1s"><a href="{(itemslide1.link)}"><span class="title-banner__mains">{(itemslide1.name)}</span></a> </h3>

                        @if ($countslide1 > 1)

                            <div class="slider-control-item d-flex align-items-center pt-2 mx-2 wow fadeInRight" data-wow-delay="0.1s">

                                <span class="btn-action btn-prev">

                                    @include('icon_svgs.left_icon')

                                </span>

                                <span class="mb-2">{{ $islide1 + 1 }} / {{ $countslide1 }}</span>

                                <span class="btn-action btn-next">

                                    @include('icon_svgs.right_icon')
                                    <!-- <i class="fa fa-angle-right" aria-hidden="true"></i> -->

                                </span>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        <!--DBE-loop.slide.1-->

    </div>

</div>

