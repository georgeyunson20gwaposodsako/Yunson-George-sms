<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'scholarship_program_id',
        'status',
        'remarks'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function scholarshipProgram()
    {
        return $this->belongsTo(ScholarshipProgram::class);
    }
}