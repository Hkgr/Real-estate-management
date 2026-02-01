<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
      protected $fillable = [
        'signal_id',
        'signal_year',
        'type',
        'signal_owner',
        'signal_source',
        'signal_victim',
    ];

}
