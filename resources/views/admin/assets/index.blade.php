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
    <div class="page_operation_div">
      <a class="upload_assets_btn operation_btn btn btn-primary" href="{{route('admin.assets.create')}}">ADD NEW</a>
    </div>
    
  </div>
@endsection
