<?php

namespace App\Models;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Buildings extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'building_name', 
     ];

     public function classes() {
        return $this->hasMany(Classes::class);
     }
}
