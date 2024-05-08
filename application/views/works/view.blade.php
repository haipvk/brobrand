@extends('index')
@section('content')
    <?php
        $FEATURE_PROJECT = getBlock('FEATURE_PROJECT', 'block');
        $DES_FEATURE_PROJECT = getBlock('DES_FEATURE_PROJECT', 'block');
    ?>
    <form action="{{ \VthSupport\Classes\UrlHelper::exactLink('ajax-works') }}" class="d-none form-filter-ajax-works" method="get">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="industries" value="0">
    </form>
    <main>
        <div class="body-pages pages_all">
            <div class="container-fluid mb-4 pb-lg-3 pb-xl-4 pb-xxl-5 pt-3 pt-sm-0 pt-md-4 pt-lg-0">
                <h1 class="big-title-page mb-0">{(FEATURE_PROJECT.FEATURE_PROJECT)}</h1>
            </div>
            <div class="what-we__do mb-65">
                <div class="container-fluid">
                    <div class="tops-prj__works mb-65 wow fadeInUp d-block" data-wow-duration="1.5s" data-wow-delay="0.1s">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="list-prj__works">
                                <ul>
                                    <li class="active smooth">
                                        <a href="javascript:void(0)" data-parent="0" title="All" class="ajax__load smooth text-black">All</a>
                                    </li>
                                    <!--DBS-loop.services_categories.1|where:act = 1,parent = 0|order:ord desc|limit:-->
                                    <!--DBE-loop.services_categories.1--> 
                                    @foreach ($arrservices_categories1 as $itemservices_categories1)
                                        <li class="mooth wow fadeInUpBig" data-wow-delay="{{ $iservices_categories1 * 0.3 }}s">
                                            <a href="javascript:void(0)" class="ajax__load" data-parent="{(itemservices_categories1.id)}">{(itemservices_categories1.name)}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!--DBS-loop.industries.1|where:act = 1,parent = 0|order:ord desc|limit:-->
                            <!--DBE-loop.industries.1--> 
                            <div class="list-prj__works_industries">
                                <ul class="row">
                                    <li class="smooth col-sm-6">
                                        <a href="javascript:void(0)"  title="All" class="ajax__load_industries smooth text-black">All</a>
                                    </li>
                                    @foreach ($arrindustries1 as $itemindustries1)
                                        <li class="smooth col-sm-6">
                                            <a href="javascript:void(0)" class="ajax__load_industries" data-parent="{(itemindustries1.id)}">{(itemindustries1.name)}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="line-works mb-4 mb-xxl-5 d-none d-xl-block"></div>
                    <div class="result__ajax">
                        @include('works.grid-work', ['list_data' => $list_data])
                    </div>
                    <div id="load-more-btn-result" class="text-center">
                        <a href="" title="{:WORKS:}" class="all-works-link mt-5 d-inline-block">
                            <span class="me-3">Load more</span>
                            @include('icon_svgs.down_arrow')
                        </a>
                    </div>
                </div>
            </div>
            <div class="d-lg-none">
                @include('section.form_contact')
            </div>
        </div>
    </main>
@stop
@section('js')
    <script src="{{ assetFile('theme/frontend/js/works.js') }}" defer></script>
@stop