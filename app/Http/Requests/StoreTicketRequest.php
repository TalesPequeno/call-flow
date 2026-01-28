<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['nullable', 'in:baixa,media,alta'],
            'sector' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Informe um título para o chamado.',
            'title.max' => 'O título pode ter no máximo 255 caracteres.',
            'description.required' => 'Descreva o problema do chamado.',
            'priority.in' => 'A prioridade informada é inválida.',
            'sector.max' => 'O setor pode ter no máximo 255 caracteres.',
        ];
    }
}
