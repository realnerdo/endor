<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;
use App\User;

class Picture extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['original_name', 'url'];

    /**
     * Get the setting of the logo.
     */
    public function logo_setting()
    {
        return $this->hasOne('App\Setting', 'logo_id', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
