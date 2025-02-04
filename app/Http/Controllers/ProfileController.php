<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response(Profile::with([
            'skills',
            'experience',
            'education'
        ])->first());
    }

    public function update(Profile $profile, Request $request): Response
    {

        $request->validate([
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            'job_title' => ['required', 'max:100'],
            'email' => ['required', 'max:100', 'email'],
            'phone_number' => ['nullable', 'max:50'],
            'location' => ['nullable', 'max:150'],
            'introduction' => ['nullable', 'max:4000'],
            'github_url' => ['nullable', 'max:255', 'url'],
            'linkedin_url' => ['nullable', 'max:255', 'url'],
            'twitter_url' => ['nullable', 'max:255', 'url'],
            'website_url' => ['nullable', 'max:255', 'url'],
            'photo' => ['nullable', 'image'],
        ]);

        $profile->update($request->only([
            'first_name', 'last_name', 'job_title', 'email', 'phone_number', 'location',
            'introduction', 'github_url', 'linkedin_url', 'twitter_url', 'website_url',
        ]));

        if ($request->file('photo')) {
            $profile->update(['photo_path' => $request->file('photo')->store('public')]);
        }

        return response($profile);
    }
}
