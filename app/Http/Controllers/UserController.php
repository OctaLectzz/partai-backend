<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->has('role')) {
            $users->where('role', $request->role);
        }

        if ($request->has('status')) {
            $users->where('status', $request->boolean('status'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('kta_number', 'like', "%{$search}%");
            });
        }

        return UserResource::collection($users->paginate($request->get('per_page', 15)));
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
