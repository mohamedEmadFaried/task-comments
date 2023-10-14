<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Auth;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;
    
    protected $guard = 'admin';

    protected $fillable = [
        'username',
        'email',
        'password',
        'status',
        'last_login',
        'language',
        'permission_group_id',
    ];

    protected $hidden = [
        'password',
    ];




    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function permissionGroup()
    {
        return $this->belongsTo('App\Models\PermissionGroup', 'permission_group_id');
    }
}
