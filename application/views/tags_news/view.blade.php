@extends('index')
@section('content')
<?php
$segment = pgetLanguage() == 'vi' ? 2 : 3;
$pp = $this->CI->uri->segment($segment, 0);
$config['base_url'] = base_url('') . $dataitem['slug'];
$config['per_page'] = 12;
$where = [['key' => 'act', 'compare' => '=', 'value' => 1], ['key' => 'tag', 'compare' => '=', 'value' => $dataitem['id']]];
$config['total_rows'] = $this->CI->Dindex->getNumDataDetail('news', $where);
$limit = $pp . ',' . $config['per_page'];
$listItems = $this->CI->Dindex->getDataDetail([
    'table' => 'news',
    'limit' => $limit,
    'where' => $where,
    'order' => 'ord asc, id desc',
]);
$config['uri_segment'] = $segment;
$this->CI->pagination->initialize($config);
?>
<main>
    <section class="body-pages pages_all section-page-blogs">
        <div class="journal-pages mb-65">
            <div class="container-fluid">
                <div class="d-flex align-items-lg-center justify-content-between mb-3 news_first_box">
                    <p class="title-tags font-bold">#{(name)}</p>
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
                <!-- @if (count($listItems) > 0)
                        <div class="list-journals">
                            <div class="row">
                                @foreach ($listItems as $k => $item)
                                    <div class="col-xl-4 col-lg-6 col-12  wow fadeInUp" data-wow-delay="{{ $k * 0.1 }}s">
                                        @include('news.item', ['item' => $item])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif -->
                <?php
                $id = [$dataitem['id']];
                $k = 0;
                ?>
                <!--DBS-loop.news.1|where:act = 1|order:ord asc|limit:-->
                <!--DBE-loop.news.1-->
                <?php $k++ ; ?>
                <?php var_dump($arrnews1[$k]['tag']); ?>
                
                <div class="list-journals">
                    <div class="row">
                        @foreach ($arrnews1 as $k => $item)
                        <div class="col-xl-4 col-lg-6 col-12  wow fadeInUp" data-wow-delay="{{ $k * 0.1 }}s">
                            @include('news.item', ['item' => $item])
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pagination-tags pagination d-none d-lg-flex">
                    {%PAGINATION%}
                </div>
                <div class="related-topics d-none d-lg-block">
                    <!--DBS-loop.tags_news.2|where:act = 1,id != $id|order:ord asc| limit: -->
                    <!--DBE-loop.tags_news.2-->
                    @if (count($arrtags_news2) > 0)
                    <p class="title-related-topics font-bold">Related Topics</p>
                    <div class="box-tag-related d-flex flex-wrap">
                        @foreach ($arrtags_news1 as $itemtags_news2)
                        <a href="{(itemtags_news2.slug)}" class="tags font-bold">#{(itemtags_news2.name)}</a>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="d-lg-none">
                    @include('section.form_contact')
                </div>
            </div>
        </div>
    </section>
</main>
@stop