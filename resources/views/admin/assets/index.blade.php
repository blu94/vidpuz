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
      <button type="button" name="button" class="upload_assets_btn operation_btn btn btn-primary">ADD NEW</button>
    </div>
    {{-- <form class="upload_area dropzone">
      <div class="dz-message" data-dz-message><img src="{{asset('icon/cloud_computing_neon_blue.svg')}}" class="upload_icon" alt=""><span class="dz_placeholder"> Select video to upload<br>Please do not close the page when uploading</span></div>
    </form> --}}
    {!! Form::open(['method'=>'POST', 'action'=>'admin\AdminAssetController@store', 'class'=>'upload_area dropzone', 'enctype'=>'multipart/form-data']) !!}
      <div class="dz-message" data-dz-message><img src="{{asset('icon/cloud_computing_neon_blue.svg')}}" class="upload_icon" alt=""><span class="dz_placeholder"> Select video to upload<br>Please do not close the page when uploading</span></div>
    {!! Form::close() !!}
  </div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(".dropzone").dropzone({
      acceptedFiles: ".mp4,.MP4,.ogv",
      maxFiles: 100,
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        formData.append("_token", "{{ csrf_token() }}");
      },
      init: function(){
        this.on("success", function(file, response) {
          alert(response);
        });
      }
    });
  </script>
@endsection
