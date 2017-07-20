@extends('layouts.landing')

@section('page_title')
  Assets
@endsection

@section('styles')
  <style media="screen">
  </style>
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
    $('.special.cards .image').dimmer({
      on: 'hover'
    });
  </script>
@endsection
