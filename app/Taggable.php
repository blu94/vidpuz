<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    //
    protected $fillable = [
      'tag_id',
      'taggable_id',
      'taggable_type',
    ];

    public function tag () {
      return $this->belongsTo('App\Tag', 'tag_id');
    }
}
