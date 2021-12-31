    <link rel="stylesheet" href="/design/css/second.css">
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
