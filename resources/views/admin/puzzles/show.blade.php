@extends('layouts.admin')

@section('page_title')
  {{$puzzle->title}}
@endsection

@section('content')
  {{-- puzzle parameter initialize --}}
  @php
    $matrix_x = 6;
    $matrix_y = 3;
  @endphp

  <div class="body_container">
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

    <video id="v" loop="" muted autoplay="" class="video_preview_wrapper">
      @php
        $format = "mp4";
        if (strtolower($puzzle->format) == 'ogv') {
          $format = 'ogg';
        }
        elseif (strtolower($puzzle->format) == 'mp4') {
          $format = "mp4";
        }
      @endphp
      <source src="{{asset($puzzle->path)}}" type="video/{{$format}}"/>
      <!-- <source src="assets/Test_avi.ogv" type="video/ogg"/> -->
      <!-- <source src="assets/small.webm" type="video/webm"/> -->

      <!-- <source src="assets/jl.mp4" type="video/mp4"/> -->
    </video>

  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/draggable.js?v='.str_random(20))}}" charset="utf-8"></script>
  <script src="{{asset('js/puzzle.js?v='.str_random(20))}}" charset="utf-8"></script>
  <script type="text/javascript">
    var matrix_x = {{$matrix_x}};
    var matrix_y = {{$matrix_y}};
    <?php
      for ($x=0; $x < $matrix_x; $x++) {
        for ($y=0; $y < $matrix_y; $y++) {
          echo "$( '.grid_item$x$y').droppable({
            accept: '#pieaces_$x$y',
            drop: function( event, ui ) {
               var droppable = $(this);
               var draggable = ui.draggable;
               // Move draggable into droppable
               draggable.appendTo(droppable);
                draggable.css({top: '0px', left: '0px'});
            }
          });";
        }
      }
    ?>
  </script>
@endsection
