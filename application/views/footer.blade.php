<?php
$SHORT_TITLE_FOOTER = getBlock('SHORT_TITLE_FOOTER', 'block');
?>
<div class="container-fluid">
    <div class="line-top-footer"></div>
</div>
<footer>
    <div class="footer wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.1s">
        <div class="container-fluid">
            <div class="tops-footers">
                <div class="row justify-content-between">
                    {{--<div class="col-5">
                        <div class="logo-footers">
                            <a href="{{\VthSupport\Classes\UrlHelper::exactLink('')}}" title="{[SITE_NAME]}">
                    <img src="theme/frontend/images/logo-full.svg" alt="{[SITE_NAME]}">
                    </a>
                </div>
                <p class="name-company mt-1">{[NAME_COMPANY]}</p>
                <p class="footer-sub-name mt-2">{{ $SHORT_TITLE_FOOTER['SHORT_TITLE_FOOTER'] ?? '' }}</p>
            </div>
            <div class="col-7 col-md-5">
                <ul class="intros-footers">

                    <li>
                        <a href="mailto:{[EMAIL]}" title="{[EMAIL]}" class="smooth">
                            <span class="icon-item">@include('icon_svgs.email_regular')</span>
                            {[EMAIL]}
                        </a>
                    </li>
                    <li>
                        <a href="tel:{[PHONE]}" title="{[PHONE]}" class="smooth">
                            <span class="icon-item">@include('icon_svgs.phone_regular')</span>
                            {[PHONE]}
                        </a>
                    </li>
                    <li class="d-flex align-items-center">
                        <span class="icon-item">@include('icon_svgs.location_regular')</span>
                        {[ADDRESS]}
                    </li>
                </ul>
            </div>
            <div class="col-5 d-none d-sm-block d-md-none"></div>
            <div class="col-sm-7 col-md-2">
                <ul class="app-footers">
                    <li class="d-none d-sm-block d-md-none icon-item">@include('icon_svgs.sms')</li>
                    <li><a href="{[FACE]}" target="_blank" title="facebook" class="smooth">Facebook</a></li>
                    <li><a href="{[INS]}" target="_blank" title="Instagram" class="smooth">Instagram</a></li>
                    <li><a href="{[BEHAN]}" target="_blank" title="Behance" class="smooth">Behance</a></li>
                </ul>
            </div>--}}
            <div class="col-12 col-md-5 menu_footer">
                <!--DBS-menu.1|where:act = 1-->

                <!--DBE-menu.1-->
            </div>
            <div class="col-12 col-md-3 footer_box_right">
                <div class="mb-4">
                    <p class="footer-sub-name mt-2">{{ $SHORT_TITLE_FOOTER['SHORT_TITLE_FOOTER'] ?? '' }}</p>
                    <div class="logo-footers">
                        <a href="{{\VthSupport\Classes\UrlHelper::exactLink('')}}" title="{[SITE_NAME]}">
                            <img src="theme/frontend/images/logo-full.svg" alt="{[SITE_NAME]}">
                        </a>
                    </div>
                    <p class="name-company mt-1">{[NAME_COMPANY]}</p>
                </div>
                <div class="d-flex social_footer justify-content-end">
                    <a href="{[FACE]}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="{[INS]}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="{[BEHAN]}" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i></a>
                    <a href="{[LINKEDIN]}" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
</footer>
<!-- <div class="footer-line mx-auto d-none d-xl-block"></div> -->
<div class="container-fluid mb-4">
    <div class="line-top-footer"></div>
</div>
<div class="container-fluid">
    <div class="d-flex copy_right mb-4">
        <p class="footer_contact">{[INFO_FOOTER]}</p>
        <div class="s-content">{[COPY]}</div>
    </div>
</div>