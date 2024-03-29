<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Resolution;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JeffGreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes,TwoFactorAuthenticatable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
    public function resolutions()
    {
        return $this->hasMany(Resolution::class);
    }
    
    protected $fillable = [
        'name',
        'email',
        'password',
        
    ];
    
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
