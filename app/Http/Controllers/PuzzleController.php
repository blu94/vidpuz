<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Asset;
use App\Puzzle;
use App\Tag;
use App\Taggable;
use Auth;
use DB;

class PuzzleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $asset = Asset::select(
          '*',
          DB::raw("(SELECT `path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset') AS thumbnail_img")
        )->findOrFail($id);
        if ($asset->usage == 'VIDEO') {

          // // find incomplete puzzle
          // $find_incomplete_puzzle = Puzzle::where('user_id', Auth::user()->id)
          // ->where('asset_id', $asset->id)
          // ->whereNull('duration')
          // ->get();
          //
          // // delete incomplete record
          // foreach ($find_incomplete_puzzle as $delete_target) {
          //   $delete_target->forcedelete();
          // }

          // get personal best record
          $personal_best_record_duration = "";
          $personal_best_record = Puzzle::whereNotNull('duration')
          // ->where('user_id', Auth::user()->id)
          ->where('asset_id', $asset->id)
          ->orderBy('duration', 'asc')
          ->limit(1)
          ->first();
          if ($personal_best_record != NULL) {
            $personal_best_record_duration = $personal_best_record->duration;
          }


          // $puzzle = Puzzle::create([
          //   'user_id' => Auth::user()->id,
          //   'asset_id' => $asset->id,
          // ]);

          return view('landing.puzzle.show', compact('asset', 'personal_best_record_duration'));
        }
        return redirect()->back();
    }

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
