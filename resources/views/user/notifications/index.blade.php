@extends('layouts.user')

@section('page_title')
  USERS
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">Notifications</span>
    <div class="notifications_wrapper font_size12">
      @if (count(Auth::user()->notifications) > 0)
        @php
          $display_tday = $display_earlier = "";
        @endphp
        @foreach (Auth::user()->notifications as $notification)
          @if (date('Y-m-d') == date('Y-m-d', strtotime($notification->created_at)) && $display_tday == '')
            @php
              $display_tday = "Today";
            @endphp
            <h2 class="ui horizontal divider">
              {{$display_tday}}
            </h2>
          @endif

          @if (date('Y-m-d', strtotime(' -1 day ')) == date('Y-m-d', strtotime($notification->created_at)) && $display_tday == '')
            @php
              $display_earlier = "Earlier";
            @endphp
            <h2 class="ui horizontal divider">
              {{$display_earlier}}
            </h2>
          @endif
          @include('layouts.notifications.'.snake_case(class_basename($notification->type)))
        @endforeach
      @elseif (count(Auth::user()->notifications) == 0)
        <span class="color_white">No notification...</span>
      @endif

    </div>
  </div>
@endsection
