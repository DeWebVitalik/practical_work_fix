<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserFiles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_name', 'comment', 'date_remove'
    ];

    /**
     * Set user_id
     */
    public function setUserIdAttribute()
    {
        $this->attributes['user_id'] = Auth::id();
    }

}
