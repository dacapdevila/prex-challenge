<?php

namespace App\Http\Requests\Gif;

use Illuminate\Foundation\Http\FormRequest;

class ShowGifRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        return array_merge(parent::validationData(), [
            'id' => $this->route('id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|string',
        ];
    }
}
