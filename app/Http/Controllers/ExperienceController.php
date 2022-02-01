<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ExperienceController extends Controller
{

    public function store(Request $request): Response
    {
        $request->validate([
            'profile_id' => ['required', Rule::exists('profiles', 'id')],
            'title' => ['required', 'max:255'],
            'company' => ['nullable', 'max:255'],
            'location' => ['nullable', 'max:255'],
            'description' => ['nullable', 'max:4000'],
            'from' => ['required', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        $profile = Profile::find($request->input('profile_id'));

        $experience = $profile->experience()->create($request->only([
            'title', 'company', 'location', 'description', 'from', 'to'
        ]));

        $experience->currently_working = ($experience->to === null);
        $experience->save();

        return response($experience);
    }

    public function update(Experience $experience, Request $request): Response
    {

        $experience->update($request->validate([
           'title' => ['required', 'max:255'],
           'company' => ['nullable', 'max:255'],
           'location' => ['nullable', 'max:255'],
           'description' => ['nullable', 'max:4000'],
           'from' => ['required', 'date'],
           'to' => ['nullable', 'date']
       ]));

        $experience->currently_working = ($experience->to === null);
        $experience->save();

        return response($experience);
    }

    public function destroy(Experience $experience): Response
    {
        $experience->delete();
        return response()->noContent();
    }
}
