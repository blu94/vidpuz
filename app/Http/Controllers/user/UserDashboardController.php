<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use DB;
use Auth;

class UserDashboardController extends Controller
{
    //
    public function index () {

      $assets_in_1_week = Asset::select(
        '*',
        DB::raw("(SELECT `path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset') AS thumbnail_img")
      )
      ->where('usage', 'VIDEO')
      ->whereDate('created_at', '<=', date('Y-m-d'))
      ->whereDate('created_at', '>=', date('Y-m-d', strtotime('-6 days')))
      ->where('is_public', 1)
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

      $play_again = Asset::select(
        'assets.*',
        DB::raw("(SELECT thumbnail.`path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset' AND thumbnail.usage = 'VIDEO_THUMBNAIL') AS thumbnail_img")
      )
      ->join('puzzles', 'assets.id', '=', 'puzzles.asset_id')
      ->where('assets.usage', 'VIDEO')
      ->where('puzzles.user_id', Auth::user()->id)
      ->groupBy('assets.id')
      ->paginate(10,['*'], 'most_popular_assets');

      return view('user.index', compact('assets_in_1_week', 'most_popular_assets', 'play_again'));
    }
}
