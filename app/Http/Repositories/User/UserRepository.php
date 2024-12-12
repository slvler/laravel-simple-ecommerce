<?php

namespace App\Http\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    private User $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        try {
            $this->model->create($data);
            return true;
        }catch (\Throwable $throwable){
            return false;
        }
    }
}
