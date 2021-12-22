<link rel="stylesheet" href="/css/second.css">
    
    <div class="designer-detail">
        <div class="gray-bg py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-auto">
                        <img class="mw-100 mb-4" src="/storage/uploads/designers/{{$designer['images'][0]}}"
                        width="200" height="130" alt="">
                    </div>
                    <div class="col">
                        <h1 class="font-24 mb-1">
                            {{$designer['name']}}
                        </h1>
                        <div class="font-14 mb-1">
                            {{$designer['speciality']}}
                        </div>
                        <div class="gray font-14 mb-4">
                            {{$designer['city']}}
                        </div>
                        <div class="font-16 strong mb-2">
                            О себе:
                        </div>
                        <div class="font-14 mb-1">
                            {{$designer['description']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <div class="font-44 mb-4">
                Проекты дизайнера
            </div>
            <div class="row align-items-stretch">
                @foreach($projects as $project)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-4">
                        <div class="indproject-list-item magazin-list-item">
                            <a class="indproject-list-item-img" href="/projects/{{$project['id']}}"
                            style="background-image: url(/storage/uploads/projects/{{$project['images'][0]}})"></a>
                            <div>
                                <div class="row">
                                    <div class="col">
                                        <a class="indproject-list-item-title strong" href="/projects/{{$project['id']}}">{{$project['title']}}</a>
                                        <div class="font-20 d-flex align-items-center">
                                            <span class="gray mr-2">Стоимость:</span>
                                            <span>{{html_entity_decode($project['fullPrice'])}}</span>
                                        </div>
                                    </div>
                                    <div class="col-auto pt-1">
                                        <div class="font-14">
                                            <span class="gray">
                                                Стиль:
                                            </span>
                                            <a href="#" class="gold">
                                                {{$project['style']}}
                                            </a>
                                        </div>
                                        <div class="font-14">
                                            <span class="gray">
                                                Автор:
                                            </span>
                                            <a href="#" class="gold">
                                                {{$project['author']}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>