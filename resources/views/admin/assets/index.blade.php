@extends('layouts.admin')

@section('page_title')
  ASSETS
@endsection

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">ASSETS</span>
    <div class="page_operation_div">
      <a class="upload_assets_btn operation_btn btn btn-primary" href="{{route('admin.assets.create')}}">ADD NEW</a>
    </div>

    <div class="assets_container">
      @foreach ($assets as $asset)
        <div class="assets_item_container">
          <img src="{{asset($asset->thumbnail_img)}}" alt="">
          <a href="#" class="user_thumbnail"><img src="http://via.placeholder.com/150x150" alt="" class=""></a>
          <a href="#" class="play_button">PLAY</a>
        </div>
      @endforeach
    </div>
  </div>
@endsection
