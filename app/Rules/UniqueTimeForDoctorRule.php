<?php

namespace App\Rules;

use App\Models\Appointment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueTimeForDoctorRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $doctorId = request('doctor_id');
        $date = request('date');
        $time = $value;

        if (! $doctorId || ! $date || ! $time) {
            return;
        }

        $query = Appointment::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('time', $time);

        // If editing, ignore current record
        if (request()->route()->parameter('record')) {
            $query->where('id', '!=', request()->route()->parameter('record'));
        }

        if ($query->exists()) {
            $fail('This doctor already has an appointment at this time.');
        }
    }
}
