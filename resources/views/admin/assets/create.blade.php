@extends('layouts.admin')

@section('page_title')
  UPLOAD ASSETS
@endsection

@section('header_section_content')
  <meta name="_token" content="{!! csrf_token() !!}"/>
@endsection

@section('styles')
  <link href="http://vjs.zencdn.net/6.2.4/video-js.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">UPLOAD ASSETS</span>

    {!! Form::open(['method'=>'POST', 'action'=>'admin\AdminAssetController@store_asset', 'class'=>'upload_area dropzone', 'enctype'=>'multipart/form-data']) !!}
      {{ csrf_field() }}
      <div class="dz-message" data-dz-message><img src="{{asset('icon/cloud_computing_neon_blue.svg')}}" class="upload_icon" alt=""><span class="dz_placeholder"> Select video to upload<br>Please do not close the page when uploading</span></div>
    {!! Form::close() !!}

    {!! Form::open(['method' => 'POST', 'action' => 'admin\AdminAssetController@save_asset', 'class' => 'uploaded_item_wrapper col-md-12 col-sm-12']) !!}
      {{ csrf_field() }}
    {!! Form::close() !!}
  </div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" charset="utf-8"></script>
  <script src="{{asset('js/jqueryui_for_puzzle.js')}}" charset="utf-8"></script>
  <script src="{{asset('js/jquery.ui.touch-punch.min.js?v='.str_random(20))}}" charset="utf-8"></script>
  <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
  <script src="http://vjs.zencdn.net/6.2.4/video.js"></script>
  <script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(".dropzone").dropzone({
      acceptedFiles: ".mp4,.MP4,.ogv,.OGV",
      maxFiles: 1,
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        formData.append("_token", "{{ csrf_token() }}");
      },
      init: function(){
        this.on("addedfile", function(file) {

        });
        this.on("success", function(file, response) {
          this.removeFile(file);
          $('.dropzone').remove();

          var array = jQuery.parseJSON(response);

          var uploadedfile_url = '{{asset('%item_path%')}}';

          uploadedfile_url = uploadedfile_url.replace('%item_path%', array['url']);


          var contents = "<div class='uploaded_file_container' id='' data-file-id=''><div class='ui input uploaded_file_input_wrapper col-md-9 col-sm-9'><input type='text' name='video_name' class='uploaded_file_title col-sm-12' value='"+array['name']+"' data-file-id=''/></div><div class='ui input uploaded_file_input_wrapper col-md-3 col-sm-3'><button class='blue ui button save_edt col-sm-12' data-file-id=''>SAVE</button></div><div class='uploaded_video_preview_wrapper col-md-12 col-sm-12'><video id='target_video_id' src='"+uploadedfile_url+"' class='uploaded_video_target'><source src='"+uploadedfile_url+"' type='video/"+array['format']+"'></video></div><div class='uploaded_video_length_wrapper'><div class='uploaded_video_length_container bg_lightpink'><div class='ten_sec_container' style='width:"+array['tensecwidth']+"%;'></div></div></div></div><input type='hidden' name='url' value='"+array['url']+"'><input type='hidden' name='starttime' class='video_starttime'><input type='hidden' name='format' value='"+array['format']+"'><input type='hidden' name='format' value='"+array['format']+"'>";
          $('.uploaded_item_wrapper').append(contents);

          edit_video (array);

        });
      }
    });

    var del_item_url = '{{route('admin.assets.removeuploadedasset', '%item_id%')}}';

    function edit_video (array) {
      $( ".ten_sec_container" ).draggable({
        containment: ".uploaded_video_length_container",
        start: function(event, ui){
          $('.uploaded_video_target').get(0).pause();
        },
        stop: function(event, ui){
          // get possition
          var $this = $(this);
          var thisPos = $this.position();
          var parentPos = $this.parent().position();
          var parentwidth = $this.parent().width();
          var x = thisPos.left - parentPos.left;
          var percentage = parseFloat(100 * (x / parentwidth)).toFixed(0);
          var starttime = 0;
          starttime = parseInt(array['videolength'] * (x / parentwidth));
          var endtime = parseInt(starttime) + 20;

          $('.video_starttime').val(starttime);

          playVideoTeaserFrom(starttime,endtime, $('#target_video_id').get(0));
        }
      });


      function playVideoTeaserFrom (starttime, endtime, target) {
          var videoplayer = target;  //get your videoplayer
          videoplayer.currentTime = starttime; //not sure if player seeks to seconds or milliseconds
          videoplayer.play();

          //call function to stop player after given intervall
          var stopVideoAfter = (endtime - starttime) * 1000;  //* 1000, because Timer is in ms
          stopplaying = setTimeout(function(){
              videoplayer.pause();
              clearTimeout(stopplaying);
          }, stopVideoAfter);

      }


      $(".ten_sec_container").bind('touchmove', function(e) {
        e.preventDefault();
      }, false);
    }



  </script>
@endsection
