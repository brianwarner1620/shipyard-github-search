<?php

namespace App\Http\Controllers;

use App\Services\GithubService;
use App\Services\FavoriteReposService;
use Illuminate\Support\Facades\Log;
use Exception;

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
    protected $favoriteReposService;

    // Dependency inject the GithubService and FavoriteReposService class
    public function __construct(GithubService $githubService, FavoriteReposService $favoriteReposService)
    {
        parent::__construct();

        $this->githubService = $githubService;
        $this->favoriteReposService = $favoriteReposService;
    }

    public function search(Request $request) {
        $searchTerm = urldecode($request->input('searchTerm'));
        $sort = urldecode($request->input('sort'));
        $order = urldecode($request->input('order'));
        $perPage = urldecode($request->input('perPage'));
        $page = urldecode($request->input('page'));
     
        try {
            $response = $this->githubService->searchGithubRepositories($searchTerm, $sort, $order, (int)$perPage, (int)$page);
        } catch (Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }

        $favoriteReposIds = $this->favoriteReposService->getAllFavoriteReposIdsByUser();

        return Inertia::render('GithubSearch', [
            'repositories' => $response->json(),
            'favoriteReposIds' => $favoriteReposIds,
            'page'  => (int)$page
        ]);
    }
}
