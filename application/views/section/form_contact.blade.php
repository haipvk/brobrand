<?php

$REQUEST_DES = getBlock('REQUEST_DES', 'block');
$REQUEST__TITLE = getBlock('REQUEST__TITLE', 'block');
?>
<div class="requets-us mb-100 wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.1s">
    <div class="container-fluid">
        <h3 class="title-parter__abouts font-bold">{(REQUEST__TITLE.REQUEST__TITLE)}</h3>
        <div class="forms-reques__us">
            <form method="POST" action="{{ \VthSupport\Classes\UrlHelper::exactLink('send-contact') }}" class="ajaxform" accept-charset="utf-8" data-success="CONTACT._">
                <input type="text" name="email" class="input-alls" placeholder="{:TYPE_EMAIL:}" crequired="" text-crequired="{:EMAIL:}">
                <div class="bottom-reques__forms">
                    <div class="g-recaptcha" data-sitekey="6LfLDd8fAAAAAAui2TSQUQbHsTpH8tAxIj9CM-SF"></div>
                    <div class="content-form">
                        {(REQUEST_DES.REQUEST_DES)}
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn-forms__requetss font-bold mt-4" type="submit">{:CONFIRM:} </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
