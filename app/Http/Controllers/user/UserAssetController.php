<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewVideoUpload;
use Illuminate\Support\Facades\Input;
use Flavy;
use App\Asset;
use App\Tag;
use App\Taggable;
use Auth;
use DB;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\User;

class UserAssetController extends Controller
{
    //
    public function index()
    {
        //
        $search = Input::get('search');

        $assets = Asset::select(
          '*'
        )
        ->where('usage', 'VIDEO')
        ->where(function($q) use($search) {
          $q->where('title', 'LIKE', '%'.$search.'%');
          $q->orWhere('description', 'LIKE', '%'.$search.'%');
        })
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $public_assets = Asset::select(
          '*'
        )
        ->where('usage', 'VIDEO')
        ->where('is_public', 1)
        ->where(function($q) use($search) {
          $q->where('title', 'LIKE', '%'.$search.'%');
          $q->orWhere('description', 'LIKE', '%'.$search.'%');
        })
        ->where('user_id', '!=', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $auth_user = Auth::user();
        $search_options = Asset::where('usage', 'VIDEO')
        ->where('user_id', Auth::user()->id)
        ->orWhere(function($q) use($auth_user) {
          $q->where('user_id', '!=', Auth::user()->id);
          $q->where('is_public', 1);
          $q->where('usage', 'VIDEO');
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('user.assets.index', compact('assets', 'public_assets', 'search_options'));
    }

    public function create()
    {
        //
        return view('user.assets.create');
    }

    public function edit($id)
    {
        //
        $search = Input::get('search');

        $auth_user = Auth::user();
        $search_options = Asset::where('usage', 'VIDEO')
        ->where('user_id', Auth::user()->id)
        ->orWhere(function($q) use($auth_user) {
          $q->where('user_id', '!=', Auth::user()->id);
          $q->where('is_public', 1);
          $q->where('usage', 'VIDEO');
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $asset = Asset::select(
          '*'
        )
        ->where('assets.usage', 'VIDEO')
        ->where('assets.id', $id)
        ->first();


        // get tag value
        $tag_array = [];
        foreach ($asset->tags as $key => $asset_tag) {
          array_push($tag_array, $asset_tag->title);
        }
        $tag_value = implode(",", $tag_array);


        // get available tag
        $all_tag = Tag::all();

        if($asset->usage == 'VIDEO') {
          return view('user.assets.edit', compact('asset', 'tag_value', 'all_tag', 'search_options'));
        }
        return redirect()->back();
    }

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


          Session::flash('success_message', 'Asset update sucessfully.');
          return redirect()->back();
        }
        elseif ($request->operation_btn == 'DELETE') {
          # code...
        }


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

      $ffmpeg = FFMpeg::create([
        'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
        'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
        'timeout'          => 3600, // the timeout for the underlying process
        'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
      ]);

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
      $thumbnail_name =  md5($request->video_name).'_thumbnail'.date('YmdHis').'.jpg';
      $thumbnail_path = '/assets/' . $thumbnail_name;
      Flavy::thumbnail(public_path() . '/' . $export_as, public_path() . $thumbnail_path, 1);
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


      $thumbnail_name =  md5($request->video_name).'_thumbnail'.date('YmdHis').'.gif';
      $thumbnail_path = '/assets/' . $thumbnail_name;
      $ffmpeg = FFMpeg::create([
        'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
        'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
        'timeout'          => 3600, // the timeout for the underlying process
        'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
      ]);
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

      return redirect('user/assets');
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

      return redirect('user/assets');
    }

    public function changeprofileimg(Request $request) {

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

    public function removeuploadedasset ($id) {
      $asset = Asset::findOrFail($id);
      $asset->delete();
      return 'success';
    }

    public function getDuration($full_video_path)
    {
      $ffprobe = FFProbe::create([
        'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
        'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
        'timeout'          => 3600, // the timeout for the underlying process
        'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
      ]);
      $duration = $ffprobe->format($full_video_path)->get('duration');
      return $duration;
    }
}
