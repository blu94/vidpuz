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
<<<<<<< HEAD
    
  </div>
@endsection
=======
    {{-- <form class="upload_area dropzone">
      <div class="dz-message" data-dz-message><img src="{{asset('icon/cloud_computing_neon_blue.svg')}}" class="upload_icon" alt=""><span class="dz_placeholder"> Select video to upload<br>Please do not close the page when uploading</span></div>
    </form> --}}
    {!! Form::open(['method'=>'POST', 'action'=>'admin\AdminAssetController@store', 'class'=>'upload_area dropzone']) !!}
      {!! csrf_field() !!}
      <div class="dz-message" data-dz-message><img src="{{asset('icon/cloud_computing_neon_blue.svg')}}" class="upload_icon" alt=""><span class="dz_placeholder"> Select video to upload<br>Please do not close the page when uploading</span></div>
    {!! Form::close() !!}
  </div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" charset="utf-8"></script>
@endsection
>>>>>>> parent of 573bb95... update
