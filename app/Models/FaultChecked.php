<?php

namespace App\Models;

use App\Models\Faults;
use App\Models\Checklist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Resolution;

class FaultChecked extends Model
{
    use HasFactory;
    protected $table = 'faults_checked';
    public function checklist(){
        return $this->belongsTo(Checklist::class);
    }
    public function faults(){
        return $this->belongsTo(Faults::class);
    }
    public function resolution(){
        return $this->hasMany(Resolution::class,'faultschecked_id');
    }
    protected $fillable = [
        'checklist_id',
        'fault_id',
        'message'
    ];
}
