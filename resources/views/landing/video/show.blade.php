@extends('layouts.landing')

@section('page_title')
  Assets
@endsection

@section('styles')
  <style media="screen">
  </style>
@endsection

@section('search_link')
  <a href="#" class="header_item color_white search_link">Search</a>
@endsection

@section('search_wrapper')
  <div class="search_bar">
    <button type="button" name="button" class="search_btn">
      <img src="{{asset('icon/search_white.svg')}}" alt="">
    </button>
  </div>
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
  <div class="col-md-12 col-sm-12" style="padding:0 20px 40px;">
    <h2 class="page_title" style="display:flex;align-items:center; ">
      {{$asset->title}}
      <a href="{{route('landing.puzzle.show', $asset->id)}}" class="ui blue button margin_leftauto">PLAY PUZZLE</a>
    </h2>

    <div class="asset_file_wrapper">
      @if ($asset->usage == 'VIDEO')
        <video src="{{asset($asset->path)}}" class="video_file" controls poster="{{asset($asset->thumbnail_img)}}">

        </video>
      @endif
    </div>

    <div class="ui item">
      <h3 class="ui left floated header">Description</h3>
      <div class="ui clearing divider"></div>
      <p>
        {{$asset->description}}
      </p>

      <h3 class="ui left floated header">Tag</h3>
      <div class="ui clearing divider"></div>
      <p>
        @if ($tag_value == "")
          No tag.
        @elseif ($tag_value != "")
          {{$tag_value}}
        @endif
      </p>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
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

    $('.special.cards .image').dimmer({
      on: 'hover'
    });
  </script>
@endsection
