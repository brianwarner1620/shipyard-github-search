<?php

namespace App\Services\Interfaces;

interface FavoriteReposServiceInterface
{
    public function getAllFavoriteReposByUser(string $perPage);

    public function getAllFavoriteReposIdsByUser();

    public function createWithData(array $data);
    
    public function deleteById(string $itemId);
}