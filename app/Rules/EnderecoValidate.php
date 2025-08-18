<?php

namespace App\Rules;

use App\Library\ApiInfornet;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnderecoValidate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        switch ($value) {
            case 'invalidAddress':
                $fail('Endereço não encontrado.');
                break;
            case 'badGateway':
            case 'internalError':
                $fail('Não foi possível realizar a busca.');
                break;
        }
    }
}
