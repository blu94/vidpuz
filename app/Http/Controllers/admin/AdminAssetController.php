<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Notifications\AdminEditUserVideo;
use Flavy;
use App\Asset;
use App\Tag;
use App\Taggable;
use Auth;
use DB;
use App\User;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Contracts\Filesystem\Filesystem;

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
        )
        ->where('usage', 'VIDEO')
        ->orderBy('created_at', 'desc')
        ->get();
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
      set_time_limit(0);
      $file = public_path('/assets/150133910908c09f76939dc4cd5baed5b408060705Alien- Covenant - Prologue- The Crossing - 20th Century FOX.mp4');

      // $ffmpeg = FFMpeg::create();
      //
      // $video = $ffmpeg->open($file);
      //
      // $video->filters()->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds(0), \FFMpeg\Coordinate\TimeCode::fromSeconds(10));
      //
      // $video->save(new \FFMpeg\Format\Video\Ogg(), 'assets/export2.ogv');




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
          array_push($tag_array, $asset_tag->title);
        }
        $tag_value = implode(",", $tag_array);


        // get available tag
        $all_tag = Tag::all();

        if($asset->usage == 'VIDEO') {
          return view('admin.assets.edit', compact('asset', 'tag_value', 'all_tag'));
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

          if ($request->tag != NULL) {
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
          }


          // add notification
          $all_users = User::where('id', '!=', Auth::user()->id)->get();
          foreach ($all_users as $user) {
            $user->notify(new AdminEditUserVideo($asset, $asset->user_id));
          }

          Session::flash('success_message', 'Asset update sucessfully.');
          return redirect()->back();
        }
        elseif ($request->operation_btn == 'DELETE') {
          $video = Asset::findOrFail($id);

          if (file_exists(public_path() . '/' . $video->path) == 1) {
            unlink(public_path() . '/' . $video->path);
          }

          $video->delete();
          return redirect('admin/assets');
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

        $format = "mp4";
        if (strtolower($extension) == 'ogv') {
          $format = 'ogg';
        }
        elseif (strtolower($extension) == 'mp4') {
          $format = "mp4";
        }

        $video_duration = intval($this->getDuration(public_path($path)));

        $tensec_width = 20;
        if ($video_duration > 20) {
          $tensec_width = (20 / $video_duration) * 100;
          if ($tensec_width < 1) {
            $tensec_width = 2;
          }
        }
        elseif ($video_duration < 20) {
          $tensec_width = 100;
        }

        return json_encode(array('name'=>$name, 'url'=>$path, 'format'=>$format, 'tensecwidth'=>$tensec_width, 'videolength'=>$video_duration));

    }

    public function save_asset(Request $request)
    {
      // return $request->all();
      set_time_limit(0);
      $file = public_path($request->url);

      $ffmpeg = FFMpeg::create();

      $video = $ffmpeg->open($file);

      $video->filters()->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($request->starttime), \FFMpeg\Coordinate\TimeCode::fromSeconds(20));

      $export_as = 'assets/export'.md5($request->url).date('YmdHis').'.ogv';
      $video->save(new \FFMpeg\Format\Video\Ogg(), $export_as);

      if ($request->video_name == '') {
        $request->video_name = str_replace("assets/export","",$export_as);
        $request->video_name = str_replace(".ogv","",$request->video_name);
      }
      $asset = Asset::create([
        'title' => $request->video_name,
        'path' => $export_as,
        'format' => 'ogg',
        'usage' => 'VIDEO',
        'user_id' => Auth::user()->id
      ]);

      // create thumbnail
      // $thumbnail_name =  md5($request->video_name).'_thumbnail'.date('YmdHis').'.jpg';
      // $thumbnail_path = '/assets/' . $thumbnail_name;
      // Flavy::thumbnail(public_path() . '/' . $export_as, public_path() . $thumbnail_path, 1);
      // $thumbnail_rec = Asset::create([
      //   'title' => $thumbnail_name,
      //   'path' => $thumbnail_path,
      //   'format' => 'jpg',
      //   'usage' => 'VIDEO_THUMBNAIL',
      //   'is_public' => 1,
      //   'user_id' => Auth::user()->id,
      //   'assetable_id' => $asset->id,
      //   'assetable_type' => 'App\Asset'
      // ]);


      $thumbnail_name =  md5($request->video_name).'_thumbnail'.date('YmdHis').'.gif';
      $thumbnail_path = '/assets/' . $thumbnail_name;
      $ffmpeg = FFMpeg::create();
      $video = $ffmpeg->open(public_path() . '/' . $export_as);
      $video
      ->gif(\FFMpeg\Coordinate\TimeCode::fromSeconds(0), new \FFMpeg\Coordinate\Dimension(1080, 720), 10)
      ->save(public_path() . $thumbnail_path);
      $thumbnail_rec = Asset::create([
        'title' => $thumbnail_name,
        'path' => $thumbnail_path,
        'format' => 'gif',
        'usage' => 'VIDEO_THUMBNAIL',
        'is_public' => 1,
        'user_id' => Auth::user()->id,
        'assetable_id' => $asset->id,
        'assetable_type' => 'App\Asset'
      ]);

      unlink($file);

      return redirect('admin/assets');
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

    public function bulk_action(Request $request)
    {

      // delete asset
      if ($request->bulk_action_select == 'delete') {
        foreach ($request->bulk_action_checkbox as $key => $asset) {
          $target_asset = Asset::findOrFail($asset);
          $target_asset_thumbnail = Asset::where('assetable_id', $target_asset->id)->where('assetable_type', 'LIKE', 'App%%Asset')->first();

          if (file_exists(public_path() . '/' . $target_asset->path)) {
            // delete video
            unlink(public_path() . '/' . $target_asset->path);
            // delete thumbnail
            unlink(public_path() . '/' . $target_asset_thumbnail->path);
          }


          $target_asset->delete();

        }
        Session::flash('success_message', 'Asset delete sucessfully.');
      }
      elseif($request->bulk_action_select == 'public') {
        foreach ($request->bulk_action_checkbox as $key => $asset) {
          $target_asset = Asset::findOrFail($asset);
          $target_asset->update(['is_public'=>1]);

        }
        Session::flash('success_message', 'Asset publish sucessfully.');
      }
      elseif($request->bulk_action_select == 'private') {
        foreach ($request->bulk_action_checkbox as $key => $asset) {
          $target_asset = Asset::findOrFail($asset);
          $target_asset->update(['is_public'=>0]);

        }
        Session::flash('success_message', 'Asset private sucessfully.');
      }

      return redirect('admin/assets');
    }

    public function changeprofileimg(Request $request)
    {

      $profile_img = Asset::where('assetable_id', $request->user_id)
      ->where('assetable_type', 'LIKE', 'App%%User')
      ->where('usage', 'PROFILE');

      $profile_img->delete();

      $file = $request->file('file');

      $usage = $request->usage;

      $name = time() . md5($file->getClientOriginalName()) . $file->getClientOriginalName();

      $path = '/assets/' . $name;

      $upload_status = $file->move('assets', $path);

      $extension = pathinfo($path, PATHINFO_EXTENSION);

      $asset = Asset::create([
        'title' => $name,
        'path' => $path,
        'format' => $extension,
        'usage' => $usage,
        'user_id' => $request->user_id,
        'assetable_id' => $request->user_id,
        'assetable_type' => 'App\User'
      ]);

      echo $path;
    }

    public function removeuploadedasset ($id)
    {
      $asset = Asset::findOrFail($id);
      $asset->delete();
      return 'success';
    }

    public function getDuration($full_video_path)
    {
      $ffprobe = FFProbe::create();
      $duration = $ffprobe->format($full_video_path)->get('duration');
      return $duration;
    }
}
