<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PermissionGroup extends Model
{
    //use LogsActivity;
    protected $table = 'permission_groups';
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'permissions',
    ];
   
    public function admins()
    {
        return $this->hasMany('App\Models\Admin', 'permission_group_id');
    }

    public function getPermissionsAttribute($value)
    {
        return explode(',', $value);
    }

    public function setPermissionsAttribute($value)
    {
        if (!is_array($value) || empty($value)) {
            $value = [];
        }
        $this->attributes['permissions'] = implode(',', $value);
    }
}
