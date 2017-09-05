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
    public function show($id, $shape = null, $piece = null)
    {
        //
        $search = Input::get('search');

        $search_options = Asset::where('usage', 'VIDEO')
        ->where('is_public', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        $shape = Input::get('shape');
        $piece = Input::get('pieces');

        $corner_css = "css/roundcorner.css";
        $x_number = 6;
        $y_number = 3;
        if ($shape){
          if ($shape == 1) {
            $corner_css = "css/sharpcorner.css";
          }
          elseif ($shape == 0) {
            $corner_css = "css/roundcorner.css";
          }
        }
        if ($piece) {
          if ($piece == '2x4') {
            $x_number = 4;
            $y_number = 2;
          }
          elseif ($piece == '3x6') {
            $x_number = 6;
            $y_number = 3;
          }
          elseif ($piece == '4x8') {
            $x_number = 8;
            $y_number = 4;
          }
          elseif ($piece == '5x10') {
            $x_number = 10;
            $y_number = 5;
          }
          elseif ($piece == '6x12') {
            $x_number = 12;
            $y_number = 6;
          }
          elseif ($piece == '7x14') {
            $x_number = 14;
            $y_number = 7;
          }
        }

        $asset = Asset::select(
          '*'
        )->where('assets.is_public', 1)->where('assets.id', $id)->first();

        if (count($asset) > 0) {
          if ($asset->usage == 'VIDEO') {

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

            return view('landing.puzzle.show', compact('asset', 'personal_best_record_duration', 'corner_css', 'x_number', 'y_number', 'shape', 'search_options'));
          }
        }
        else {
          return redirect('/');
        }

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
