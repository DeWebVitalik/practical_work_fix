<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Link
 *
 * @property int $id
 * @property int $user_id
 * @property int $file_id
 * @property string $alias
 * @property string|null $token
 * @property int|null $single_view
 * @property int|null $views
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\File $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereSingleView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereViews($value)
 */
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
        return Carbon::parse($value)->format('d M Y H:i');
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

    /**
     * Get links
     */
    public function links()
    {
        return $this->orderBy('created_at', 'DESC')
            ->where('user_id', auth()->id())
            ->with('file')
            ->paginate(10);
    }

}
