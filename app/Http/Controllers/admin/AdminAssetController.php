<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Asset;
use Auth;

use Carbon;
use Thumbnail;

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



        if($upload_status) {

          $thumbnail_path   = '/assets';

          $video_path       = $path;

          // set thumbnail image name
          $thumbnail_image  = time() . $name.".jpg";

          // get video length and process it
          // assign the value to time_to_image (which will get screenshot of video at that specified seconds)
          $time_to_image    = floor(($data['video_length'])/2);


          $thumbnail_status = Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image,$time_to_image);
          if($thumbnail_status)
          {
            echo "Thumbnail generated";
          }
          else
          {
            echo "thumbnail generation has failed";
          }
        }

        $asset = Asset::create([
          'title' => $name,
          'path' => $path,
          'format' => $extension,
          'user_id' => Auth::user()->id
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
        //
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
