<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoreFavoriteRepoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'repo_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'owner' => 'required',
            'html_url' => 'required',
            'description' => 'required',
            'stargazers_count' => 'required',
        ];
    }
}
