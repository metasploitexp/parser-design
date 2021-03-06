@extends('layouts.master')
@section('title', 'create project')
@section('content')
    <style>
        .container {
            position: relative;
            top: 50px;
        }
    </style>
    <form class="container col-6" enctype="multipart/form-data" action="{{$action}}" method="post">
        @csrf
        <input type="hidden" value="{{$id ?? ''}}" name="id">
        <div class="mb-3">
            <label for="exampleInputName" class="form-label">Имя дизайнера:</label>
                <select class="form-control" name="selected">
                    <option selected>Выберите...</option>
                    @foreach($designers as $designer)
                        <option value="{{$designer['id']}}">{{$designer['name']}}</option>
                    @endforeach
                </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Название проекта:</label>
            <input type="text" value="{{$project['title'] ?? ''}}" name="title" class="form-control" id="exampleInputTitle" aria-describedby="titleHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputStyle" class="form-label">Стиль:</label>
            <input type="text" value="{{$project['style'] ?? ''}}" name="style" class="form-control" id="exampleInputStyle" aria-describedby="styleHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPrice" class="form-label">Цена:</label>
            <input type="number" value="{{$project['price'] ?? ''}}" name="price" class="form-control" id="exampleInputPrice" aria-describedby="priceHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputFullPrice" class="form-label">Полная стоимость:</label>
            <input type="text" value="{{html_entity_decode($project['fullPrice'] ?? '')}}" name="fullPrice" class="form-control" id="exampleInputFullPrice" aria-describedby="fullPriceHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputFootage" class="form-label">Метраж:</label>
            <input type="text" value="{{$project['footage'] ?? ''}}" name="footage" class="form-control" id="exampleInputFootage" aria-describedby="footageHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputProductionTime" class="form-label">Сроки производства:</label>
            <input type="text" value="{{$project['productionTime'] ?? ''}}" name="productionTime" class="form-control" id="exampleInputProductionTime" aria-describedby="productionTimeHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputChooseOption" class="form-label">Выбранная опция:</label>
            <input type="text" value="{{$project['chooseOption'] ?? ''}}" name="chooseOption" class="form-control" id="exampleInputChooseOption" aria-describedby="chooseOptionHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputSection" class="form-label">Раздел:</label>
            <input type="text" value="{{$project['section'] ?? ''}}" name="section" class="form-control" id="exampleInputSection" aria-describedby="sectionHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputDescription" class="form-label">Описание:</label>
            <textarea type="text" name="description" class="form-control" id="exampleInputDescription" aria-describedby="descriptionHelp">{{$project['description'] ?? ''}}</textarea>
        </div>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Фотографии:</label>
            <input class="form-control" name="images[]" type="file" id="formFileMultiple" multiple>
        </div>
        
        @if(Route::currentRouteName() !== 'create' && isset($projects['images']))
            @foreach($project['images'] as $key=>$image)
            <div class="mb-3 img-container" data-id="{{$image}}">
                <img src="/storage/uploads/projects/{{$image}}" width="400" height="200" alt=""> &nbsp;
                <button type="button" class="btn btn-danger delete">delete</button>
            </div>
            @endforeach
        @endif
        <input type="hidden" name="files_to_delete">
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    <script type="text/javascript" src="/design/js/create.js"></script>
@endsection