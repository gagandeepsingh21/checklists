<?php

namespace App\Models;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faults extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'faults_identified',
     ];
}
