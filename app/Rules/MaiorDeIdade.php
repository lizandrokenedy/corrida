<?php

namespace App\Rules;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class MaiorDeIdade implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        try {
            $dataDeNascimento = Carbon::parse($value);
            return $dataDeNascimento->diffInYears(Carbon::now()) >= 18 ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Inscrição permitida apenas para maiores de 18 anos.';
    }
}
