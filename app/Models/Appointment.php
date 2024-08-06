<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    protected $fillable = [
        'client_name',
        'email',
        'animal_name',
        'animal_type',
        'age',
        'symptoms',
        'appointment_date',
        'time_of_day',
        'doctor_id',
    ];
}
