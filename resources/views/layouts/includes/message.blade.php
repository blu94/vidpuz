@if (Session::has('success_message'))
  {{-- <div class="color_grey1 col-xs-12 message_div">{{ session('success_message') }}</div> --}}
  <div class="alert alert-success alert-dismissable message_div">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    {{-- <strong>Success!</strong> --}}
    {{ session('success_message') }}
  </div>
@endif

@if (Session::has('warning_message'))
  {{-- <div class="color_grey1 col-xs-12 message_div">{{ session('warning_message') }}</div> --}}
  <div class="alert alert-danger alert-dismissable message_div">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    {{-- <strong>Danger!</strong> --}}
    {{ session('warning_message') }}
  </div>
@endif
