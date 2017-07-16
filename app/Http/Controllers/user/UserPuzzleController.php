<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\Puzzle;
use Auth;
use DB;

class UserPuzzleController extends Controller
{
    //
    public function show($id)
    {
        //
        $asset = Asset::select(
          '*',
          DB::raw("(SELECT `path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset') AS thumbnail_img")
        )->findOrFail($id);
        if ($asset->usage == 'VIDEO') {

          // find incomplete puzzle
          $find_incomplete_puzzle = Puzzle::where('user_id', Auth::user()->id)
          ->where('asset_id', $asset->id)
          ->whereNull('duration')
          ->get();

          // delete incomplete record
          foreach ($find_incomplete_puzzle as $delete_target) {
            $delete_target->forcedelete();
          }

          // get personal best record
          $personal_best_record_duration = "";
          $personal_best_record = Puzzle::whereNotNull('duration')
          ->where('user_id', Auth::user()->id)
          ->where('asset_id', $asset->id)
          ->orderBy('duration', 'asc')
          ->limit(1)
          ->first();
          if ($personal_best_record != NULL) {
            $personal_best_record_duration = $personal_best_record->duration;
          }


          $puzzle = Puzzle::create([
            'user_id' => Auth::user()->id,
            'asset_id' => $asset->id,
          ]);

          return view('user.puzzles.show', compact('asset', 'puzzle', 'personal_best_record_duration'));
        }
        return redirect()->back();
    }

    public function completepuzzle (Request $request) {
      $puzzle = Puzzle::findOrFail($request->puzzle_id);
      $puzzle->update([
        'duration' => $request->duration
      ]);
      return 'success';
    }
}
