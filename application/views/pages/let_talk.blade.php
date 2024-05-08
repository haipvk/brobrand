<?php /*Name: Trang let's talk*/ ?>
<?php $WE_HELP_YOU = getJsonBlock('we_help_you', 'block'); ?>
@extends('index')
@section('content')
<section class="body-pages pages_all page_lets">
    <div class="container-fluid  pb-lg-5">
        <!-- <p class="title_page_big">Dự án tiêu biểu</p> -->
        <form class="mb-4 ajaxform" method="POST" action="{{ \VthSupport\Classes\UrlHelper::exactLink('send-lettalk') }}" accept-charset="utf-8" data-success="CONTACT._">
            <p class="big-title-page mb-4">{:TITLE_FORM_LETS_TALK:}</p>
            <div class="row form_input">
                <div class="col-12 col-md-6">
                    <p>Email*</p>
                    <input type="text" name="email" placeholder="Email" required>
                    <p>{:COMPANY:}</p>
                    <input type="text" name="company" placeholder="{:COMPANY:}">
                    <p>{:CITY:}</p>
                    <input type="text" name='city' placeholder="{:CITY:}">
                </div>
                <div class="col-12 col-md-6">
                    <p>{:NAME:}</p>
                    <input type="text" name="name" placeholder="{:NAME:}">
                    <p>{:POSITION:}</p>
                    <input type="text" name="position" placeholder="{:POSITION:}">
                    <p>{:SCALE_Q:}</p>
                    <select name="scale" id="scale">
                        <option selected value="">{:SCALE:}</option>
                        <option value="{:UNDER_10:}">{:UNDER_10:}</option>
                        <option value="{:10_50:}">{:10_50:}</option>
                        <option value="{:50_200:}">{:50_200:}</option>
                        <option value="{:OVER_200:}">{:OVER_200:}</option>
                    </select>
                </div>
            </div>
            <p class="title_page mt-4">{:TITLE_WE_HELP:}</p>
            <div class="row mb-3">
                @if (count($WE_HELP_YOU) > 0)
                @foreach ($WE_HELP_YOU as $k => $item)
                <div class="col-12 col-md-6">
                    <label><input class="me-2" value="{(item.name)}" name="project" type='checkbox'>{(item.name)}</label>
                </div>
                @endforeach
                @endif
            </div>
            <div class="line-top-footer"></div>
            <label><input class="me-2 mt-4" name="confirm_terms" value="1" type='checkbox'>{[CONTENT_CONFIRM]}</label>
            <div class="bottom-reques__forms my-4">
                <div class="g-recaptcha" data-sitekey="6LfLDd8fAAAAAAui2TSQUQbHsTpH8tAxIj9CM-SF"></div>
                <div class="d-flex justify-content-center">
                    <button class="btn-forms__requetss font-bold mt-4" type="submit">{:BOOK_NOW:}</button>
                </div>
            </div>
        </form>

    </div>
    <?php
    $CONTACT_TITLE = getBlock("CONTACT_TITLE", "block");
    $CONTACT_DES = getBlock("CONTACT_DES", "block");
    $CONTACT_DES_2 = getBlock("CONTACT_DES_2", "block");
    $CONTACT_DES_CONTENT = getBlock("CONTACT_DES_CONTENT", "block");
    $LINK_CARREER = getBlock("LINK_CARREER", "block");
    ?>
    <div class="tops-contacts mb-100 mt-5">
        <div class="container-fluid">
            <div class="items-contacts__intros wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
                <p class="titles-contacts text-black"> {:MEETUS:} </p>
                <div class="content-contacts">
                    <!-- <p>{[COPY]}</p> -->
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
</section>
@stop