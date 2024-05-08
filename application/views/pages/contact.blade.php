<?php /*Name: Trang liên hệ*/ ?>
@extends('index')
@section('content')
<main>
    <?php
        $CONTACT_TITLE = getBlock("CONTACT_TITLE", "block");
        $CONTACT_DES = getBlock("CONTACT_DES", "block");
        $CONTACT_DES_2 = getBlock("CONTACT_DES_2", "block");
        $CONTACT_DES_CONTENT = getBlock("CONTACT_DES_CONTENT", "block");
        $LINK_CARREER = getBlock("LINK_CARREER", "block");
    ?>
    <section class="body-pages pages_all">
        <div class="container-fluid mb-5 pb-lg-3 pb-xl-4 pt-3 pt-sm-0 pt-md-4 pt-lg-0">
            <h1 class="big-title-page mb-0">{(dataitem.name)}</h1>
        </div>
        <div class="tops-contacts mb-100">
            <div class="container-fluid">
                <div class="items-contacts__intros wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    <p class="titles-contacts text-black"> {:MEETUS:} </p>
                    <div class="content-contacts">
                        <p>{[COPY]}</p>
                        <p>{[ADDRESS]}</p>
                    </div>
                </div>
                <div class="items-contacts__intros wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    <p class="titles-contacts text-black"> {:MAILUS:} </p>
                    <div class="content-contacts">
                        <p><a href="mailto:{[EMAIL]}" title="{[EMAIL]}">{[EMAIL]}</a> </p>
                    </div>
                </div>
                <div class="items-contacts__intros wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    <p class="titles-contacts text-black"> {:CALLUS:} </p>
                    <div class="content-contacts">
                        <p><a href="tel:{[PHONE]}" title="{[PHONE]}">{[PHONE]}</a> </p>
                    </div>
                </div>
                <div class="items-contacts__intros wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    <p class="titles-contacts text-black"> {:FOLLOWUS:} </p>
                    <div class="content-contacts">
                        <div class="list-social">
                            <p><a href="{[FACE]}" target="_blank" title="facebook">Facebook</a></p>
                            <p><a href="{[INS]}" target="_blank" title="Instagram">Instagram</a></p>
                            <p><a href="{[BEHAN]}" target="_blank" title="Behance">Behance</a></p>
                            <p><a href="{[LINKEDIN]}" target="_blank" title="LinkedIn">LinkedIn</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php /*
        <div class="form-contacts mb-100 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
            <div class=" container-fluid">
                <h3 class="title-parter__abouts font-bold">{(CONTACT_TITLE.CONTACT_TITLE)}</h3>
                <div class="forms-reques__us mb-100">
                    <form autocomplete="off" method="POST" action="{{\VthSupport\Classes\UrlHelper::exactLink('send-contact')}}" class="ajaxform" data-success="CONTACT._">
                        <input type="text" name="email" class="input-alls" placeholder="{:TYPE_EMAIL:}" crequired="" text-crequired="{:EMAIL:}">
                        <div class="bottom-reques__forms">
                            <div class="captcha">
                                <div class="g-recaptcha" data-sitekey="6LfLDd8fAAAAAAui2TSQUQbHsTpH8tAxIj9CM-SF"></div>
                                <button type="submit" class="btn-forms__requetss mt-4" type="submit">{:CONFIRM:} </button>
                            </div>
                            <p class="text-bottom__requets">{(CONTACT_DES.CONTACT_DES)}</p>
                        </div>
                    </form>
                </div>
                <h4><a href="{(LINK_CARREER.LINK_CARREER)}" class="quocte-contacts" title="{(CONTACT_DES_2.CONTACT_DES_2)}">{(CONTACT_DES_2.CONTACT_DES_2)}</a></h4>
            </div>
        </div>
        */ ?>
        @include('section.form_contact')
    </section>
</main>
@stop