<?php

namespace App\Rules\User;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class PassValidate implements Rule
{

    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * @param string $attribute
     * @param mixed $user
     * @return bool|void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function passes($attribute, $user)
    {
        $currentPassword = $this->request->get('current_password');
        if (!\Hash::check($currentPassword, $user->password)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('auth.password_invalidate');
    }
}
