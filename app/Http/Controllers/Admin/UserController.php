<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController
{
    public function index() {
        \Gate::authorize('view', 'users');

        $user = User::paginate();

        return UserResource::collection($user);
    }
    public function show($id) {
        \Gate::authorize('view', 'users');

        $user = User::find($id);

        return new UserResource($user);
    }
    public function store(UserCreateRequest $request) {
        \Gate::authorize('edit', 'users');

        $user = User::create($request->only("first_name", "last_name", "email", "password"));



        return response($user, 201);
    }
    public function update(UserUpdateRequest $request, $id) {
        \Gate::authorize('edit', 'users');

        $user = User::find($id);
        $user->update($request->only("first_name", "last_name", "email", "password"));

        UserRole::where('user_id', $user->id)->delete();

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->input('role_id')
        ]);

        return response(new UserResource($user), 202);

    }
    public function destroy($id) {
        \Gate::authorize('view', 'users');

        User::destroy($id);

        return response(null, 204);
    }

    public function user ()
    {
        $user = Auth::user();

        $resource = new UserResource($user);


        if ($user->is_common) {
            return $resource;
        }

        return ($resource)->additional([
            'data' => [
                'permissions' => $user->permissions()
            ]
        ]);
    }
    public function updateInfo (Request $request)
    {
        $user = Auth::user();
        $user->update($request->only("first_name", "last_name", "email"));

        return response(new UserResource($user), 202);
    }
    public function updatePassword (Request $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response(new UserResource($user), 202);
    }
}
