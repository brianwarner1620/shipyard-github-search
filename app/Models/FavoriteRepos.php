<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteRepos extends Model
{
    protected $fillable = [
        'user_id',
        'repo_id',
        'name',
        'owner',
        'html_url',
        'description',
        'stargazers_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
