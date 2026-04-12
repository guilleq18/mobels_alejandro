<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    protected $redirectRoute = 'products.show';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email:rfc', 'max:120'],
            'city' => ['nullable', 'string', 'max:120'],
            'project_details' => ['required', 'string', 'min:12', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Necesitamos tu nombre para preparar el presupuesto.',
            'phone.required' => 'Sumá un teléfono o WhatsApp para poder responderte.',
            'email.email' => 'El correo que cargaste no parece válido.',
            'project_details.required' => 'Contanos al menos una medida, ambiente o idea del mueble.',
            'project_details.min' => 'Agregá un poco más de contexto para que el presupuesto salga mejor orientado.',
        ];
    }

    protected function getRedirectUrl(): string
    {
        $product = $this->route('product');

        if ($product) {
            return route('products.show', $product).'#presupuesto';
        }

        return parent::getRedirectUrl();
    }
}
