<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'maiden_name',
        'email',
        'contact_number',
        'address',
        'birthdate',
        'place_of_birth',
        'sex',
        'citizenship',
        'school',
        'school_id',
        'school_address',
        'school_sector',
        'year_level',
        'tribal_membership',
        'disability_type',
        'course',
        'gpa',
        'has_other_assistance',
        'assistance_1',
        'assistance_2'
    ];

    public function family()
    {
        return $this->hasOne(Family::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function isQualified()
    {
        return $this->citizenship === 'Filipino' &&
               $this->family?->total_parent_income <= 400000 &&
               $this->school_sector === 'public'; // simplified
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}