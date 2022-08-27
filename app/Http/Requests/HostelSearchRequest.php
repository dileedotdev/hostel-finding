<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HostelSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'address' => ['string'],
            'north' => ['required', 'numeric'],
            'south' => ['required', 'numeric'],
            'west' => ['required', 'numeric'],
            'east' => ['required', 'numeric'],
        ];
    }
}
