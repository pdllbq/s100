<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomMessage implements Rule
{
	var $message;
	
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message=$message;
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
        if(!$this->message){
			return true;
		}
		
		return false;
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
