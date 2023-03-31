<?php

namespace App\Models;

use App\Models\Buildings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
    use HasFactory;

    public function building()
    {
        return $this->belongsTo(Buildings::class);
    }

    
    protected $fillable = [ 
        'user_id',
        'building_id', 
        'class_name',    
     ];
}
