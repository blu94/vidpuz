<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flavy;
use App\Asset;
use Auth;
use DB;

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
        $assets = Asset::select(
          '*',
          DB::raw("(SELECT `path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset') AS thumbnail_img")
        )->where('usage', 'VIDEO')->get();
        return view('admin.assets.index', compact('assets'));
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

    public function store_asset(Request $request)
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
        echo "<div class='uploaded_file_container' id='file_item".$asset->id."' data-file-id='".$asset->id."'>
          <div class='uploaded_file_thumbnail'>
            <img src='".asset($thumbnail_path)."' class='uploaded_file_thumbnail' title=''/>
            <button class='delete_asset btn btn-danger' data-file-id='".$asset->id."'>REMOVE</button>
          </div>
          <div class='uploaded_file_detail_container'>
            <input type='text' name='' class='uploaded_file_title col-md-9 col-sm-9' value='".$name."' data-file-id='".$asset->id."'/>

            <div class='switch_status col-md-3 col-sm-3'>
              <span class='switch_title' data-file-id='".$asset->id."'>
                Public
              </span>
              <label class='switch'>
                <input type='checkbox' class='switch_checkbox' data-file-id='".$asset->id."' checked>
                <div class='slider round'></div>
              </label>
            </div>
            <textarea name='name' rows='8' cols='80' class='uploaded_file_description col-md-12 col-sm-12' data-file-id='".$asset->id."'></textarea>
            <input type='text' name='' class='uploaded_file_tag col-md-9 col-sm-9' value='' data-file-id='".$asset->id."'>
            <div class='col-md-3 col-sm-3 submit_btn_container'>
              <button type='button' name='button' class='btn submit_file_changes_btn' data-file-id='".$asset->id."' data-update-url='".route('admin.assets.update_asset')."'>SAVED</button>
            </div>
          </div>

        </div>";

    }

    public function update_asset(Request $request)
    {
      $asset = Asset::findOrFail($request->file_id);
      $asset->update([
        'title' => $request->title,
        'is_public' => $request->is_public,
        'description' => $request->description
      ]);
      return $request->file_id;
    }
}
