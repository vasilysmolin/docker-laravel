<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;

class UsersController extends Controller
{
    public function index(): UsersResource
    {
        return new UsersResource(User::all());
    }

    public function show(int $id): UserResource
    {
        return new UserResource(User::findOrFail($id));
    }
}
