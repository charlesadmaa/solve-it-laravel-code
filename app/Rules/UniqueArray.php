<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueArray implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if there are duplicates in the array
        return count($value) === count(array_unique($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Duplicate values are not allowed.';
    }
}
