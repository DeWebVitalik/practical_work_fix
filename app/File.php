<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class File extends Model
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_name', 'comment', 'date_remove'
    ];


    /**
     * Format created_at
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-y H:i');
    }

    /**
     * Format remove_date
     *
     * @return string
     */
    public function getRemoveDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-y H:i');
    }
}
