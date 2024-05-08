@if(count($dataitem) > 0)
<div class="container">
   <h2 class="titles-recruitment__details">{(name)}</h2>
   <div class="s-content mb-100">
      <div class="s-content">{(content)}</div>
   </div>
   <?php $nextPost = getNextPost('carreer',$dataitem); ?>
   @if(count($nextPost) > 0)
   <div class="author-names mt-lg-4 mt-3">
      @foreach($nextPost as $k =>$itemPost)
      <a href="{(itemPost.slug)}" title="{:NEXT:}" class="next-pages__jounal">{:NEXT:}</a>
      <h3 class="name-write__journal"><a href="{(itemPost.slug)}" title="{(itemPost.name)}">{(itemPost.name)}</a></h3>
      @endforeach
   </div>
   @endif
</div>
@endif