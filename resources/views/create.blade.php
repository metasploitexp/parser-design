@extends('layouts.master')
@section('title', 'create')
@section('content')
   
    <form class="container col-6" enctype="multipart/form-data" action="{{$action}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$designer['id']}}">
        <div class="mb-3">
          <label for="exampleInputName" class="form-label">Имя дизайнера:</label>
          <input type="name" name="designer" value="{{$designer['name'] ?? ''}}" class="form-control" id="exampleInputName" aria-describedby="nameHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputSpecial" class="form-label">Специализация:</label>
            <input type="special" name="special"  value="{{$designer['speciality'] ?? ''}}" class="form-control" id="exampleInputspecial" aria-describedby="specialHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputCity" class="form-label">Город:</label>
            <input type="city" name="city"  value="{{$designer['city'] ?? ''}}" class="form-control" id="exampleInputCity" aria-describedby="cityHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputDescription" class="form-label">О себе:</label>
            <textarea class="form-control"  name="description" type="description" id="exampleInputDescription" aria-describedby="descriptionHelp">{{$designer['description'] ?? ''}}</textarea>
        </div>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Фотографии:</label>
            <input class="form-control" name="files[]" type="file" id="formFileMultiple" multiple>
        </div>
        {{-- {{dd($designer['images'])}} --}}
        @foreach($designer['images'] as $key=>$image)
        <div class="mb-3 img-container" data-id="{{$image}}">
            <img src="/storage/uploads/designers/{{$image}}" width="400" height="200" alt=""> &nbsp;
            <button type="button" class="btn btn-danger delete">delete</button>
        </div>
        @endforeach
        <input type="hidden" name="files_to_delete">
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    <script type="text/javascript" src="/js/create.js"></script>
@endsection
