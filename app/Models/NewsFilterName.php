<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\NewsFilterWords;

class NewsFilterName extends Model
{
    use HasFactory;

    function words()
    {
        return $this->hasMany(NewsFilterWords::class, 'filter_name_id');
    }
}
