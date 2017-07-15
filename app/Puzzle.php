<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Puzzle extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    //
    protected $fillable = [
      'user_id',
      'start_at',
      'duration',
      'asset_id',
      'play_time',
    ];
}
