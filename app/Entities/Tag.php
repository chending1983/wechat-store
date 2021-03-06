<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Tag extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'title', 'name', 'color', 'weight'
    ];

    public function wxapps()
    {
        return $this->belongsToMany('App\Entities\Wxapp', 'wxapp_tag', 'tag_id', 'wxapp_id');
    }

}
