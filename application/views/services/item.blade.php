<div class="js-item column column--1 {{$j == 4 ? 'column--2':'column--1' }} wow fadeIn" data-wow-duration="1.5s" data-wow-delay="{{$i*$j}}" >

   <div class="aspect aspect--1x1">

      <div class="aspect__inner">

         <h3 class="name-prj__items box-links__violet __load" href="{(item.slug)}" data-backgrounds="{(item.color_bg)}" data-text="{(item.color_text)}">

            @if($item['video'] != '')

            {@ 
               $video = json_decode($item['video'],true);
               $video = @video ? $video : [];
            @}
            @if(count($video) > 0)
            <video loop="{{\VthSupport\Classes\UrlHelper::exactLink('').$video['path'].'/'.$video['file_name']}}" autoplay="" muted=""></video>
            @endif

            @else

            [[item.#W#img.large_-1]]

            @endif

            <div class="intros-links__texts" style="background-color:{(item.color_bg)};color:{(item.color_text)};">

               <h3 class="titles-intros__Links">{(item.name)}</h3>

               <!--DBS-loop.tag_pro.1|where:act = 1|ord:ord asc|limit:0,10-->

         <a title="{(itemtag_pro1.name)}" href="{(itemtag_pro1.slug)}" class="name__tag">{(itemtag_pro1.name)}</a>

         <!--DBE-loop.tag_pro.1-->

         </div>

         </h3>

      </div>

   </div>

</div>