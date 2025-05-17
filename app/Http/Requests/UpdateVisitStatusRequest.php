<?php

namespace App\Http\Requests;

use App\Enums\VisitStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVisitStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
      return $this->user()->can('update', $this->route('visit'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
           'status' => ['required', Rule::enum(VisitStatusEnum::class)],
        ];
    }

     public function afterValidation()
    {
        $data = $this->validated();
        $data['visit_id'] = $this->route('visit')->id;
        return $data;
    }

}
