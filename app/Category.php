<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function cate()
    {
        return $this->hasMany('App\Category','parent_id');
    }
}
