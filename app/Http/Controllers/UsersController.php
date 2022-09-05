<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;

class UsersController extends Controller
{

    public function index()
    {
        return new UsersResource(User::all());
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

}
