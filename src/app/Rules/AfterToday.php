<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AfterToday implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $after;
    public function __construct($after) {
        $this->after = $after;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        if($value <= $this->after){
            $fail('Wrong date');
            echo $value .'<='. $this->after;
        }
    }
}
