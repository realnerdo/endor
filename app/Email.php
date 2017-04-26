<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'to',
        'subject',
        'message',
        'opened_times',
        'opened_at'
    ];
    public function estimate()
    {
        return $this->belongsTo('App\Estimate');
    }
}
