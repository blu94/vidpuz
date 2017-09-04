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
        '*'
      )
      ->where('usage', 'VIDEO')
      ->whereDate('created_at', '<=', date('Y-m-d'))
      ->whereDate('created_at', '>=', date('Y-m-d', strtotime('-6 days')))
      ->where('is_public', 1)
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

      $play_again = Asset::select(
        'assets.*'
      )
      ->join('puzzles', 'assets.id', '=', 'puzzles.asset_id')
      ->where('assets.usage', 'VIDEO')
      ->where('puzzles.user_id', Auth::user()->id)
      ->groupBy('assets.id')
      ->paginate(10,['*'], 'most_popular_assets');

      return view('user.index', compact('assets_in_1_week', 'most_popular_assets', 'play_again'));
    }
}
