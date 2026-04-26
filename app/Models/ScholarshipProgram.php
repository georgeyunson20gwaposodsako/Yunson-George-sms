<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipProgram extends Model
{
    use HasFactory;

    // The VIP List: We added grant_amount, slots, and deadline here!
    protected $fillable = [
        'name',
        'description',
        'grant_amount',
        'slots',
        'deadline'
    ];

    // Connects this program to the applications table
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}