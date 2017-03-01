<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone'];

    public function estimates()
    {
        return $this->hasMany('App\Estimate');
    }
}
