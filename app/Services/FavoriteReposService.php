<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\FavoriteReposServiceInterface;
use App\Models\FavoriteRepos;
use Illuminate\Support\Facades\Auth;

class FavoriteReposService implements FavoriteReposServiceInterface
{
    public function getAllFavoriteRepos()
    {
        if (Auth::user()){
            $favoriteRepos = FavoriteRepos::where('user_id', Auth::user()->id)->paginate(15);
            dd($favoriteRepos['data']['items']);
            return $favoriteRepos;
        }
    }
}