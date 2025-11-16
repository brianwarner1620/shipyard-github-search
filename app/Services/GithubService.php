<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\GithubServiceInterface;

class GithubService implements GithubServiceInterface
{
    public function searchGithubRepositories(?string $searchTerm, ?string $sort, ?string $order, ?int $perPage, ?int $page)
    {
        //$searchTerm = '';
        $acceptHeader = 'application/vnd.github.v3+json';
        $token = config('services.github.personal_access_token');
        $searchApi = "https://api.github.com/search/repositories";

        // A github personal access token will allow greater rate limiting. If not set
        // then rate limiting will be reduced.
        if ($token !== null && $token !== '') {
            $response = Http::withHeaders(['Accept' => $acceptHeader])
                ->withToken($token)
                ->get($searchApi, [
                    'q'     =>  $searchTerm,
                    'sort'  =>  $sort,
                    'order' =>  $order,
                    'per_page' => $perPage,
                    'page'  => $page
            ]);
        } else {
            $response = Http::withHeaders(['Accept' => $acceptHeader])
                ->get($searchApi, [
                    'q'     =>  $searchTerm,
                    'sort'  =>  $sort,
                    'order' =>  $order,
                    'per_page' => $perPage,
                    'page'  => $page
            ]);
        }

        return $response;
        /*$response = Http::withHeaders([
            'Authorization' => 'token ' . $token,
            'Accept' => 'application/vnd.github.v3+json',
        ])->get('https://api.github.com/search/repositories', [
            'q' => $keyword,
            'sort' => 'stars',
            'order' => 'desc',
        ]);*/

    }

}