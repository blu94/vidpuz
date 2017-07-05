<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //
    protected $fillable = [
      'title',
      'path',
      'format',
      'usage',
      'is_public',
      'user_id',
      'assetable_id',
      'assetable_type',
    ];
}
