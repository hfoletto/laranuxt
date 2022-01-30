<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Education
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Education newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Education newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Education query()
 * @mixin \Eloquent
 * @property-read \App\Models\Profile|null $profile
 * @property int $id
 * @property int $profile_id
 * @property string $institution
 * @property string $major
 * @property string $degree
 * @property string $location
 * @property string|null $description
 * @property string $from
 * @property string|null $to
 * @property int $currently_attending
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereCurrentlyAttending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereInstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereUpdatedAt($value)
 */
class Education extends Model
{

    protected $table = 'educations';

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

}
