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

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $assets = Asset::select(
          'assets.*'
        )
        ->where('assets.usage', 'VIDEO')
        ->where('is_public', 1)
        ->orderBy('created_at', 'DESC')
        ->paginate(20);

        return view('landing.video.index', compact('assets'));
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
        $asset = Asset::findOrFail($id);

        // get tag value
        $taggable = Taggable::where('taggable_id', $asset->id)->where('taggable_type', 'LIKE', 'App%%Asset')->get();

        $tag_array = [];
        foreach ($taggable as $asset_tag) {
          array_push($tag_array, $asset_tag->tag->title);
        }
        $tag_value = implode(",", $tag_array);

        // get available tag
        $all_tag = Tag::all();
        $all_tag_array = [];
        foreach ($all_tag as $tag) {
          array_push($all_tag_array, $tag->title);
        }
        $all_tag_value = "['".implode("','", $all_tag_array)."']";

        return view('landing.video.show', compact('asset', 'tag_value', 'all_tag_value'));
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
