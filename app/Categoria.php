<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // relacion 1 a muchos
    public function establecimientos(){
        return $this->hasMany(Establecimiento::class);
    }
}
