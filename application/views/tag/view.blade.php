@extends('index')

@section('content')

<?php 

    $FEATURE_PROJECT = getBlock("FEATURE_PROJECT","block");

    $DES_FEATURE_PROJECT = getBlock("DES_FEATURE_PROJECT","block");

?>

<main>

    <div class="body-pages">

       <div class="what-we__do mb-65">

            <div class="container-fluid">

                <div class="tops-prj__works mb-65 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">

                    <div class="text-project-works">

                        <p class="title-prjects">{(FEATURE_PROJECT.FEATURE_PROJECT)}</p>

                        <div class="s-content">

                            {(DES_FEATURE_PROJECT.DES_FEATURE_PROJECT)}

                        </div>

                    </div>

                    <div class="list-prj__works">

                        <ul>

                            <li class="active">

                                <a href="#" data-parent="0" class="ajax__load">Alls</a>

                            </li>

                             <!--DBS-loop.services_categories.1|where:act = 1,home = 1|ord:ord asc|limit:-->

                            <li>

                                <a href="#" class="ajax__load" data-parent="{(itemservices_categories1.id)}">{(itemservices_categories1.name)}</a>

                                <p class="number-prjs__works"> ({{_countReconds($itemservices_categories1['id'] ,'project')}}) </p>

                            </li>

                             <!--DBE-loop.services_categories.1-->

                        </ul>

                    </div>

                </div>

            <div class="result__ajax">

                @include("works.grid-work",['list_data'=>$list_data])

            </div>

        </div>

    </div>

</main>

@stop

