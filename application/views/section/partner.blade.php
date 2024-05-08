<!--DBS-loop.partner.1|where:act = 1,home = 1,is_big = 1|ord:ord asc|limit:0,12-->
<!--DBE-loop.partner.1-->
<!--DBS-loop.partner.2|where:act = 1,home = 1,is_small = 1|ord:ord asc|limit:0,12-->
<!--DBE-loop.partner.2-->
<div class="main-partner py-2 py-md-5">
    <div class="container-fluid">
        <div>
            @if (count($arrpartner1) > 0)
            <div class="row my-4 my-md-5 pb-3 pb-md-4 pb-xxl-5">
                <div class="col-lg-6">
                    <div class="px-4 ps-md-0 pe-md-5 relative mb-3 mb-md-0">
                        <div class="swiper-container slider-partner">
                            <div class="swiper-wrapper">
                                @foreach (array_chunk($arrpartner1, 12) as $arrDataPartner)
                                <div class="swiper-slide">
                                    <div class="list-items-partner d-flex flex-wrap">
                                        @foreach ($arrDataPartner as $itempartner1)
                                        <div class="items-partner__mains-wrapper">
                                            <div class="items-partner__mains">
                                                <a href="javascript:void()" title="{(itempartner1.name)}">
                                                    [[itempartner1.#W#img.small.1.-1]]
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- <button type="button" class="slider-partner-prev">
                            @include('icon_svgs.left_black')
                        </button>
                        <button type="button" class="slider-partner-next">
                            @include('icon_svgs.right_black')
                        </button> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="px-4 px-md-0">
                        <p class="title_partner_box">{[TITLE_PARTNER_SMALL]}</p>
                        <div class="des_partner_box">
                            {[DES_PARTNER_SMALL]}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (count($arrpartner2) > 0)
            <div class="line-top-footer"></div>
            <div class="row my-4 my-md-5 pt-3 pt-md-4 pt-xxl-5">
                <div class="col-lg-6">
                    <div class="px-4 px-md-0">
                        <p class="title_partner_box">{[TITLE_PARTNER_BIG]}</p>
                        <div class="des_partner_box">
                            {[DES_PARTNER_BIG]}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-md-5 mt-lg-0 mb-3 mb-md-0">
                    <div class="px-4 pe-md-0 ps-md-5 relative">
                        <div class="swiper-container slider-partner">
                            <div class="swiper-wrapper">
                                @foreach (array_chunk($arrpartner2, 12) as $arrDataPartner)
                                <div class="swiper-slide">
                                    <div class="list-items-partner d-flex flex-wrap">
                                        @foreach ($arrDataPartner as $itempartner2)
                                        <div class="items-partner__mains-wrapper">
                                            <div class="items-partner__mains">
                                                <a href="javascript:void()" title="{(itempartner2.name)}">
                                                    [[itempartner2.#W#img.small.1.-1]]
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- <button type="button" class="slider-partner-prev">
                            @include('icon_svgs.left_black')
                        </button>
                        <button type="button" class="slider-partner-next">
                            @include('icon_svgs.right_black')
                        </button> -->
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>