<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculatePaceRequest extends FormRequest
{
    # Constants
    const MAX_DISTANCE_MILES = 350; # Max miles runnable by a human
    const MAX_DISTANCE_KILOMETERS = 350 * 1.6; # Max kilometers runnable by a human
    const MAX_HOURS = 90; # World record longest continuous run was 87 hours.

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'distance' => 'required|numeric|min:0.01',
            'hours' => 'required|numeric|min:0|max:' . $this::MAX_HOURS,
            'minutes' => 'required|numeric|min:0|max:59',
            'unit' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute is required',
            'numeric' => ':attribute should be a number',
            'digit' => ':attribute should be a number',
            'hours.max' => 'Running over :max :attribute is not humanly possible - yet.'
        ];
    }

    /**
     * Add custom validation that only makes sense due to app context
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                $hours = $this->input('hours');
                $minutes = $this->input('minutes');
                $distance = $this->input('distance');
                $unit = $this->input('unit');

                # Either minutes or hours must contain a value
                if ($minutes == 0 && $hours == 0) {
                    $validator->errors()->add('hours', 'Either minutes or hours must be greater than 0');
                    $validator->errors()->add('minutes', 'Either minutes or hours must be greater than 0');
                }

                # Unit must be a valid value - just in case anyone modifies the DOM
                if (!in_array($unit, ['mile', 'kilometer'])) {
                    $validator->errors()->add('unit', 'Invalid distance unit - must be mile or kilometer');
                }

                $max_distance = $unit == 'mile' ? $this::MAX_DISTANCE_MILES : $this::MAX_DISTANCE_KILOMETERS;
                if ($distance > $max_distance) {
                    $validator->errors()->add('distance', $distance . ' ' . $unit . 's is not humanly possible - yet.');
                }
            });
        }
    }
}
