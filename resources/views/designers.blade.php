    <link rel="stylesheet" href="https://arkhitex.ru/bitrix/cache/css/s1/arkhitex/template_647859fb7986a48265595310fa9c5bc8/template_647859fb7986a48265595310fa9c5bc8_v1.css?1638532283318571">
    <div class="container my-5">
        <h1>Дизайнеры</h1>
        <div class="row align-items-stretch">
            
            @foreach ($designers as $key=>$designer) 
            <div class="col-6 col-sm-4 col-md-4 col-lg-4 mb-4">
                <div class="indproject-list-item">
                    <a class="indproject-list-item-img" href="/designers/{{$designer['id']}}"
                     style="background-image: url(/storage/uploads/designers/{{$designer['images'][0]}}">
                     </a>
                    <div class="row align-items-center">
                        <div class="col">
                            <a class="indproject-list-item-title" href="/designers/{{$designer['id']}}">{{$designer['name']}}</a>
                        </div>
                    </div>
                    <div class="indproject-list-item-text">{{$designer['speciality']}}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
