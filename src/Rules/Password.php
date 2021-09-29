<?php

namespace Sebastienheyd\Boilerplate\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
    private $length;
    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($length = 8)
    {
        $this->length = $length;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rules = [
            '#.{'.$this->length.',}#' => 'boilerplate::password.rules.length',
            '#[a-z]+#'                => 'boilerplate::password.rules.letter',
            '#[A-Z]+#'                => 'boilerplate::password.rules.capital',
            '#[0-9]+#'                => 'boilerplate::password.rules.number',
            '#[^A-Za-z0-9]+#'         => 'boilerplate::password.rules.special',
        ];

        foreach ($rules as $rule => $msg) {
            if (! preg_match($rule, $value)) {
                $this->message = __($msg, ['min' => $this->length]);

                return false;
            }
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
        return $this->message;
    }
}
