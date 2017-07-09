@extends('layouts.admin')

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
        @foreach ($assets as $asset)
          <div class="assets_item_container">
            <img src="{{asset($asset->thumbnail_img)}}" class="asset_thumnail redirect_to_page" data-redirect-url='{{route('admin.assets.edit', $asset->id)}}'>
            <a href="{{route('admin.users.edit', $asset->uploader->id)}}" class="user_thumbnail">
              @if ($asset->uploader->profileimage() == NULL)
                <img src="http://via.placeholder.com/150x150" alt="" class="">
              @elseif ($asset->uploader->profileimage() != NULL)
                <img src="{{$asset->uploader->profileimage()->path}}" alt="" class="">
              @endif

            </a>
            <a href="#" class="play_button">PLAY</a>
            <div class="bulk_action_checkbox_container">
              <span class="tick_symbol color_white">&#x2714;</span>
              <input type="checkbox" name="bulk_action_checkbox[]" class="bulk_action_checkbox" value="{{$asset->id}}">
            </div>

          </div>
        @endforeach
      </div>
    {!! Form::close() !!}

  </div>
@endsection

@section('scripts')
@endsection
