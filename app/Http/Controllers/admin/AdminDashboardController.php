<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use DB;

class AdminDashboardController extends Controller
{
    //
    public function index () {
      $assets = Asset::select(
        '*',
        DB::raw("(SELECT `path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset') AS thumbnail_img")
      )
      ->where('usage', 'VIDEO')
      ->orderBy('created_at', 'desc')
      ->get();
      return view('admin.index', compact('assets'));
    }
}
