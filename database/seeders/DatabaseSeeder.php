<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Henrique Foletto',
            'email' => 'devmail@domain.com',
            'password' => bcrypt('password'),
        ]);

        $profile = new Profile();
        $profile->first_name = 'Henrique';
        $profile->last_name = 'Foletto';
        $profile->job_title = 'Fullstack Developer';
        $profile->email = 'devmail@domain.com';
        $profile->phone_number = '+1 23 456 789';
        $profile->location = 'Brazil';
        $profile->introduction = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi non consequat augue, quis venenatis enim. Phasellus dapibus, libero in vehicula bibendum, ante augue sodales dolor, sed fermentum est velit eu odio. Maecenas consectetur facilisis odio, nec bibendum ante. Proin quis dui sit amet lacus finibus aliquam sit amet a ex. Integer at quam consectetur, tincidunt elit a, feugiat velit. Nulla nisl diam, ullamcorper eu orci ac, fringilla sodales felis. Nunc sed velit leo.';
        $profile->github_url = 'https://github.com/hfoletto';
        $profile->save();

        $skill_1 = new Skill();
        $skill_1->name = 'HTML and CSS';
        $skill_1->years_of_experience = 10;
        $profile->skills()->save($skill_1);

        $skill_2 = new Skill();
        $skill_2->name = 'JavaScript';
        $skill_2->years_of_experience = 9;
        $profile->skills()->save($skill_2);

        $skill_3 = new Skill();
        $skill_3->name = 'PHP';
        $skill_3->years_of_experience = 8;
        $profile->skills()->save($skill_3);

        $skill_4 = new Skill();
        $skill_4->name = 'Vue.js';
        $skill_4->years_of_experience = 4;
        $profile->skills()->save($skill_4);

        $skill_5 = new Skill();
        $skill_5->name = 'Laravel';
        $skill_5->years_of_experience = 3;
        $profile->skills()->save($skill_5);

        $experience_1 = new Experience();
        $experience_1->title = 'Fullstack Developer';
        $experience_1->company = 'Example Inc';
        $experience_1->location = 'Los Angeles, USA';
        $experience_1->from = new Carbon('2019-07-15');
        $experience_1->currently_working = true;
        $experience_1->description = 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        $profile->experience()->save($experience_1);

        $experience_2 = new Experience();
        $experience_2->title = 'Junior Fullstack Developer';
        $experience_2->company = 'Company Inc';
        $experience_2->location = 'Sacramento, USA';
        $experience_2->from = new Carbon('2017-07-15');
        $experience_2->to = new Carbon('2019-06-15');
        $experience_2->currently_working = false;
        $experience_2->description = 'Fusce aliquet lectus felis, sit amet dapibus eros pellentesque et. Praesent consectetur metus a rutrum suscipit. Donec in rutrum erat. Vestibulum scelerisque nunc lacus, sed mattis mi malesuada vitae. Phasellus elementum auctor sem id sagittis. Phasellus erat nisi, rhoncus in imperdiet quis, euismod sit amet nunc. Maecenas orci nibh, porttitor nec scelerisque in, aliquet id enim. Phasellus maximus dui vitae pharetra vulputate. Pellentesque rhoncus vitae erat quis vestibulum.';
        $profile->experience()->save($experience_2);

        $education_1 = new Education();
        $education_1->institution = 'College Name';
        $education_1->location = 'Cambridge, USA';
        $education_1->major = 'Computer Science';
        $education_1->degree = 'Bachelor\'s Degree';
        $education_1->from = new Carbon('2016-01-15');
        $education_1->to = new Carbon('2020-12-15');
        $education_1->description = 'Aliquam lobortis leo elementum lorem bibendum auctor. Curabitur ac eros nec enim feugiat scelerisque. Vestibulum interdum lorem sodales consectetur bibendum. Vivamus leo nunc, tincidunt id aliquet sit amet, venenatis at sem. Phasellus dictum eu eros id dictum. Nullam porttitor lobortis augue id varius. Mauris lobortis urna in porta venenatis';
        $profile->education()->save($education_1);

    }
}
