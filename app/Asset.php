<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
      'title',
      'path',
      'format',
      'usage',
      'is_public',
      'description',
      'user_id',
      'assetable_id',
      'assetable_type',
    ];

    public function assetable() {
      return $this->morphTo();
    }

    public function uploader () {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function video_thumnail()
    {
        return $this->hasMany('App\Asset', 'assetable_id')->where('assetable_type', 'LIKE', 'App%%Asset');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
