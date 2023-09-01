<?php

namespace App\Models;

use App\Models\Faults;
use App\Models\Classes;
use App\Models\Buildings;
use App\Models\Resolution;
use App\Models\FaultChecked;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Model
{
    use HasFactory,SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function class()
    {
        return $this->belongsToMany(Classes::class, 'checklist_class','checklist_id','class_id');
    }
    public function faults()
    {
        return $this->belongsToMany(Faults::class, 'checklist_fault','checklist_id','fault_id');
    }
    protected $fillable = [
       'user_id',
       'message',
       'date_resolved',
       'status',
       'date_created',
        
    ];
   

}
