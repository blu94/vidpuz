@extends('layouts.admin')

@section('page_title')
  USERS
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">USERS</span>
    <div class="all_user_wrapper">
      <a href="#" class="user_item_container">
        <div class="add_icon_container">
          <span class="add_icon bg_lightblue color_white">&#43;</span>
          <span class="font_size14">Add User</span>
        </div>
      </a>
    </div>
  </div>
@endsection
