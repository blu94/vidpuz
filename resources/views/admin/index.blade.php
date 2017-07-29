@extends('layouts.admin')

@section('page_title')
  DASHBOARD
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">DASHBOARD</span>
    <div class="chart_wrapper col-md-6 col-sm-12">
      <h4 class="ui horizontal divider header">
        <i class="bar chart icon"></i>
        Upload rate for last 6 months
      </h4>
      <canvas id="last6Mthsuploadrate" height='150px'></canvas>
    </div>
    <div class="chart_wrapper col-md-6 col-sm-12">
      <h4 class="ui horizontal divider header">
        <i class="bar chart icon"></i>
        Upload rate for last 7 days
      </h4>
      <canvas id="lastWeeksuploadrate" height='150px'></canvas>
    </div>

    <div class="assets_container">
      <h4 class="ui horizontal divider header">
        <i class="video play outline icon"></i>
        New Video
      </h4>
      <div class="ui link special cards">
        @if (count($assets) > 0)
          @foreach ($assets as $asset)
            @if (date('Y-m-d', strtotime('-6 days')) == date('Y-m-d', strtotime($asset->created_at)) || date('Y-m-d', strtotime('-5 days')) == date('Y-m-d', strtotime($asset->created_at)) || date('Y-m-d', strtotime('-4 days')) == date('Y-m-d', strtotime($asset->created_at)) || date('Y-m-d', strtotime('-3 days')) == date('Y-m-d', strtotime($asset->created_at)) || date('Y-m-d', strtotime('-2 days')) == date('Y-m-d', strtotime($asset->created_at)) || date('Y-m-d', strtotime('-1 days')) == date('Y-m-d', strtotime($asset->created_at)) || date('Y-m-d') == date('Y-m-d', strtotime($asset->created_at)))
              <div class="card assets_item_container">
                <div class="blurring dimmable image">
                  <div class="ui dimmer">
                    <div class="content">
                      <div class="center">
                        <a href="{{route('admin.puzzles.show', $asset->id)}}" class="ui inverted button">Play</a>
                      </div>
                    </div>
                  </div>
                  <img src="{{asset($asset->thumbnail_img)}}" class="">
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
            @endif

          @endforeach
        @elseif (count($assets) == 0)
          <p class="description text-center padd_20 col-md-12 col-sm-12">
            No asset yet.
          </p>
        @endif

        {{-- <div class="pagination_container">
          @include('pagination.default', ['paginator' => $assets])
        </div> --}}
      </div>

    </div>
  </div>


@endsection

@section('scripts')
  @php
    // count upload rate
    $last_5m = $last_4m = $last_3m = $last_2m = $last_m = $current_m = 0;
    $last_6d = $last_5d = $last_4d = $last_3d = $last_2d = $last_d = $current_d = 0;
    foreach ($assets as $asset) {
      // count upload rate by months
      if (date('Y-m', strtotime(' -5 months')) == date('Y-m', strtotime($asset->created_at))) {
        $last_5m += 1;
      }
      elseif (date('Y-m', strtotime(' -4 months')) == date('Y-m', strtotime($asset->created_at))) {
        $last_4m += 1;
      }
      elseif (date('Y-m', strtotime(' -3 months')) == date('Y-m', strtotime($asset->created_at))) {
        $last_3m += 1;
      }
      elseif (date('Y-m', strtotime(' -2 months')) == date('Y-m', strtotime($asset->created_at))) {
        $last_2m += 1;
      }
      elseif (date('Y-m', strtotime(' -1 months')) == date('Y-m', strtotime($asset->created_at))) {
        $last_m += 1;
      }
      elseif (date('Y-m') == date('Y-m', strtotime($asset->created_at))) {
        $current_m += 1;
      }

      // count upload rate by days
      if (date('Y-m-d', strtotime(' -6 days')) == date('Y-m-d', strtotime($asset->created_at))) {
        $last_6d += 1;
      }
      elseif (date('Y-m-d', strtotime(' -5 days')) == date('Y-m-d', strtotime($asset->created_at))) {
        $last_5d += 1;
      }
      elseif (date('Y-m-d', strtotime(' -4 days')) == date('Y-m-d', strtotime($asset->created_at))) {
        $last_4d += 1;
      }
      elseif (date('Y-m-d', strtotime(' -3 days')) == date('Y-m-d', strtotime($asset->created_at))) {
        $last_3d += 1;
      }
      elseif (date('Y-m-d', strtotime(' -2 days')) == date('Y-m-d', strtotime($asset->created_at))) {
        $last_2d += 1;
      }
      elseif (date('Y-m-d', strtotime(' -1 days')) == date('Y-m-d', strtotime($asset->created_at))) {
        $last_d += 1;
      }
      elseif (date('Y-m-d') == date('Y-m-d', strtotime($asset->created_at))) {
        $current_d += 1;
      }
    }
  @endphp
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js" charset="utf-8"></script>
  <script type="text/javascript">

  $('.special.cards .image').dimmer({
    on: 'hover'
  });

  var last6Mthsuploadrate = document.getElementById("last6Mthsuploadrate");
  var lineChart = new Chart(last6Mthsuploadrate, {
  type: 'line',
  data: {
    labels: ["{{date('F', strtotime(' -5 months'))}}", "{{date('F', strtotime(' -4 months'))}}", "{{date('F', strtotime(' -3 months'))}}", "{{date('F', strtotime(' -2 months'))}}", "{{date('F', strtotime(' -1 months'))}}", '{{date('F')}}'],
    datasets: [{
      label: 'Upload Rate',
      data: [{{$last_5m}}, {{$last_4m}}, {{$last_3m}}, {{$last_2m}}, {{$last_m}}, {{$current_m}}],
      backgroundColor: [
        'rgba(54, 162, 235, 0.6)'
      ]
    }]
  }
  });

  var lastWeeksuploadrate = document.getElementById("lastWeeksuploadrate");
  var lineChart = new Chart(lastWeeksuploadrate, {
    type: 'line',
    data: {
      labels: ["{{date('F j,Y', strtotime(' -6 days'))}}", "{{date('F j,Y', strtotime(' -5 days'))}}", "{{date('F j,Y', strtotime(' -4 days'))}}", "{{date('F j,Y', strtotime(' -3 days'))}}", "{{date('F j,Y', strtotime(' -2 days'))}}", "{{date('F j,Y', strtotime(' -1 days'))}}", "{{date('F j,Y')}}"],
      datasets: [{
        label: 'Upload Rate',
        data: [{{$last_6d}}, {{$last_5d}}, {{$last_4d}}, {{$last_3d}}, {{$last_2d}}, {{$last_d}}, {{$current_d}}],
        backgroundColor: [
          'rgba(255, 99, 132, 0.6)'
          // 'rgba(54, 162, 235, 0.6)',
          // 'rgba(255, 206, 86, 0.6)',
          // 'rgba(75, 192, 192, 0.6)',
          // 'rgba(153, 102, 255, 0.6)',
          // 'rgba(255, 159, 64, 0.6)',
          // 'rgba(255, 99, 132, 0.6)',
          // 'rgba(54, 162, 235, 0.6)',
          // 'rgba(255, 206, 86, 0.6)',
          // 'rgba(75, 192, 192, 0.6)',
          // 'rgba(153, 102, 255, 0.6)'
        ]
      }]
    }
  });
  </script>
@endsection
