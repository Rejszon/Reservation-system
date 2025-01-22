<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Duration implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^([0-9]{1,2}):([0-9]{2}):([0-9]{2})$/';
        if (preg_match($pattern, $value, $matches)) {
            $hours = (int) $matches[1];
            $minutes = (int) $matches[2];
            $seconds = (int) $matches[3];
            
            if ($hours >= 5 || $minutes >= 60 || $seconds >= 60) {
                $fail('Minuty i sekundy nie mogą przekraczać 59. A godziny 5');
                return;
            }
            return;
        }
        $fail('Należy zachować format HH:MM:SS');
    }
}
