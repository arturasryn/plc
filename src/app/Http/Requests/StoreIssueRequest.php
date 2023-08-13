<?php

namespace App\Http\Requests;

use App\Enums\IssueStatusEnum;
use App\Models\Issue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreIssueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:1000',
            'type' => 'required|in:'.(implode(",",array_keys((new Issue())->getChildTypes()))),
            'status' => [new Enum(IssueStatusEnum::class)],
            'tester_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
            'performer_id' => 'required|exists:users,id',
        ];
    }
}
