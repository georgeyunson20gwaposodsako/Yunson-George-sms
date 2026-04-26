<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'scholarship_program_id',
        'document_name',
        'is_required'
    ];

    public function scholarshipProgram()
    {
        return $this->belongsTo(ScholarshipProgram::class);
    }
}