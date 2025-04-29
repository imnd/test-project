<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getList(int $page, int $perPage)
    {
        return User::query()
            ->paginate(
                perPage: $perPage,
                page: $page,
            );
    }

    public function find(array $data): ?User
    {
        return User::where('email', $data['email'])->withTrashed()->first();
    }

    public function create(array $data): ?User
    {
        $data['password'] = Hash::make($data['password']);
        try {
            return User::create($data);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}
