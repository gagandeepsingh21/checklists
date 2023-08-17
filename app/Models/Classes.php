<?php

namespace App\Models;

use App\Models\Buildings;
use App\Models\Checklist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
    use HasFactory,SoftDeletes;

    public function building()
    {
        return $this->belongsTo(Buildings::class);
    }
    public function checklists()
    {
        return $this->belongsToMany(Checklist::class, 'checklist_class');
    }
    
    protected $fillable = [ 
        'user_id',
        'building_id', 
        'class_name',    
     ];
}
