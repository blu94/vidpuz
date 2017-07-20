@extends('layouts.landing')

@section('page_title')
  Assets
@endsection

@section('styles')
  <style media="screen">
  </style>
@endsection

@section('content')
  <div class="assets_container">
    <h3 class="ui horizontal divider header">
      <i class="video play outline icon"></i>
      All Video
    </h3>
    <div class="ui link special cards" style='padding:10px 40px 40px;'>
      @foreach ($assets as $asset)

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
        @include('pagination.default', ['paginator' => $assets])
      </div>
    </div>

  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $('.special.cards .image').dimmer({
      on: 'hover'
    });
  </script>
@endsection
