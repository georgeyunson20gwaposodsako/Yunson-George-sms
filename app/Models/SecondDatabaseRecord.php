<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondDatabaseRecord extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'some_table';
    protected $fillable = ['name','email'];
    public $timestamps = true;
}