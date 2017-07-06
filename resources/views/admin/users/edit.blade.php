@extends('layouts.admin')

@section('page_title')
  USERS
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">{{$user->username}}</span>
  </div>
@endsection
