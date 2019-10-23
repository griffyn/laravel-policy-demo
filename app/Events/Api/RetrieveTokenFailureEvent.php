<?php

namespace App\Events\Api;

class RetrieveTokenFailureEvent
{
    /**
     * The credentials for the user.
     *
     * @var array
     */
    public $credentials;

    /**
     * Create a new event instance.
     *
     * @param  array  $credentials
     * @param  bool  $remember
     * @return void
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }
}
