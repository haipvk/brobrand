@extends('index')

@section('content')

<main>

    <section class=" body-pages">

        <div class="content-recruitment__details content-write__blog  mb-100">

            <div class="container">

                <div class="s-content mb-100">

                    <h2 class="titles-recruitment__details">{(name)}</h2>

                    <div class="s-content">

                        {(content)}

                    </div>

                </div>

                <div class="author-names">
                    <!--DBS-loop.services.1|where:act = 1,id > $dataitem['id']|ord:ord asc|limit:0,1-->
                    <a href="{(itemservices1.slug)}" title="Next journal" class="next-pages__jounal">Next journal</a>
                    <!--DBE-loop.services.1-->
                    <h3 class="name-write__journal">{(name)}</h3>

                </div>

            </div>

        </div>

    </section>

</main>

@stop