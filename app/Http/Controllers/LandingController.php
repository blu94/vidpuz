<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Asset;
use App\Puzzle;
use App\Tag;
use App\Taggable;
use Auth;
use DB;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $search = Input::get('search');

        $search_options = Asset::where('usage', 'VIDEO')
        ->where('is_public', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        $assets = Asset::select(
          'assets.*',
          DB::raw("(SELECT COUNT(puzzles.id) FROM puzzles WHERE puzzles.asset_id = assets.id) as number")
        )
        ->where('assets.usage', 'VIDEO')
        ->where('is_public', 1)
        ->orderBy('number', 'DESC')
        ->get();

        $current_month = date('m');
        $assets_current_month = Asset::select(
          'assets.*'
        )
        // ->whereMonth('created_at', $current_month)
        ->where('usage', 'VIDEO')
        ->where('is_public', 1)
        ->orderBy('created_at', 'DESC')
        ->take(30)
        ->get();

        $get_id_arr = array();
        foreach ($assets_current_month as $video) {
          array_push($get_id_arr, $video->id);
        }

        $assets_current_month = Asset::whereIn('id', $get_id_arr)
        ->orderBy('created_at', 'DESC')
        ->paginate(10);

        return view('welcome', compact('assets', 'assets_current_month', 'search_options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
