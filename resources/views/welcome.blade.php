@extends('layouts.landing')

@section('page_title')
  Video Puzzle
@endsection

@section('styles')
  <style media="screen">
  </style>
@endsection

@section('search_link')
  <a href="#" class="header_item color_white search_link">Search</a>
@endsection

@section('search_wrapper')
  <div class="lightbox search_lightbox special_close">
    <div class="lightbox_content_transparent search_wrapper not_to_close">
      {!! Form::open(['method' => 'GET', 'action' => 'VideoController@index', 'id' => 'search_form']) !!}
        <div class="ui right huge aligned search_video search">
          <div class="ui icon input">
            <input class="prompt" type="text" name="search" placeholder="Search video...">
            <i class="search icon"></i>
          </div>
          <div class="results"></div>
        </div>
      {!! Form::close() !!}

    </div>
  </div>
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
                @php
                  $static_thumbnail = $gif_thumbnail = "";
                  foreach ($asset->video_thumnail as $thumbnail) {
                    if ($thumbnail->format == 'gif') {
                      $gif_thumbnail = $thumbnail->path;
                    }
                  }
                @endphp
                <img class="d-block img-fluid" src="{{asset($gif_thumbnail)}}" class="asset_thumbnail" alt="{{$asset->title}}">
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
                @php
                  $static_thumbnail = $gif_thumbnail = "";
                  foreach ($asset->video_thumnail as $thumbnail) {
                    if ($thumbnail->format == 'jpg') {
                      $static_thumbnail = $thumbnail->path;
                    }
                    if ($thumbnail->format == 'gif') {
                      $gif_thumbnail = $thumbnail->path;
                    }
                  }
                @endphp
                <img class="d-block img-fluid" src="{{asset($gif_thumbnail)}}" alt="{{$asset->title}}">
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
        @php
          $unique_id = bcrypt($asset->id);
        @endphp
        <div class="card assets_item_container" data-asset-id='{{$unique_id}}'>
          <div class="blurring dimmable image">
            <div class="ui dimmer">
              <div class="content">
                <div class="center">
                  <a href="{{route('landing.puzzle.show', $asset->id)}}" class="ui inverted button">Play Puzzle</a>
                </div>
              </div>
            </div>
            @php
              $static_thumbnail = $gif_thumbnail = "";
              foreach ($asset->video_thumnail as $thumbnail) {
                if ($thumbnail->format == 'jpg') {
                  $static_thumbnail = $thumbnail->path;
                }
                if ($thumbnail->format == 'gif') {
                  $gif_thumbnail = $thumbnail->path;
                }
              }
            @endphp
            <img src="{{asset($static_thumbnail)}}" data-asset-id='{{$unique_id}}' data-gif-thumbnail='{{asset($gif_thumbnail)}}' class="asset_thumbnail">
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

    var content = [
      @foreach ($search_options as $option_key => $option)
      {
        'title' : '{{$option->title}}',
        'url' : '{{route('landing.video.index')}}?search={{$option->title}}'
      }
      @if (count($search_options) > $option_key)
      ,
      @endif
      @endforeach
    ];

    $('.search_video').search({
      source: content
    });

    $('.carousel-inner .item').dimmer({
      on: 'hover'
    });
    $('.special.cards .image').dimmer({
      on: 'hover'
    });
  </script>
@endsection
