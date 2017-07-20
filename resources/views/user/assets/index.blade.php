@extends('layouts.user')

@section('page_title')
  ASSETS
@endsection

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">ASSETS</span>

    @include('layouts.includes.message')

    {!! Form::open(['method' => 'POST', 'action' => 'user\UserAssetController@bulk_action']) !!}

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


        <a class="upload_assets_btn operation_btn ui blue button" href="{{route('user.assets.create')}}">ADD NEW</a>
      </div>

      <div class="assets_container">
        <h4 class="ui horizontal divider header">
          <i class="video play outline icon"></i>
          User's Asset
        </h4>
        <div class="ui link special cards">
          @foreach ($assets as $asset)
            {{-- <div class="assets_item_container">
              <img src="{{asset($asset->thumbnail_img)}}" class="asset_thumnail redirect_to_page" data-redirect-url='{{route('user.assets.edit', $asset->id)}}'>
              <a href="{{route('user.users.edit', $asset->uploader->id)}}" class="user_thumbnail">
                @if ($asset->uploader->profileimage() == NULL)
                  <img src="http://via.placeholder.com/150x150" alt="" class="">
                @elseif ($asset->uploader->profileimage() != NULL)
                  <img src="{{$asset->uploader->profileimage()->path}}" alt="" class="">
                @endif

              </a>
              <a href="{{route('user.puzzles.show', $asset->id)}}" class="play_button">PLAY</a>
              <div class="bulk_action_checkbox_container">
                <span class="tick_symbol color_white">&#x2714;</span>
                <input type="checkbox" name="bulk_action_checkbox[]" class="bulk_action_checkbox" value="{{$asset->id}}">
              </div>

            </div> --}}

            <div class="card assets_item_container">
              <div class="bulk_action_checkbox_container">
                <span class="tick_symbol color_white">&#x2714;</span>
                <input type="checkbox" name="bulk_action_checkbox[]" class="bulk_action_checkbox" value="{{$asset->id}}">
              </div>
              <div class="blurring dimmable image">
                <div class="ui dimmer">
                  <div class="content">
                    <div class="center">
                      <a href="{{route('user.puzzles.show', $asset->id)}}" class="ui inverted button">Play</a>
                    </div>
                  </div>
                </div>
                <img src="{{asset($asset->thumbnail_img)}}" class="">
              </div>
              <div class="content">
                <a class="header ellipsis_content" href='{{route('user.assets.edit', $asset->id)}}' title="{{$asset->title}}">{{$asset->title}}</a>
                <div class="meta">
                  <span class="date">Create {{$asset->created_at->diffForHumans()}}</span>
                </div>
              </div>
              <div class="content redirect_to_page" data-redirect-url='{{route('user.users.edit', $asset->uploader->id)}}'>
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
        </div>

    {!! Form::close() !!}

      <h4 class="ui horizontal divider header">
        <i class="video play outline icon"></i>
        Public's Asset
      </h4>
      <div class="ui link special cards">
        @foreach ($public_assets as $asset)

          <div class="card assets_item_container">
            <div class="blurring dimmable image">
              <div class="ui dimmer">
                <div class="content">
                  <div class="center">
                    <a href="{{route('user.puzzles.show', $asset->id)}}" class="ui inverted button">Play</a>
                  </div>
                </div>
              </div>
              <img src="{{asset($asset->thumbnail_img)}}" class="">
            </div>
            <div class="content">
              <a class="header ellipsis_content" href='{{route('user.assets.edit', $asset->id)}}' title="{{$asset->title}}">{{$asset->title}}</a>
              <div class="meta">
                <span class="date">Create {{$asset->created_at->diffForHumans()}}</span>
              </div>
            </div>
            <div class="content redirect_to_page" data-redirect-url='{{route('user.users.edit', $asset->uploader->id)}}'>
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
      </div>

    </div>

  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
  $('.special.cards .image').dimmer({
    on: 'hover'
  });

  $('ui link special cards').visibility({
    once: false,
    // update size when new content loads
    observeChanges: true,
    // load content on bottom edge visible
    onBottomVisible: function() {
      // loads a max of 5 times
      window.loadFakeContent();
    }
  });
  </script>
@endsection
