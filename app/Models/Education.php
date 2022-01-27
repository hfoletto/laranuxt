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
 */
class Education extends Model
{

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

}
