<?php

namespace App\Models;

use App\Models\User;
use App\Models\FaultChecked;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resolution extends Model
{
    use HasFactory;
    protected $fillable = [
        'faultschecked_id',
        'resolved_by',
        'date_resolved',
        'status',
    ];
    public function faultschecked(){
        return $this->belongsTo(FaultChecked::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }

}
