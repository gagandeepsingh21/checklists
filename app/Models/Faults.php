<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;

class Faults extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'faults_identified',
     ];
}
