<div class="what-we__do">

    <div class="container-fluid">

        @include('section.services')

        <div class="garelly-we__dos">

            <div class="js-grid my-shuffle">

                <!--DBS-loop.project.1|where:act = 1,home = 1|order:ord desc|limit:0,21-->

                <!--DBE-loop.project.1-->

                {@ $arrProject = isset($arrproject1) ? array_chunk($arrproject1,6) : []; @}

                @foreach ($arrProject as $k => $arr)

                    {@ $i = $k + 1; @}

                    @foreach ($arr as $k1 => $itemProject)

                        {@ $j = $k1 + 1; @}

                        @include('project.item', ['item' => $itemProject, 'i' => $i, 'j' => $j])

                    @endforeach

                @endforeach

                <div class="column my-sizer-element"></div>

            </div>

        </div>

        <div class="mt-4 mt-xl-5 pt-xxl-3 pb-2 pb-lg-4 pb-xl-5 text-center all-works-link-wapper">

            <a href="{{\VthSupport\Classes\UrlHelper::exactLink('works')}}" title="{:WORKS:}" class="all-works-link">

                <span class="me-2">{:WORKS:}</span>

                @include('icon_svgs.down_arrow')

            </a>

        </div>

    </div>

</div>

