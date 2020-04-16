<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public const SINGLE_VIEW = 1;
    public const NOT_SINGLE_VIEW = 0;
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
        'user_id', 'file_id', 'alias', 'token', 'single_view', 'views'
    ];

    /**
     * Format created_at
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute(int $value)
    {
        return Carbon::parse($value)->format('d-m-y H:i');
    }

    /**
     * Replacing the alias value on URL
     *
     * @param $value
     * @return string
     */
    public function getAliasAttribute($value)
    {
        return route('viewFile', $value);
    }

    /**
     * Get the file
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }

}
