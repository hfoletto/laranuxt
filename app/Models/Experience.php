<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Experience
 *
 * @property int $id
 * @property int $profile_id
 * @property string $title
 * @property string|null $company
 * @property string|null $location
 * @property string|null $description
 * @property string $from
 * @property string $to
 * @property int $currently_working
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Profile $profile
 * @method static \Illuminate\Database\Eloquent\Builder|Experience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Experience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Experience query()
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereCurrentlyWorking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Experience extends Model
{

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'from',
        'to'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

}
