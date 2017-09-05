@extends('layouts.user')

@section('page_title')
  {{$asset->title}}
@endsection

@section('styles')
  <link rel="stylesheet" href="{{asset('css/bootstrap-tokenfield.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('search_wrapper')
  <div class="search_bar">
    <button type="button" name="button" class="search_btn">
      <img src="{{asset('icon/search_white.svg')}}" alt="">
    </button>
  </div>
  <div class="lightbox search_lightbox special_close">
    <div class="lightbox_content_transparent search_wrapper not_to_close">
      {!! Form::open(['method' => 'GET', 'action' => 'user\UserAssetController@index', 'id' => 'search_form']) !!}
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
  <div class="body_container">



    @if ($asset->uploader->id == Auth::user()->id)
      <span class="page_title">EDIT {{$asset->usage}}</span>

      @include('layouts.includes.message')

      {!! Form::open(['method' => 'PATCH', 'action' => ['user\UserAssetController@update', $asset->id], 'class' => 'form_input_container col-md-12 col-sm-12']) !!}
        {!! csrf_field() !!}

        <div class="input_container no_pad_left_right col-md-5 col-sm-12">
          {!! Form::label('title', 'Title', ['class'=>'input_label font_size12']) !!}
          {!! Form::text('title', $asset->title, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Title']) !!}
        </div>
        <div class="col-md-6 col-sm-12">
        </div>
        <div class="input_container col-md-1 col-sm-12">
          @php
            $asset_status = "Public";
            $check_switch = "checked";
            if ($asset->is_public == 0) {
              $asset_status = "Private";
              $check_switch = "";
            }
            elseif ($asset->is_public == 1) {
              $asset_status = "Public";
              $check_switch = "checked";
            }
          @endphp
          {!! Form::label('is_public', $asset_status, ['class'=>'input_label font_size12 switch_title col-sm-12', 'data-file-id' => $asset->id]) !!}
          <label class='switch'>
            {{-- <input type='checkbox' class='switch_checkbox' name='is_public' data-file-id='{{$asset->id}}' {{$check_switch}}> --}}
            {!! Form::checkbox('is_public', null, null, ['class' => 'switch_checkbox', 'data-file-id'=>$asset->id, $check_switch=>'']) !!}
            <div class='slider round'></div>
          </label>
        </div>

        <div class="asset_file_wrapper">
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
          @if ($asset->usage == 'VIDEO')
            <video src="{{asset($asset->path)}}" class="video_file" controls poster="{{asset($static_thumbnail)}}">

            </video>
          @endif
        </div>

        <div class="input_container no_pad_left_right col-md-12 col-sm-12">
          {!! Form::label('description', 'Description', ['class'=>'input_label font_size12']) !!}
          {!! Form::textarea('description', $asset->description, ['class' => 'form-control']) !!}
        </div>

        <div class="input_container no_pad_left_right col-md-6 col-sm-12">
          {!! Form::label('tag', 'Tag', ['class'=>'input_label font_size12']) !!}
          <div class="ui fluid multiple search selection dropdown tags_input">
            {!! Form::hidden('tag', $tag_value) !!}
            <i class="dropdown icon"></i>
            <div class="default text">Select a tag</div>
            <div class="menu">
              @foreach ($all_tag as $tag)
                <div class="item">
                  {{$tag->title}}
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="input_container no_pad_left_right col-md-12 col-sm-12">
          {!! Form::submit('UPDATE', ['class' => 'ui blue button pull-right margin_left10', 'name'=>'operation_btn']) !!}

          {!! Form::submit('DELETE', ['class' => 'ui red button pull-right margin_left10', 'name'=>'operation_btn']) !!}

          <a href="{{route('user.puzzles.show', $asset->id)}}" class="ui blue button pull-right">PLAY</a>
        </div>

      {!! Form::close() !!}

    @elseif ($asset->uploader->id != Auth::user()->id)
      <h2 class="page_title" style="display:flex;align-items:center; ">
        {{$asset->title}}
        <a href="{{route('user.puzzles.show', $asset->id)}}" class="ui blue button margin_leftauto">PLAY</a>
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

    @endif

  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/jquery-ui.min.js')}}" charset="utf-8"></script>
  <script src="{{asset('js/bootstrap-tokenfield.min.js')}}" charset="utf-8"></script>
  <script type="text/javascript">
  var content = [
    @foreach ($search_options as $option_key => $option)
    {
      'title' : '{{$option->title}}',
      'url' : '{{route('user.assets.index')}}?search={{$option->title}}'
    }
    @if (count($search_options) > $option_key)
    ,
    @endif
    @endforeach
  ];

  $('.search_video').search({
    source: content
  });

  $('.form_input_container').keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

  $('.tags_input').dropdown({
      allowAdditions: true,
    });

  $('.tag_input').on('tokenfield:createtoken', function (event) {
  	var existingTokens = $(this).tokenfield('getTokens');
  	$.each(existingTokens, function(index, token) {
  		if (token.value === event.attrs.value)
  			event.preventDefault();
  	});
  });
  </script>
@endsection
