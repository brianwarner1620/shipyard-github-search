<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\FavoriteReposServiceInterface;
use App\Models\FavoriteRepos;
use Illuminate\Support\Facades\Auth;

class FavoriteReposService implements FavoriteReposServiceInterface
{
    public function getAllFavoriteReposByUser(string $perPage)
    {
        if (Auth::user()){
            $favoriteRepos = FavoriteRepos::paginate($perPage)->through(fn ($repo) => [
                'id'    => $repo->id,
                'repo_id' => $repo->repo_id,
                'name' => $repo->name,
                'owner' => $repo->owner,
                'description'   => $repo->description,
                'stargazers_count' => $repo->stargazers_count
            ]);
            return $favoriteRepos;
        }
    }
}