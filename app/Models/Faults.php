<?php

namespace App\Models;

use App\Models\Classes;
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
    protected $fillable = [
        'faults_identified',
     ];
}
