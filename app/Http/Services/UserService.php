<?php

namespace App\Http\Services;

use App\Http\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepositoryInterface $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(array $data): bool
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->store($data);
    }
}
