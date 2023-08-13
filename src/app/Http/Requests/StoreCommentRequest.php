<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body' => 'required|max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'body' => 'comment',
        ];
    }

}
