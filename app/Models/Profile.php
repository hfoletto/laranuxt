<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Experience[] $experience
 * @property-read int|null $experience_count
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Education[] $education
 * @property-read int|null $education_count
 * @property string|null $phone_number
 * @property string|null $introduction
 * @property string|null $github_url
 * @property string|null $linkedin_url
 * @property string|null $twitter_url
 * @property string|null $website_url
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereGithubUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereLinkedinUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereTwitterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereWebsiteUrl($value)
 * @property string $job_title
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereJobTitle($value)
 */
class Profile extends Model
{

    protected $fillable = [
        'first_name', 'last_name', 'job_title', 'email',
        'phone_number', 'location', 'introduction', 'photo_path',
        'github_url', 'linkedin_url', 'twitter_url', 'website_url'
    ];

    public function getPhotoAttribute()
    {
        return $this->photo_path
            ? asset('storage/'.str_replace('public/', '', $this->photo_path))
            : null;
    }

    protected $appends = ['photo'];

    protected $hidden = ['photo_path'];

    public function experience()
    {
        return $this->hasMany(Experience::class)->orderBy('from', 'desc');
    }

    public function education()
    {
        return $this->hasMany(Education::class)->orderBy('from', 'desc');
    }
}
