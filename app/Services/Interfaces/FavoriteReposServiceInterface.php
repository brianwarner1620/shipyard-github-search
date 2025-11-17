<?php

namespace App\Services\Interfaces;

interface FavoriteReposServiceInterface
{
    public function getAllFavoriteReposByUser(string $perPage);
}