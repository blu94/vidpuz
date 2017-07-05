<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flavy;
use App\Asset;
use Auth;

class AdminAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.assets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.assets.create');
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
        $file = $request->file('file');

        $name = time() . md5($file->getClientOriginalName()) . $file->getClientOriginalName();

        $path = '/assets/' . $name;

        $upload_status = $file->move('assets', $path);

        $extension = pathinfo($path, PATHINFO_EXTENSION);



        $asset = Asset::create([
          'title' => $name,
          'path' => $path,
          'format' => $extension,
          'usage' => 'VIDEO',
          'user_id' => Auth::user()->id
        ]);

        // create thumbnail
        $thumbnail_name =  md5($name).'_thumbnail.jpg';
        $thumbnail_path = '/assets/' . $thumbnail_name;
        Flavy::thumbnail(public_path() . $path, public_path() . $thumbnail_path, 1);
        $thumbnail_rec = Asset::create([
          'title' => $thumbnail_name,
          'path' => $thumbnail_path,
          'format' => 'jpg',
          'usage' => 'VIDEO_THUMBNAIL',
          'is_public' => 1,
          'user_id' => Auth::user()->id,
          'assetable_id' => $asset->id,
          'assetable_type' => 'App\Asset'
        ]);

        //
        // echo $asset->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
