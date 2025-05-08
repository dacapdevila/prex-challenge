<?php

namespace App\Http\Requests\Gif;

use Illuminate\Foundation\Http\FormRequest;

class SaveFavoriteGifRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alias' => 'required|string|max:255',
        ];
    }
}
