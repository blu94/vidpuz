@extends('layouts.admin')

@section('page_title')
  ASSETS
@endsection

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
@endsection

@section('search_wrapper')
  <div class="search_bar">
    <button type="button" name="button" class="search_btn">
      <img src="{{asset('icon/search_white.svg')}}" alt="">
    </button>
  </div>
  <div class="lightbox search_lightbox special_close">
    <div class="lightbox_content_transparent search_wrapper not_to_close">
      {!! Form::open(['method' => 'GET', 'action' => 'admin\AdminAssetController@index', 'id' => 'search_form']) !!}
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
    <span class="page_title">ASSETS</span>

    @include('layouts.includes.message')

    {!! Form::open(['method' => 'POST', 'action' => 'admin\AdminAssetController@bulk_action']) !!}

      <div class="page_operation_div">
        @php
          $date = date('YmdHis');
        @endphp
        {{-- {!! Form::button('Bulk Action', ['class' => '']) !!} --}}
        <button type="button" class="ui button bg_white pull-left bulk_action_trigger">
          <i class="align justify icon"></i>
          Bulk Action
        </button>

        <div class="bulk_action_group">
          <div class="ui buttons col-sm-3 pull-left ">
            <button class="ui button color_white cancel_bulk_action" type="button" name='bulk_action_cancel'>CANCEL</button>
            {!! Form::select('bulk_action_select', ['' => 'Bulk Action', 'delete' => 'Delete', 'public' => 'Public selected asset', 'private' => 'Private selected asset'], null, ['class' => 'ui button bulk_action_select']) !!}
            <button class="ui primary button submit_bulk_action" type="submit" name='bulk_action_submit'>APPLY</button>

          </div>
        </div>


        <a class="upload_assets_btn operation_btn ui blue button" href="{{route('admin.assets.create')}}">ADD NEW</a>
      </div>

      <div class="assets_container">
        <div class="ui link special cards">
          @if (count($assets) > 0)
            @foreach ($assets as $asset)
              {{-- <div class="assets_item_container">
                <img src="{{asset($asset->thumbnail_img)}}" class="asset_thumnail redirect_to_page" data-redirect-url='{{route('admin.assets.edit', $asset->id)}}'>
                <a href="{{route('admin.users.edit', $asset->uploader->id)}}" class="user_thumbnail">
                  @if ($asset->uploader->profileimage() == NULL)
                    <img src="http://via.placeholder.com/150x150" alt="" class="">
                  @elseif ($asset->uploader->profileimage() != NULL)
                    <img src="{{$asset->uploader->profileimage()->path}}" alt="" class="">
                  @endif

                </a>
                <a href="{{route('admin.puzzles.show', $asset->id)}}" class="play_button">PLAY</a>
                <div class="bulk_action_checkbox_container">
                  <span class="tick_symbol color_white">&#x2714;</span>
                  <input type="checkbox" name="bulk_action_checkbox[]" class="bulk_action_checkbox" value="{{$asset->id}}">
                </div>

              </div> --}}
              @php
                $unique_id = bcrypt($asset->id);
              @endphp
              <div class="card assets_item_container" data-asset-id='{{$unique_id}}'>
                <div class="bulk_action_checkbox_container">
                  <span class="tick_symbol color_white">&#x2714;</span>
                  <input type="checkbox" name="bulk_action_checkbox[]" class="bulk_action_checkbox" value="{{$asset->id}}">
                </div>
                <div class="blurring dimmable image">
                  <div class="ui dimmer">
                    <div class="content">
                      <div class="center">
                        <a href="{{route('admin.puzzles.show', $asset->id)}}" class="ui inverted button">Play</a>
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
                  <a class="header ellipsis_content" href='{{route('admin.assets.edit', $asset->id)}}' title="{{$asset->title}}">{{$asset->title}}</a>
                  <div class="meta">
                    <span class="date">Create {{$asset->created_at->diffForHumans()}}</span>
                  </div>
                </div>
                <div class="content redirect_to_page" data-redirect-url='{{route('admin.users.edit', $asset->uploader->id)}}'>
                  {{-- <div class="right floated meta">{{$asset->created_at->diffForHumans()}}</div> --}}
                  @if ($asset->uploader->profileimage() == NULL)
                    <img src="http://via.placeholder.com/150x150" alt="" class="ui avatar image">
                  @elseif ($asset->uploader->profileimage() != NULL)
                    <img src="{{$asset->uploader->profileimage()->path}}" alt="" class="ui avatar image">
                  @endif
                  {{$asset->uploader->username}}
                </div>
              </div>
            @endforeach
          @elseif (count($assets) == 0)
            <p class="description text-center padd_20 col-md-12 col-sm-12">
              No asset yet.
            </p>
          @endif


        </div>

      </div>
    {!! Form::close() !!}

  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
  var content = [
    @foreach ($search_options as $option_key => $option)
    {
      'title' : '{{$option->title}}',
      'url' : '{{route('admin.assets.index')}}?search={{$option->title}}'
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
