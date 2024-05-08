<!--DBS-loop.services_categories.1|where:act = 1,home = 1|order:ord asc|limit:-->
<!--DBE-loop.services_categories.1-->
@if (count($arrservices_categories1) > 0)
	<div class="list-service-category mb-5 pb-lg-3 pb-xxl-4 ">
		@foreach ($arrservices_categories1 as $key => $itemservices_categories1)
			<div class="item-service-category px-3 px-md-4 py-3 ">
				<div class="d-flex align-items-center justify-content-between header-item">
					<h2 class="item-title mb-0 text-black">{(itemservices_categories1.name)}</h2>
					<span class="d-inline-block icon-status pt-1">
						<span class="plus-ic">@include('icon_svgs.plus')</span>
						<span class="minus-ic">@include('icon_svgs.minus')</span>
					</span>
				</div>
				<div class="content-item mt-3 mt-xxl-4 content_service" style="display: none">
					<ul>
                        <!--DBS-loop.services.1|where:act = 1,home = 1,FIND_IN_SET(\''.$itemservices_categories1['id'].'\';parent) > 0|ord:ord asc-->
                        <li><a data-animation="animated fadeInUpBig" class="text-black" href="javascript:void(0)" title="{(itemservices1.name)}">{(itemservices1.name)}</a></li>
                        <!--DBE-loop.services.1-->
                    </ul>
				</div>
			</div>
		@endforeach
	</div>
@endif