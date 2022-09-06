<?php

namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request): UsersResource
    {
        $take = $request->get('take') ?? 100;
        $skip = $request->get('skip') ?? 0;
        return new UsersResource(User::take($take)->skip($skip)->get());
    }

    public function show(int $id): UserResource
    {
        return new UserResource(User::findOrFail($id));
    }
}
