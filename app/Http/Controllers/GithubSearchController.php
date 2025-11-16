<?php

namespace App\Http\Controllers;

use App\Services\GithubService;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use Illuminate\Http\Request;

class GithubSearchController extends Controller
{
    protected $githubService;

    // Dependency inject the GithubService class
    public function __construct(GithubService $githubService)
    {
        parent::__construct();

        $this->githubService = $githubService;
    }

    public function search(Request $request) {
        $searchTerm = '*' . urldecode($request->input('searchTerm')) . '*';
        $sort = urldecode($request->input('sort'));
        $order = urldecode($request->input('order'));
        $perPage = urldecode($request->input('perPage'));
        $page = urldecode($request->input('page'));
        //dd($searchTerm);
        /*$acceptHeader = 'application/vnd.github.v3+json';
        $token = config('services.github.personal_access_token');
        $searchApi = "https://api.github.com/search/repositories";

        // A github personal access token will allow greater rate limiting. If not set
        // then rate limiting will be reduced.
        if ($token !== null && $token !== '') {
            $response = Http::withHeaders(['Accept' => $acceptHeader])
                ->withToken($token)
                ->get($searchApi, [
                    'q'     =>  $searchTerm,
                    'sort'  =>  'stars',
                    'order' =>  'desc'
            ]);
        } else {
            $response = Http::withHeaders(['Accept' => $acceptHeader])
                ->get($searchApi, [
                    'q'     =>  $searchTerm,
                    'sort'  =>  'stars',
                    'order' =>  'desc'
            ]);
        }*/
        /*$response = Http::withHeaders([
            'Authorization' => 'token ' . $token,
            'Accept' => 'application/vnd.github.v3+json',
        ])->get('https://api.github.com/search/repositories', [
            'q' => $keyword,
            'sort' => 'stars',
            'order' => 'desc',
        ]);*/
        $response = $this->githubService->searchGithubRepositories($searchTerm, $sort, $order, (int)$perPage, (int)$page);
 dd($response->json());
        return Inertia::render('GithubSearch', [
            'repositories' => $response->json(),
            'searchTerm'   => $searchTerm
        ]);

        //return $response->json();
    }

    /**
     * Display the user's profile form.
     */
    /*public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }*/

    /**
     * Update the user's profile information.
     */
    /*public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }*/

    /**
     * Delete the user's account.
     */
    /*public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }*/
}
