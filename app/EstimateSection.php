<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateSection extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['title', 'content'];

    public function estimate_service()
    {
        return $this->belongsTo('App\EstimateService');
    }
}
