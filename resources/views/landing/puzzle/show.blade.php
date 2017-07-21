@extends('layouts.landing')

@section('page_title')
  {{$asset->title}}
@endsection

@section('header_section_content')
  <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('styles')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="{{asset('css/range.css')}}">
@endsection

@section('content')
  {{-- puzzle parameter initialize --}}
  @php
    $matrix_x = 6;
    $matrix_y = 3;
  @endphp

  <div class="body_container" style='margin: 0;'>

    {{-- operation area --}}
    <div class="puzzle_operation_wrapper segment bg_white">
      <button class="ui button play_pause_btn_video">
        <i class="pause icon"></i>
        <span class="play_pause_btn_title">Pause</span>
      </button>
      <div class="volume_slider_wrapper">
        <i class="volume up icon volume_btn"></i>
        <div class="ui range volume_range_slider" id="volume_range"></div>
      </div>
      <button class="ui small inverted blue button preview_trigger_btn">
        <i class="film icon"></i>
        Preview
      </button>


      {{-- personal best record & duration - timer --}}
      @php
        if ($personal_best_record_duration != "") {
          echo "<div class='ui label large best_record_wrapper margin_leftauto'>
            <span class='detail'>Best Record</span>
            <span class='duration'>".$personal_best_record_duration."</span>
          </div>
          <div class='ui label large timer_wrapper'>
            <span class='detail'>Duration</span>
            <span class='duration'>0:00</span>
          </div>
          ";
        }
        else {
          echo "<div class='ui label large timer_wrapper margin_leftauto'>
            <span class='detail'>Duration</span>
            <span class='duration'>0:00</span>
          </div>
          ";
        }

      @endphp



      {{-- complete video taken time - timer --}}

    </div>

    {{-- puzzle area --}}
    <div class="puzzle_wrapper">
      <div class="puzzle_grids_wrapper">
        @for ($x=0; $x < $matrix_y ; $x++)
          @for ($y=0; $y < $matrix_x; $y++)
            <div class="grid_item{{$y}}{{$x}}">

            </div>
          @endfor
        @endfor
      </div>
    </div>


    {{-- preview container --}}
    <div class="position_right_top20">
      <div class="video_preview_wrapper" data-max-width='' data-max-height='' data-min-width='' data-min-height=''>
        <button class="circular ui red small icon button close_preview_button" title='close'>
          <i class="remove icon"></i>
        </button>
        <canvas id="target_video" width="" height=""></canvas>
      </div>


    </div>


    {{-- source video --}}
    <video id="v" loop="" autoplay="" class="source_video">
      @php
        $format = "mp4";
        if (strtolower($asset->format) == 'ogv') {
          $format = 'ogg';
        }
        elseif (strtolower($asset->format) == 'mp4') {
          $format = "mp4";
        }
      @endphp
      <source src="{{asset($asset->path)}}" type="video/{{$format}}"/>
    </video>



  </div>
  {{-- congratulation lightbox --}}
  <div class="lightbox congratulation_lightbox special_close">
    <div class="lightbox_content_transparent not_to_close">
      <div class="congratulation_wrapper">
        <div class="congratulations_title">
          <span class="congratulations_text color_lightpink font_size29">Congratulations!</span> <br>
          <span class="complete_puzzle_text font_size15">You have complete the puzzle.</span>
        </div>
        <div class="puzzle_thumbnail_wrapper">
          <img src="{{asset($asset->thumbnail_img)}}" alt="">
          <button type="button" name="button" class="confirm_complete color_lightgreen font_size25">Confirm</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    var finish_puzzle = {{$matrix_x * $matrix_y}};
    var puzzle_matched = 0;
    var matrix_x = {{$matrix_x}};
    var matrix_y = {{$matrix_y}};
    var puzzle_id = 0;
  </script>
  <script src="{{asset('js/jquery-ui.min.js?v='.str_random(20))}}"></script>
  <script src="{{asset('js/jquery.runner.js?v='.str_random(20))}}" charset="utf-8"></script>
  {{-- <script src="{{asset('js/jqueryui_for_puzzle.js?v='.str_random(20))}}" charset="utf-8"></script> --}}

  <script src="{{asset('js/jquery.ui.touch-punch.min.js?v='.str_random(20))}}" charset="utf-8"></script>
  <script src="{{asset('js/puzzle.js?v='.str_random(20))}}" charset="utf-8"></script>
  <script src="{{asset('js/range.js?v='.str_random(20))}}" charset="utf-8"></script>
  <script type="text/javascript">
    @for ($x = 0; $x < $matrix_x; $x++)
      @for ($y = 0; $y < $matrix_y; $y++)
        $('.grid_item{{$x}}{{$y}}').droppable({
          accept: '#pieaces_{{$x}}{{$y}}',
          drop: function( event, ui ) {
             var droppable = $(this);
             var draggable = ui.draggable;

             // Move draggable into droppable
             draggable.appendTo(droppable);
             draggable.css({top: '0px', left: '0px'});

             // match then add counter
             puzzle_matched+=1;

             // when puzzle complete
             if(finish_puzzle == puzzle_matched) {
               $('.timer_wrapper .duration').runner('stop');

               // get complete duration
               var duration = $('.timer_wrapper .duration').text();
               // update puzzle complete duration
               completepuzzle (puzzle_id, duration);

               // show congratulations
               $('.congratulation_lightbox').fadeIn('slow', function() {
                 $('.puzzle_thumbnail_wrapper').transition('tada', function() {
                   $('.confirm_complete').transition('jiggle');
                 });
               }).css({'display':'flex'});
             }

             ui.draggable.draggable('destroy');
          }
        });
      @endfor
    @endfor


    // confirm complete
    $('.confirm_complete').click(function() {
      $('.congratulation_lightbox').fadeOut();
    });

    function completepuzzle (puzzle_id, duration) {
      // var token = $('meta[name="_token"]').attr('content')
      // $.ajaxSetup({
      //   headers: {
      //     'X-CSRF-TOKEN': token
      //   }
      // });
      //
      // $.ajax({
      //   type: 'POST',
      //   data: { 'puzzle_id': puzzle_id, 'duration': duration },
      //   url: '{{route('admin.puzzles.completepuzzle')}}',
      //   success: function(response){
      //   }
      // });
    }
  </script>
@endsection
