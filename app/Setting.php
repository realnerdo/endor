<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Picture;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'company',
        'email',
        'phone',
        'address',
        'bank_details',
        'logo_id'
    ];

    /**
     * Get the logo of the Sidebar.
     */
    public function logo()
    {
        return $this->belongsTo('App\Picture', 'logo_id');
    }
}
