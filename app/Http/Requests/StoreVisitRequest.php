<?php

namespace App\Http\Requests;

use App\Enums\VisitStatusEnum;
use App\Models\Doctor;
use App\Models\Representative;
use App\Models\Visit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $representative = Representative::find($this->input('representative_id'));
        $doctor = Doctor::find($this->input('doctor_id'));

        return $representative && $doctor &&
           $this->user()->can('create', [Visit::class, $representative, $doctor]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'representative_id' => ['required', 'numeric', 'exists:representatives,id'],
            'doctor_id' => ['required',  'numeric', 'exists:doctors,id'],
            'scheduled_at' => ['required', 'date', 'after_or_equal:today'],
            'samples' => ['nullable', 'array'],
            'samples.*.id' =>[ 'required','exists:samples,id'],
            'samples.*.quantity_assigned' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable',  'string', 'max:1000'],
        ];
    }

      public function afterValidation()
      {
        $data = $this->validated();
        $data['user_id'] = auth()->id();

        if (!empty($data['samples'])) {
        $data['samples'] = array_values($data['samples']);
    }
        return $data;
      }

}
