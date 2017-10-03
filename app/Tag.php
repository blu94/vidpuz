<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = [
      'title',
      'user_id',
      'is_active',
    ];

    public function assets()
    {
        return $this->morphedByMany('App\Asset', 'taggable');
    }
}
