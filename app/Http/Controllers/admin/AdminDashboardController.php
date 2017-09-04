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
        '*'
      )
      ->where('usage', 'VIDEO')
      ->orderBy('created_at', 'desc')
      ->get();

      $assets_in_1_week = Asset::select(
        '*'
      )
      ->where('usage', 'VIDEO')
      ->whereDate('created_at', '<=', date('Y-m-d'))
      ->whereDate('created_at', '>=', date('Y-m-d', strtotime('-6 days')))
      ->orderBy('created_at', 'desc')
      ->paginate(10,['*'], 'assets_in_1_week');

      $most_popular_assets = Asset::select(
        'assets.*',
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
