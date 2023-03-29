<?php

namespace App\Models;

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
    protected $options = [
        'faults_identified' => 'array',
    ];
    protected $fillable = [
       'user_id',
       'building_name',
       'class_name',
       'faults_identified',
       'message',
       'status',
        
    ];
    public function save(array $options = [])
    {
        if (is_array($this->faults_identified)) {
            $this->faults_identified = implode(',', $this->faults_identified);
        }
        return parent::save($options);
    }

    public function getFaultsIdentifiedAttribute($value)
    {
        return is_string($value) ? explode(',', $value) : $value;
    }
}
