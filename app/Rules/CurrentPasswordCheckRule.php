<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CurrentPasswordCheckRule implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value, $guard = null)
    {
        $current_password =   auth()->user()->password;
        return Hash::check($value, $current_password);
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The current password field does not match your password');
    }
}
