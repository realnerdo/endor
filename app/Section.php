<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['title', 'content'];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
