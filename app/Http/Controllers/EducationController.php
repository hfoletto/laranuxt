<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class EducationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request): Response
    {
        $request->validate([
           'profile_id' => ['required', Rule::exists('profiles', 'id')],
           'institution' => ['required', 'max:255'],
           'location' => ['required', 'max:255'],
           'degree' => ['required', 'max:255'],
           'major' => ['required', 'max:255'],
           'description' => ['nullable', 'max:4000'],
           'from' => ['required', 'date'],
           'to' => ['nullable', 'date'],
       ]);

        $profile = Profile::find($request->input('profile_id'));

        /** @var Education $education */
        $education = $profile->education()->create($request->only([
            'institution', 'location', 'degree', 'major', 'description', 'from', 'to'
        ]));

        $education->currently_attending = ($education->to === null);
        $education->save();

        return response($education);
    }

    public function update(Education $education, Request $request): Response
    {

        $education->update($request->validate([
            'institution' => ['required', 'max:255'],
            'location' => ['required', 'max:255'],
            'degree' => ['required', 'max:255'],
            'major' => ['required', 'max:255'],
            'description' => ['nullable', 'max:4000'],
            'from' => ['required', 'date'],
            'to' => ['nullable', 'date'],
        ]));

        $education->currently_attending = ($education->to === null);
        $education->save();

        return response($education);
    }

    public function destroy(Education $education): Response
    {
        $education->delete();
        return response()->noContent();
    }
}
