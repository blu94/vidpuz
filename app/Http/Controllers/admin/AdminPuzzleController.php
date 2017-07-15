<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\Puzzle;
use Auth;

class AdminPuzzleController extends Controller
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
        $all_puzzle = Puzzle::whereNotNull('duration')->orderBy('duration', 'asc')->limit(1)->first();
        return $all_puzzle;
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
        $asset = Asset::findOrFail($id);
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

          return view('admin.puzzles.show', compact('asset', 'puzzle', 'personal_best_record_duration'));
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

    public function completepuzzle (Request $request) {
      $puzzle = Puzzle::findOrFail($request->puzzle_id);
      $puzzle->update([
        'duration' => $request->duration
      ]);
      return 'success';
    }
}
