<?php

namespace App\Models;

use App\Models\Classes;
use App\Models\Checklist;
use App\Models\FaultChecked;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faults extends Model
{
    use HasFactory,SoftDeletes;
    public function faultschecked(){
        return $this->hasMany(FaultChecked::class,'fault_id');
    }
    public function checklists()
    {
        return $this->belongsToMany(Checklist::class, 'checklist_fault');
    }
    protected $fillable = [
        'faults_identified',
     ];
}
