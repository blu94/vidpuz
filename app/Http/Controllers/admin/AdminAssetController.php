<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Flavy;
use App\Asset;
use App\Tag;
use App\Taggable;
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
        $asset = Asset::select(
          '*',
          DB::raw("(SELECT `path` AS thumbnail_img FROM `assets` AS thumbnail WHERE thumbnail.`assetable_id` = assets.id AND thumbnail.`assetable_type` LIKE 'App%%Asset') AS thumbnail_img")
        )
        ->where('assets.usage', 'VIDEO')
        ->where('assets.id', $id)
        ->get();

        $asset = $asset[0];


        // get tag value
        $taggable = Taggable::where('taggable_id', $asset->id)->where('taggable_type', 'LIKE', 'App%%Asset')->get();

        $tag_array = [];
        foreach ($taggable as $asset_tag) {
          array_push($tag_array, $asset_tag->tag->title);
        }
        $tag_value = implode(",", $tag_array);


        // get available tag
        $all_tag = Tag::select('title')->get();
        $all_tag_value = "['".implode("','", $tag_array)."']";

        if($asset->usage == 'VIDEO') {
          return view('admin.assets.edit', compact('asset', 'tag_value', 'all_tag_value'));
        }
        return redirect()->back();
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
        $asset_status = 0;
        if(!empty($request->is_public)) {
          $asset_status = 1;
        }
        else {
          $asset_status = 0;
        }

        if ($request->operation_btn == 'UPDATE') {
          $asset = Asset::findOrFail($id);
          $asset->update([
            'title' => $request->title,
            'is_public' => $asset_status,
            'description' => $request->description
          ]);


          // update tag
          Taggable::where('taggable_id', $asset->id)->where('taggable_type', 'LIKE', 'App%%Asset')->delete();

          $tag_array = explode(',', $request->tag);

          foreach ($tag_array as $tag) {
            $find_tag = Tag::where('title', $tag)->first();

            if(count($find_tag) == 0) {
              $insert_tag = Tag::create([
                'title' => $tag,
                'user_id' => Auth::user()->id,
                'is_active' => 1
              ]);

              $connect_tag = Taggable::create([
                'tag_id' => $insert_tag->id,
                'taggable_id' => $asset->id,
                'taggable_type' => 'App\Asset'
              ]);
            }
            else if(count($find_tag) > 0) {

              $connect_tag = Taggable::create([
                'tag_id' => $find_tag->id,
                'taggable_id' => $asset->id,
                'taggable_type' => 'App\Asset'
              ]);

            }
          }

          Session::flash('success_message', 'Asset update sucessfully.');
          return redirect()->back();
        }
        elseif ($request->operation_btn == 'DELETE') {
          # code...
        }


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
            <div class='col-md-12 col-sm-12 submit_btn_container'>
              <button type='button' name='button' class='btn submit_file_changes_btn pull-right' data-file-id='".$asset->id."' data-update-url='".route('admin.assets.update_asset')."'>SAVED</button>
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

    public function bulk_action(Request $request) {

      // delete asset
      if ($request->bulk_action_select == 'delete') {
        foreach ($request->bulk_action_checkbox as $key => $asset) {
          $target_asset = Asset::findOrFail($asset);
          $target_asset->delete();

        }
        Session::flash('success_message', 'Asset delete sucessfully.');
      }

      return redirect('admin/assets');
    }
}
