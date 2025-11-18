<?php

namespace App\Http\Controllers;

use App\Services\FavoriteReposService;
use Illuminate\Support\Facades\Log;
use Exception;

use App\Http\Requests\StoreFavoriteRepoRequest;
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

    /**
     * List all favorite repos by user.
     */
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
     * Store a favorite repo
     */
    public function store(StoreFavoriteRepoRequest $request)
    {
       $validated = $request->validated();
       $validated['user_id'] = Auth::user()->id;

       try {
            $this->favoriteReposService->createWithData($validated);
       } catch (Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
       }
    }

    /**
     * Delete a favorite repo.
     */
    public function destroy(string $itemId): RedirectResponse
    {
        try {
            $this->favoriteReposService->deleteById($itemId);
        } catch (Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
        
        return Redirect::to('/favorite-repos');
    }
}
