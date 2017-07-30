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

      $assets_in_1_week = Asset::select(
        '*',
        DB::raw("(SELECT `path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset') AS thumbnail_img")
      )
      ->where('usage', 'VIDEO')
      ->whereDate('created_at', '<=', date('Y-m-d'))
      ->whereDate('created_at', '>=', date('Y-m-d', strtotime('-6 days')))
      ->orderBy('created_at', 'desc')
      ->paginate(10,['*'], 'assets_in_1_week');

      $most_popular_assets = Asset::select(
        'assets.*',
        DB::raw("(SELECT thumbnail.`path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset' AND thumbnail.usage = 'VIDEO_THUMBNAIL') AS thumbnail_img"),
        DB::raw("COUNT(puzzles.id) AS NUMBER")
      )
      ->leftJoin('puzzles', 'assets.id', '=', 'puzzles.asset_id')
      ->where('assets.usage', 'VIDEO')
      ->havingRaw('COUNT(puzzles.id) > 0')
      ->groupBy('assets.id')
      ->orderBy('NUMBER', 'desc')
      ->paginate(10,['*'], 'most_popular_assets');

      return view('admin.index', compact('assets', 'assets_in_1_week', 'most_popular_assets'));
    }
}
