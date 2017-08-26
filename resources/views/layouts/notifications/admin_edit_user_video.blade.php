<a href="{{route('user.assets.edit', $notification->data['video']['id'])}}" class="notification_item @if ($notification->unread()) unread_notification_item @endif" class="color_darkgrey">
  <div class="notification_icon">
    <i class="circular inverted teal video play outline icon"></i>
  </div>
  {{-- <div class="notification_creator_img">
    @if ($notification->data['user']['role_id'] == 1)
      <img src="" alt="">
    @else
      Admin
    @endif
  </div> --}}
  <div class="notification_description">
    {{-- @if ($notification->data['user']['role_id'] == 1)
      <span class="avenirblack">{{$notification->data['creator']['username']}}</span>
    @else
      Admin
    @endif --}}
    Admin
    edit your video <span class="avenirblack">{{$notification->data['video']['title']}}</span>
  </div>
  <div class="notification_time">
    {{$notification->created_at->diffForHumans()}}
  </div>
</a>
