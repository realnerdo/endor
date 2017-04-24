<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;

class EstimateService extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['title', 'notes', 'price', 'duration', 'offset'];

    public function estimate()
    {
        return $this->belongsTo('App\Estimate');
    }

    public function estimate_sections()
    {
        return $this->hasMany('App\EstimateSection');
    }
}
