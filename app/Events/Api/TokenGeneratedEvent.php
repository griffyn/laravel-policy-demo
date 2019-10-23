<?php

namespace App\Events\Api;

use Illuminate\Queue\SerializesModels;
use Tymon\JWTAuth\JWTGuard;

class TokenGeneratedEvent
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    public $guard;

    /**
     * Create a new event instance.
     *
     * @param  JWTGuard  $guard
     *
     * @return void
     */
    public function __construct(JWTGuard $guard)
    {
        $this->guard = $guard;
        $this->user = $guard->user();
    }
}
