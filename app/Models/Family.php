<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'no_siblings',
        'total_parent_income'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}