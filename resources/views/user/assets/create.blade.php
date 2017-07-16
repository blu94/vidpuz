@extends('layouts.user')

@section('page_title')
  UPLOAD ASSETS
@endsection

@section('header_section_content')
  <meta name="_token" content="{!! csrf_token() !!}"/>
@endsection

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">UPLOAD ASSETS</span>

    {!! Form::open(['method'=>'POST', 'action'=>'user\UserAssetController@store_asset', 'class'=>'upload_area dropzone', 'enctype'=>'multipart/form-data']) !!}
      <div class="dz-message" data-dz-message><img src="{{asset('icon/cloud_computing_neon_blue.svg')}}" class="upload_icon" alt=""><span class="dz_placeholder"> Select video to upload<br>Please do not close the page when uploading</span></div>
    {!! Form::close() !!}

    <div class="uploaded_item_wrapper col-md-12 col-sm-12">

    </div>
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
        this.on("addedfile", function(file) {

        });
        this.on("success", function(file, response) {
          this.removeFile(file);
          $('.uploaded_item_wrapper').append(response);

        });
      }
    });



  </script>
@endsection
