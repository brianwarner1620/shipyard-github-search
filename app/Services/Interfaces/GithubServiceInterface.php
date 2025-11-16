<?php

namespace App\Services\Interfaces;

interface GithubServiceInterface
{
    public function searchGithubRepositories(?string $searchTerm, ?string $sort, ?string $order, ?int $perPage, ?int $page);
}