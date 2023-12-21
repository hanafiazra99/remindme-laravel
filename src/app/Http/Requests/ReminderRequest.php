<?php

namespace App\Http\Requests;

use App\Rules\AfterToday;
use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends BaseRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description'=>'required',
            'remind_at'=>['required',new AfterToday(now()->timestamp) ],
            'event_at'=>['required',new AfterToday($this->remind_at) ],
            'title'=>'required'
        ];
    }
}
