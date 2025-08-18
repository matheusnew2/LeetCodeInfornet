<?php

namespace App\Http\Requests;

use App\Library\ApiInfornet;
use App\Rules\EnderecoValidate;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\ConnectionException;
class GetPrestadoresRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $request = $this->all();

        $request['endereco_origem'] = $this->verifyAddress($request['endereco_origem'] ?? '');
        $request['endereco_destino'] = $this->verifyAddress($request['endereco_destino'] ?? '');

        if(!empty($request['order']))
        {
            switch ($request['order'])
            {
                case 1:
                    $request['order'] = 'valor_total';
                    break;
                case 2:
                    $request['order'] = 'distancia_total';
                    break;
                case 3:
                    $request['order'] = 'status';
                    break;
            }
        }
        $this->replace($request);
        
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function verifyAddress($endereco)
    {
        try
        {
            if(!$endereco)
                return '';
            $apiInfornet = new ApiInfornet();
            $response = $apiInfornet->getEnderenco($endereco);
            if(!$response)
            {
                return 'invalidAddress';
            }
            return $response;
        }
        catch(ConnectionException $e)
        {
            return 'badGateway';
        } 
        catch(Exception $e)
        {
            return 'internalError';
        }
        
    
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_servico' => 'required|integer',
            'endereco_origem' => ['required', new EnderecoValidate()],
            'endereco_destino' => ['required', new EnderecoValidate()],
            'qtd' => 'between:1,100',
            'filtro' => '',
            'order' => '',
        ];
    }
    public function messages()
    {
        return [
            'id_servico.required' => 'O campo serviço é obrigatorio'
        ];
    }
}
