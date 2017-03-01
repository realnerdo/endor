<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;

class Calendar extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['date_start', 'date_end'];

    public function estimate()
    {
    	return $this->belongsTo('App\Estimate');
    }
}
