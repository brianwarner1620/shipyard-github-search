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
        $favoriteRepos = FavoriteRepos::paginate($perPage)->through(fn ($repo) => [
            'repo_id' => $repo->repo_id,
            'name' => $repo->name,
            'owner' => $repo->owner,
            'description'   => $repo->description,
            'stargazers_count' => $repo->stargazers_count
        ]);

        return Inertia::render('FavoriteRepos', [
            'favoriteRepos' => $favoriteRepos->items(),
            'page' => $favoriteRepos->currentPage(),
            'total'   => $favoriteRepos->total()
        ]);
    }
}
