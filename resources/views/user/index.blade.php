@extends('layouts.user')

@section('page_title')
  DASHBOARD
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">DASHBOARD</span>

    <div class="assets_container">
      <h4 class="ui horizontal divider header">
        <i class="video play outline icon"></i>
        New Video
      </h4>
      <div class="ui link special cards">
        @if (count($assets_in_1_week) > 0)
          @foreach ($assets_in_1_week as $asset)
            @php
              $unique_id = bcrypt($asset->id);
            @endphp
            <div class="card assets_item_container" data-asset-id='{{$unique_id}}'>
              <div class="blurring dimmable image">
                <div class="ui dimmer">
                  <div class="content">
                    <div class="center">
                      <a href="{{route('user.puzzles.show', $asset->id)}}" class="ui inverted purple button">Play</a>
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
        @elseif (count($assets_in_1_week) == 0)
          <p class="description text-center padd_20 col-md-12 col-sm-12">
            No asset yet.
          </p>
        @endif

        <div class="pagination_container">
          {{-- {{$assets_current_month->links()}} --}}
          @include('pagination.default', ['paginator' => $assets_in_1_week])
        </div>
      </div>

      <br>

      <h4 class="ui horizontal divider header">
        <i class="video play outline icon"></i>
        Most Popular Video
      </h4>
      <div class="ui link special cards">
        @if (count($most_popular_assets) > 0)
          @foreach ($most_popular_assets as $asset)
            @php
              $unique_id = bcrypt($asset->id);
            @endphp
            <div class="card assets_item_container" data-asset-id='{{$unique_id}}'>
              <div class="blurring dimmable image">
                <div class="ui dimmer">
                  <div class="content">
                    <div class="center">
                      <a href="{{route('user.puzzles.show', $asset->id)}}" class="ui inverted purple button">Play</a>
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
        @elseif (count($most_popular_assets) == 0)
          <p class="description text-center padd_20 col-md-12 col-sm-12">
            No asset yet.
          </p>
        @endif

        <div class="pagination_container">
          {{-- {{$assets_current_month->links()}} --}}
          @include('pagination.default', ['paginator' => $most_popular_assets])
        </div>
      </div>

      <br>

      <h4 class="ui horizontal divider header">
        <i class="video play outline icon"></i>
        Play Again
      </h4>
      <div class="ui link special cards">
        @if (count($play_again) > 0)
          @foreach ($play_again as $asset)
            @php
              $unique_id = bcrypt($asset->id);
            @endphp
            <div class="card assets_item_container" data-asset-id='{{$unique_id}}'>
              <div class="blurring dimmable image">
                <div class="ui dimmer">
                  <div class="content">
                    <div class="center">
                      <a href="{{route('user.puzzles.show', $asset->id)}}" class="ui inverted purple button">Play</a>
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
        @elseif (count($play_again) == 0)
          <p class="description text-center padd_20 col-md-12 col-sm-12">
            No asset yet.
          </p>
        @endif

        <div class="pagination_container">
          {{-- {{$assets_current_month->links()}} --}}
          @include('pagination.default', ['paginator' => $play_again])
        </div>
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
