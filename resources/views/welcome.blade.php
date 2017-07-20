@extends('layouts.landing')

@section('page_title')
  Video Puzzle
@endsection

@section('styles')
  <style media="screen">
  </style>
@endsection

@section('content')


  <div class="homepage_slider">
    <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
        @foreach ($assets as $key => $asset)
          @if ($asset->number > 0)
            @if ($key == 0)
              <li data-target="#myCarousel" data-slide-to="{{$key}}" class="active"></li>
            @elseif ($key > 0)
              <li data-target="#myCarousel" data-slide-to="{{$key}}"></li>
            @endif
          @endif

        @endforeach
      </ol>
      <div class="carousel-inner">
        @foreach ($assets as $key => $asset)
          @if ($asset->number > 0)
            @if ($key == 0)
              <div class="item active">
                <img class="d-block img-fluid" src="{{asset($asset->thumbnail_img)}}" alt="{{$asset->title}}">
                <div class="ui dimmer">

                  <div class="content">

                    <div class="landing_item_container">
                      <a class="color_white font_size18 title" href='{{route('landing.video.show', $asset->id)}}' title="{{$asset->title}}">{{$asset->title}}</a>
                      <a href="{{route('landing.puzzle.show', $asset->id)}}" class="ui inverted button">Play Puzzle</a>
                    </div>
                  </div>
                </div>
              </div>
            @elseif ($key > 0)
              <div class="item">
                <img class="d-block img-fluid" src="{{asset($asset->thumbnail_img)}}" alt="{{$asset->title}}">
                <div class="ui dimmer">
                  <div class="content">
                    <div class="landing_item_container">
                      <a class="color_white font_size18 title" href='{{route('landing.video.show', $asset->id)}}' title="{{$asset->title}}">{{$asset->title}}</a>
                      <a href="{{route('landing.puzzle.show', $asset->id)}}" class="ui inverted button">Play Puzzle</a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endif
        @endforeach

      </div>
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>

  <div class="assets_container">
    <h3 class="ui horizontal divider header">
      <i class="video play outline icon"></i>
      New Video
    </h3>
    <div class="ui link special cards" style='padding:10px 40px 80px;'>
      @foreach ($assets_current_month as $asset)

        <div class="card assets_item_container">
          <div class="blurring dimmable image">
            <div class="ui dimmer">
              <div class="content">
                <div class="center">
                  <a href="{{route('landing.puzzle.show', $asset->id)}}" class="ui inverted button">Play Puzzle</a>
                </div>
              </div>
            </div>
            <img src="{{asset($asset->thumbnail_img)}}" class="">
          </div>
          <div class="content">
            <a class="header ellipsis_content" href='{{route('landing.video.show', $asset->id)}}' title="{{$asset->title}}">{{$asset->title}}</a>
            <div class="meta">
              <span class="date">Create {{$asset->created_at->diffForHumans()}}</span>
            </div>
          </div>
        </div>
      @endforeach

      <div class="pagination_container">
        {{-- {{$assets_current_month->links()}} --}}
        @include('pagination.default', ['paginator' => $assets_current_month])
      </div>

    </div>

  </div>

@endsection

@section('scripts')
  <script type="text/javascript">
    // $("#myCarousel").carousel({
    //   interval: 2000
    // });
    $('.carousel-inner .item').dimmer({
      on: 'hover'
    });
    $('.special.cards .image').dimmer({
      on: 'hover'
    });
  </script>
@endsection
