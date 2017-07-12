<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    //
    protected $fillable = [
      'user_id',
      'start_at',
      'duration',
      'asset_id',
      'play_time',  
    ];
}
