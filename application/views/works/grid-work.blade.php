@if (count($list_data) > 0)
    @if ($pp > 0)
        {@ $arrProject = isset($list_data) ? array_chunk($list_data,6) : []; @}
        @foreach ($arrProject as $k => $arr)
            {@ $i = $k + 1; @}
            @foreach ($arr as $k1 => $itemProject)
                {@ $j = $k1 + 1; @}
                @include('project.item', ['item' => $itemProject, 'i' => $i, 'j' => $j])
            @endforeach
        @endforeach
    @else
        <div class="garelly-we__dos">
            <div class="js-grid my-shuffle">
                {@ $arrProject = isset($list_data) ? array_chunk($list_data,6) : []; @}
                @foreach ($arrProject as $k => $arr)
                    {@ $i = $k + 1; @}
                    @foreach ($arr as $k1 => $itemProject)
                        {@ $j = $k1 + 1; @}
                        @include('project.item', ['item' => $itemProject, 'i' => $i, 'j' => $j])
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
    <div class="pagination works-page-pagination">
        {%PAGINATION%}
    </div>
@else
    @if ($pp == 0)
        <p class="no__result">{:NO_RESULT:}</p>
    @endif
@endif
