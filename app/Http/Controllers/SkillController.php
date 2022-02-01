<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Models\Profile;
use App\Models\Skill;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request): Response
    {
        $request->validate([
           'profile_id' => ['required', Rule::exists('profiles', 'id')],
           'name' => ['required', 'max:255'],
           'years_of_experience' => ['nullable', 'integer', 'gte:1']
       ]);

        $profile = Profile::find($request->input('profile_id'));

        $skill = $profile->skills()->create($request->only(['name', 'years_of_experience']));

        return response($skill);
    }

    public function update(Skill $skill, Request $request): Response
    {

        $skill->update($request->validate([
            'name' => ['required', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'gte:1']
        ]));

        return response($skill);
    }

    public function destroy(Skill $skill): Response
    {
        $skill->delete();
        return response()->noContent();
    }
}
