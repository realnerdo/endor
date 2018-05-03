<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Client;
use App\User;
use App\EstimateService;
use App\Calendar;

class Estimate extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'folio',
        'service',
        'status',
        'payment_type',
        'description',
        'total',
        'discount',
        'client_id',
        'user_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function estimate_services()
    {
        return $this->hasMany('App\EstimateService');
    }

    public function calendar()
    {
        return $this->hasOne('App\Calendar');
    }

    public function emails()
    {
        return $this->hasMany('App\Email');
    }
}
