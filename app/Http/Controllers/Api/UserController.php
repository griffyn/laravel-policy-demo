<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\User\PassValidate;
use Illuminate\Http\Request;
use Hash;
use Auth;

class UserController extends Controller
{
    public function register(RegisterRequest $request, User $user)
    {
        $request->offsetSet('password', Hash::make($request->input('password')));
        $registration = Auth::user()->firstOrCreate(
            [
                'id' => Auth::id()
            ],
            $request->all()
        );
        $registration = $user->firstOrCreate($request->all());
        return new UserResource($registration);
    }
    public function password(PasswordRequest $request, User $user, $uuid)
    {
        $user = $user->where('uuid', $uuid)->firstOrFail();
        $this->validate(
            ['password_invalidate' => $user],
            ['password_invalidate' => [
                new PassValidate($request)
            ]]
        );
        $user->update(['password'=>Hash::make($request->input('password'))]);

        return new UserResource($user);
    }
}
