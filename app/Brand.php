<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function prodcuts()
    {
        return $this->hasMany('App\Prodcut', 'brand_id','id');
    }
}
