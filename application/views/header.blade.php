<header class="header @yield('class_header')">
    <div id="header_main" class="container-fluid">
        <div class="logo-mains">
            <a href="{{ \VthSupport\Classes\UrlHelper::exactLink('') }}" title="{[SITE_NAME]}" class="logo-fade__headers">
                <div class="fade-hide__logo">
                    <div class="hide-scrolls">
                        <img src="{<LOGO.1.-1bro>}" alt="{[SITE_NAME]}">
                    </div>
                    <div class="fade-scrolls">
                        <img src="{<LOGO_SMALL.1.-1bro>}" alt="{[SITE_NAME]}">
                    </div>
                </div>
            </a>
        </div>
        @section('close_popup')
        <div class="btn-close__pages">
            @include('icon_svgs.btn_close_page')
        </div>
        @show
        <div class="languages-btn__menus">
            <!-- <ul class="languages-headers">
                <?php $value = pgetLanguage(); ?>
                <?php $langs = pgetLanguages(); ?>
                <?php foreach ($langs as $k => $lang) : ?>
                    @if(isMobile())
                    <li><a href="{{ pChangeLanguageUrl($lang) }}" class="{{ $lang == $value ? 'active' : '' }}" title="{{ $k == 1 ? 'VN' : 'EN' }}">{{ $k == 1 ? 'VN' : 'EN' }}</a></li>
                    @else
                    <li><a href="{{ pChangeLanguageUrl($lang) }}" class="{{ $lang == $value ? 'active' : '' }}" title="{{ $k == 1 ? 'Tiếng Việt' : 'English' }}">{{ $k == 1 ? 'Tiếng Việt' : 'English' }}</a></li>
                    @endif
                <?php endforeach ?>
            </ul> -->
            <a href="{:LINK_LETS_TALK:}" class="btn_talk">{:LETS_TALK:}</a>
            <div class="button-phone animated-icon1">
                @include('icon_svgs.btn_close_animate')
            </div>
        </div>
    </div>
    <div id="main-menu-mobile">
        <div class="container-fluid">
            <div class="logo-mains">
                <a href="{{ \VthSupport\Classes\UrlHelper::exactLink('') }}" title="{[SITE_NAME]}" class="logo-fade__headers">
                    <div class="fade-hide__logo">
                        <div class="hide-scrolls">
                            <img src="{<LOGO.1.-1bro>}" alt="{[SITE_NAME]}">
                        </div>
                        <div class="fade-scrolls">
                            <img src="{<LOGO_SMALL.1.-1bro>}" alt="{[SITE_NAME]}">
                        </div>
                    </div>
                </a>
            </div>
            @section('close_popup')
            <div class="btn-close__pages">
                @include('icon_svgs.btn_close_page')
            </div>
            @show
            <div class="languages-btn__menus">
                <ul class="languages-headers">
                    <?php $value = pgetLanguage(); ?>
                    <?php $langs = pgetLanguages(); ?>
                    <?php foreach ($langs as $k => $lang) : ?>
                        @if(isMobile())
                        <li><a href="{{ pChangeLanguageUrl($lang) }}" class="{{ $lang == $value ? 'active' : '' }}" title="{{ $k == 1 ? 'VN' : 'EN' }}">{{ $k == 1 ? 'VN' : 'EN' }}</a></li>
                        @else
                        <li><a href="{{ pChangeLanguageUrl($lang) }}" class="{{ $lang == $value ? 'active' : '' }}" title="{{ $k == 1 ? 'Tiếng Việt' : 'English' }}">{{ $k == 1 ? 'Tiếng Việt' : 'English' }}</a></li>
                        @endif
                    <?php endforeach ?>
                </ul>
                <div class="button-phone animated-icon1">
                    @include('icon_svgs.btn_close_animate')
                </div>
            </div>
        </div>
        <div class="intros-menu__mobiles">
            <div class="container-fluid">
                <div class="alls-menus__mobiles">
                    <div class="address-header pt-3 pt-sm-4">
                        <p class="font-semibold" data-animation="animated fadeInUpBig " hv data-animation="animated fadeInUpBig ">{[NAME_COMPANY]}</p>
                        <p data-animation="animated fadeInUpBig">
                            <a href="mailto:{[EMAIL]}" title="{[EMAIL]}" hv class="smooth">
                                <span class="icon-item">@include('icon_svgs.email')</span>
                                {[EMAIL]}
                            </a>
                        </p>
                        <p data-animation="animated fadeInUpBig">
                            <a href="tel:{[PHONE]}" title="{[PHONE]}" hv class="smooth">
                                <span class="icon-item">@include('icon_svgs.phone')</span>
                                {[PHONE]}
                            </a>
                        </p>
                        <p hv data-animation="animated fadeInUpBig" class="d-flex">
                            <span class="icon-item">@include('icon_svgs.location')</span>
                            {[ADDRESS]}
                        </p>
                    </div>
                    <ul class="app-headers d-flex">
                        <li><a href="{[FACE]}" hv class="smooth me-4" target="_blank" title="facebook" data-animation="animated fadeInUpBig"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="{[INS]}" hv class="smooth me-4" target="_blank" title="Instagram" data-animation="animated fadeInUpBig"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="{[BEHAN]}" hv class="smooth me-4" target="_blank" title="Behance" data-animation="animated fadeInUpBig"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
                        <li><a href="{[LINKEDIN]}" hv class="smooth me-4" target="_blank" title="LinkedIn" data-animation="animated fadeInUpBig"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
                <div class="menu_clone" data-animation="animated fadeInUpBig">
                    <!--DBS-menu.1|where:act = 1-->
                    <!--DBE-menu.1-->
                </div>
            </div>
        </div>
    </div>
</header>
<div class="bg-over-menu"></div>