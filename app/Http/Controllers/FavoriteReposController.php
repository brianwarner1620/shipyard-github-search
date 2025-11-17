<?php

namespace App\Http\Controllers;

use App\Services\FavoriteReposService;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\FavoriteRepos;

class FavoriteReposController extends Controller
{
     protected $favoriteReposService;

    // Dependency inject the FavoriteReposService class
    public function __construct(FavoriteReposService $favoriteReposService)
    {
        parent::__construct();

        $this->favoriteReposService = $favoriteReposService;
    }

    public function index(Request $request): Response
    {
        $perPage = urldecode($request->input('perPage'));

        $favoriteRepos = $this->favoriteReposService->getAllFavoriteReposByUser($perPage);

        return Inertia::render('FavoriteRepos', [
            'favoriteRepos' => $favoriteRepos->items(),
            'page' => $favoriteRepos->currentPage(),
            'total'   => $favoriteRepos->total()
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function store(Request $request)
    {

       $validated = $request->validate([
        'repo_id' => 'required',
        'name' => 'required|string|max:255',
        'owner' => 'required',
        'html_url' => 'required',
        'description' => 'required',
        'stargazers_count' => 'required'
       ]);
       $validated['user_id'] = Auth::user()->id;

       FavoriteRepos::create($validated);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(string $itemId): RedirectResponse
    {
        $repo = FavoriteRepos::find($itemId);

        $repo->delete();
        return Redirect::to('/favorite-repos');
    }
}
