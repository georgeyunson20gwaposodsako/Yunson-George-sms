<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'document_type',
        'file_path',
        'status',
        'notes',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
