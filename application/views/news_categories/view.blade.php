@extends('index')
@section('content')
    <main>
        <section class="body-pages pages_all section-page-blogs">
            <div class="journal-pages mb-65">
                <div class="container-fluid">
                    <p class="blog-title font-bold">{(name)}</p>
                    <div class="box_tags d-flex flex-wrap">
                        <!--DBS-loop.tags_news.1|where:act = 1|ord:create_time desc|limit:-->
                        <a href="{(itemtags_news1.slug)}" class="tags font-bold">#{(itemtags_news1.name)}</a>
                        <!--DBE-loop.tags_news.1-->
                    </div>
                    <hr class="line">
                    @if (count($list_data) > 0)
                        {@ $newFirst = array_shift($list_data); @}
                        @if (is_array($newFirst))
                            <div class="row box_first_news">
                                <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                                    <div class="img_full img_first_news">
                                        [[newFirst.#W#img.medium.-1]]
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="d-flex flex-column h-100">
                                        <p class="date_time "><span>{(newFirst.publish_by)} • </span>{{ date('d M Y', $newFirst['create_time']) }}</p>
                                        <h2>
                                            <a href="{(newFirst.slug)}" title="{(newFirst.name)}" class="title_news_big font-bold">{(newFirst.name)}</a>
                                        </h2>
                                        <div class="short_content font-medium">{@ wlimit(echor($newFirst,'short_content'),100) @}</div>
                                        <div class="d-flex flex-wrap mt-auto">
                                            <!--DBS-loop.tags_news.2|where:act=1,FIND_IN_SET(id;\''.$newFirst['tag'].'\') > 0|ord:ord desc-->
                                            <!--DBE-loop.tags_news.2-->
                                            @if (isset($arrtags_news2))
                                                @foreach ($arrtags_news2 as $itemtag)
                                                    <a href="{(itemtag.slug)}" title="{(itemtag.name)}" class="font-bold tags">#{(itemtag.name)}</a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <hr class="line">
                        <div class="list-journals">
                            <div class="row">
                                @foreach ($list_data as $k => $item)
                                    <div class="col-xl-4 col-lg-6 col-12  wow fadeInUp" data-wow-delay="{{ $k * 0.1 }}s">
                                        @include('news.item', ['item' => $item])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pagination mb-5">
                            {%PAGINATION%}
                        </div>
                    @else
                        <p class="no_result">{:NO_RESULT:}.</p>
                    @endif
                    @include('section.form_contact')
                </div>
            </div>
        </section>
    </main>
@stop
