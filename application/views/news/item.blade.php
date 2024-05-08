<div class="items-journalss shine">
    <div class="img-items__journalss ">
        <a href="{(item.slug)}" title="{(item.slug)}" class="d-block img_">
            [[item.#W#img.medium_-1]]
        </a>
    </div>
    <div class="intros-items__journalss">
        <p class="news_des mb-0 font-medium"><span>{(item.publish_by)} • </span>{{ date('d M Y', $item['create_time']) }}</p>
        <h3><a href="{(item.slug)}" title="{(item.name)}" class="title_news_big font-bold">{(item.name)}</a></h3>
        <p class="news_des font-medium">{@ wlimit(echor($item,'short_content'),30) @}</p>
        <div class="d-flex flex-wrap">
            <!--DBS-loop.tags_news.1|where:act=1,FIND_IN_SET(id;\''.$item['tag'].'\') > 0|ord:ord desc-->
            <!--DBE-loop.tags_news.1-->
            @if (isset($arrtags_news1))
                @foreach ($arrtags_news1 as $itemtag)
                    <a href="{(itemtag.slug)}" title="{(itemtag.name)}" class="font-bold tag_news">#{(itemtag.name)}</a>
                @endforeach
            @endif
        </div>
    </div>
</div>
