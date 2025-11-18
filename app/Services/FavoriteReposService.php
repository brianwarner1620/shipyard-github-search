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

    public function getAllFavoriteReposIdsByUser()
    {
        if (Auth::user()){
            $favoriteRepos = FavoriteRepos::where('user_id', Auth::user()->id)->get();

            $favoriteReposIds = [];
            foreach ($favoriteRepos as $item) {   
                $favoriteReposIds[] = (int)$item->repo_id;
            }

            return $favoriteReposIds;
        }
    }

    public function createWithData(array $data) {
        FavoriteRepos::create($data);
    }

    public function deleteById(string $itemId) {    
        $repos = FavoriteRepos::where('id', $itemId)->get();

        foreach ($repos as $repo) {
            $repo->delete();
        }

        $repo->delete();
    }
}