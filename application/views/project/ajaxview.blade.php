<button type="button" class="close-modal__news" data-bs-dismiss="modal">Close</button>
<div class="content-prj__news paste__content">
    <div class="tops-prj__details mb-65" data-bg="{(color_bg)}" data-text="{(color_text)}">
        <div class="container-fluid">
            <h2 class="titles-prj__details font-bold">{(name)}</h2>
            <div class="row">
                <div class="col-lg-4 col-md-5 mb-5 mb-lg-0">
                    {@ $scopes = json_decode($dataitem['scope'],true); $scopes = @$scopes ? $scopes : []; @}
                    @if (count($scopes) > 0)
                        <p class="titles-navs__prjs font-bold d-none d-lg-block">Scope</p>
                        <ul class="nav-prj__tops">
                            @foreach ($scopes as $k => $scope)
                                <li><span class="smooth d-block">{(scope.name)}</span></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="text-tops__prjs">
                        <p>{(short_content)}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="intros-prjs__details">
        <div class="container-fluid">
            <div class="s-content">{(content)}</div>
            <?php $nextPost = getNextPost('project', $dataitem); ?>
            @if (count($nextPost) > 0)
                <div class="author-names mt-lg-5 mt-3 mb-lg-4 mb-3">
                    @foreach ($nextPost as $k => $itemPost)
                        <a href="{(itemPost.slug)}" title="{:NEXT:}" class="next-pages__jounal font-bold">{:NEXT:}</a>
                        <h3 class="name-write__journal"><a href="{(itemPost.slug)}" title="{(itemPost.name)}">{(itemPost.name)}</a></h3>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
