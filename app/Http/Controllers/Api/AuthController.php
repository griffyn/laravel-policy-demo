<?php

namespace App\Http\Controllers\Api;

use App\Events\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Models\Format\BaseModel;
use App\Models\User;
use App\Rules\User\Account\Expired;
use Carbon\Carbon;
use Tymon\JWTAuth\Token;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTFactory;
use JWTAuth;
use Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'check']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->all(['username', 'password']);

        /* @var $guard \Tymon\JWTAuth\JWTGuard */
        $guard = auth('api');
        event(new Api\RetrieveTokenAttemptingEvent($credentials));

        if (! $token = $guard->attempt($credentials)) {
            event(new Api\RetrieveTokenFailureEvent($credentials));
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        event(new Api\TokenGeneratedEvent($guard));
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $guard = auth('api');

        $token = $guard->refresh();

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * 验证token是否有效
     * @return AuthResource
     */
    public function check()
    {
        $guard = auth('api');

        $check = $guard->check();
        $result = (new BaseModel())->setAttributes([
            'check' => $check
        ]);
        return new AuthResource($result);
    }
}
