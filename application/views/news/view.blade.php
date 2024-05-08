@extends('index')
@section('content')
<main>
    <section class="body-pages">
        <div class="content-recruitment__details content-write__blog  mb-100">
            <div class="container-fluid">
                <div class="d-flex align-items-lg-center justify-content-between mb-3 news_first_box">
                    <p class=" news_txt_date"><span>{(publish_by)} • {{ date('d M Y', $dataitem['create_time']) }}</p>
                    <a href="blog" class="font-bold title_news">
                        <span class="mr-2">
                            <svg width="43" height="37" viewBox="0 0 43 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_295_1852)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.03604 20.0006C7.90964 20.8182 8.92408 21.8064 9.99116 22.9222C13.084 26.1556 16.7374 30.5819 18.5923 35.1073L16.0077 36.202C14.3625 32.1886 11.016 28.0766 7.98384 24.9062C6.48248 23.3365 5.08724 22.0273 4.06804 21.1113C3.55872 20.6536 3.1446 20.2951 2.85928 20.0523C2.71676 19.931 2.60644 19.8386 2.53252 19.7773L2.44992 19.709L2.43032 19.6928L2.42584 19.6893L1.05888 18.5776L2.42528 17.4666L2.43032 17.4625L2.44992 17.4463L2.53252 17.3779C2.60644 17.3166 2.71676 17.2243 2.85928 17.1029C3.1446 16.8601 3.55872 16.5016 4.06804 16.044C5.08724 15.128 6.48248 13.8188 7.98384 12.2491C11.016 9.07868 14.3625 4.96661 16.0077 0.953368L18.5923 2.04804C16.7374 6.57324 13.084 10.9997 9.99116 14.2331C8.92408 15.3488 7.90964 16.3368 7.03632 17.1544L42.5 17.1544L42.5 20.0006L7.03604 20.0006Z" fill="black" stroke="black" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_295_1852">
                                        <rect width="37" height="42" fill="white" transform="translate(42.5) rotate(90)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        Back to Blog
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <h1 class="title_single_news font-bold">{(name)}</h1>
                    </div>
                </div>
                <div class="row news-box">
                    <div class="col-lg-8 col-12">
                        <div class="img_full">
                            [[dataitem.#w#img.1]]
                        </div>
                        <div class="s-content">
                            {(content)}
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <!--DBS-loop.news.1|where:act = 1|ord:create_time desc|limit:0,4-->
                        <div class="item_box">
                            <p class="css_date font-bold">{(itemnews1.publish_by)} • {{ date('d M Y', $itemnews1['create_time']) }}</p>
                            <a href="{(itemnews1.slug)}" class="title_news font-bold mb-2 d-block">{(itemnews1.name)}</a>
                            <div class="hot_news_des">
                                {(itemnews1.short_content)}
                            </div>
                            <div class="d-flex flex-wrap">
                                <!--DBS-loop.tags_news.1|where:act=1,FIND_IN_SET(id;\''.$itemnews1['tag'].'\') > 0|ord:ord desc-->
                                <!--DBE-loop.tags_news.1-->
                                @if (isset($arrtags_news1))
                                @foreach ($arrtags_news1 as $itemtag)
                                <a href="{(itemtag.slug)}" title="{(itemtag.name)}" class="font-bold tag_news">#{(itemtag.name)}</a>
                                @endforeach
                                @endif

                            </div>
                        </div>
                        <!--DBE-loop.news.1-->
                    </div>
                </div>
                <hr class="line">
                <div class="box_tags d-flex flex-wrap">
                    <!--DBS-loop.tags_news.2|where:act = 1,FIND_IN_SET(id;\''.$dataitem['tag'].'\') > 0|ord:create_time desc|limit:-->
                    <a href="{(itemtags_news2.slug)}" class="tags font-bold">#{(itemtags_news2.name)}</a>
                    <!--DBE-loop.tags_news.2-->
                </div>
                <div class="d-none d-lg-block">
                    @include('section.form_contact')
                </div>
            </div>
        </div>
    </section>
</main>
@stop