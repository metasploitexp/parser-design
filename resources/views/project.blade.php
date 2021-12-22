
<link rel="stylesheet" href="https://arkhitex.ru/local/templates/arkhitex/css/bootstrap.min.css?1566828325140936">
<link rel="stylesheet" href="https://arkhitex.ru/bitrix/cache/css/s1/arkhitex/template_647859fb7986a48265595310fa9c5bc8/template_647859fb7986a48265595310fa9c5bc8_v1.css?1638532283318571">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/solid.min.css">
    
    <section class="pt-5">
        <div class="container">
            <h1 class="arkhitex-detail-title m-0">
                {{$project['title']}}
            </h1>
            <hr>
            <div class="row">
                @foreach($newProject as $key=>$param)
                    <div class="col-auto mb-4">
                        <div class="font-15 gray mb-2">
                            {{$param[0]}}
                        </div>
                        <div class="font-16 gold">  
                            @if($param[0] == 'Чертеж проекта') 
                                <a href="/storage/uploads/plans/{{$param[1][0]}}">Загрузить</a>
                            @else 
                                {{html_entity_decode($param[1])}}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="planirovki-detail-slider-area">
        <div class="container">
            <div class="planirovki-detail-slider">
                @foreach($project as $key=>$images)
                    @if ($key == 'images')
                        @foreach($images as $image)
                            <a class="mr-4" href="/storage/uploads/projects/{{$image}}" data-fancybox="gal">
                                <img src="/storage/uploads/projects/{{$image}}" width="634" height="476" />
                            </a>
                        @endforeach
                    @endif
                @endforeach                 
            </div>
        </div>
    </section>
    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col-12 col-md-8 mb-4">
                    <div class="font-18 strong mb-2">Описание</div>
                    <div class="font-18 line-height15 mb-4">{{html_entity_decode($project['description'])}}</div>
                    <div class="font-18 strong mb-3">
                        Что входит?
                    </div>
                    <div class="what-is-included mb-4">
                        @foreach($plans as $key => $plan)
                            <a class="collapsed d-block mb-2" href="#what-is-included-{{$key}}" data-toggle="collapse" aria-expanded="false" aria-controls="what-is-included-{{$key}}">
                                <i class="fas fa-minus-square fa-fw gold mr-2"></i>{{$plan['title']}}
                            </a> 
                            <div id="what-is-included-{{$key}}" class=" form-row align-items-center collapse lightgray-bg p-3 mb-2">
                                <a class="col-12" href="/storage/uploads/plans/{{$plan['image']}}" data-fancybox >
                                    <img src="/storage/uploads/plans/{{$plan['image']}}" style="max-width:100%">
                                </a>
                            </div>
                        @endforeach
                    </div>  
                </div>
                <div class="col-12 col-md-4">
                    <div class="lightgray-bg p-4 mb-4">
                        @foreach($newProject as $key=>$param)
                            <div class="mb-4 px-lg-2">
                                <div class="font-15 gray mb-2">
                                    {{$param[0]}}
                                </div>
                                <div class="font-18 gold ">
                                    @if($param[0] == 'Чертеж проекта') 
                                        <a href="/storage/uploads/plans/{{$param[1][0]}}">Загрузить</a>
                                    @else 
                                        {{html_entity_decode($param[1])}} 
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
<script type="text/javascript" src="https://arkhitex.ru/local/templates/arkhitex/js/jquery-3.4.1.min.js" ></script>
<script type="text/javascript" src="https://arkhitex.ru/bitrix/js/main/core/core_ls.min.js?15668283077365"></script>
<script type="text/javascript"  src="https://arkhitex.ru/bitrix/cache/js/s1/arkhitex/kernel_api_core/kernel_api_core_v1.js?163784418612783"></script>
<script type="text/javascript"  src="https://arkhitex.ru/bitrix/cache/js/s1/arkhitex/template_84c4bd3dd0a6ad38ec79f66f2ea0be11/template_84c4bd3dd0a6ad38ec79f66f2ea0be11_v1.js?1637844186463574"></script>
<script type="text/javascript"  src="https://arkhitex.ru/bitrix/cache/js/s1/arkhitex/page_f788cbc62d25220852328a9e0e238b37/page_f788cbc62d25220852328a9e0e238b37_v1.js?16378441861174"></script>
