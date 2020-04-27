<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * App\File
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $comment
 * @property string $date_remove
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Link[] $links
 * @property-read int|null $links_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDateRemove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\File withoutTrashed()
 */
class File extends Model
{
    use SoftDeletes;

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
        return Carbon::parse($value)->format('d M Y H:i');
    }

    /**
     * Format remove_date
     *
     * @return string
     */
    public function getDateRemoveAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d M Y H:i') : __('file.index.not_set');
    }

    /**
     * Get links
     */
    public function links()
    {
        return $this->hasMany('App\Link');
    }

    /**
     * Get one-time links
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function oneTimeLinks()
    {
        return $this->links()
            ->where('single_view', Link::SINGLE_VIEW)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Get general links
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function generalLinks()
    {
        return $this->links()
            ->where('single_view', Link::NOT_SINGLE_VIEW)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Get files
     *
     * @param int $userId
     * @return mixed
     */
    public function files(int $userId)
    {
        return $this->orderBy('created_at', 'DESC')
            ->where('user_id', $userId)
            ->paginate(10);
    }

}
