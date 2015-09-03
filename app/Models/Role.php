<?php namespace qilara\Models;

#use Illuminate\Database\Eloquent\Model;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function users()
    {
        return $this->hasMany('qilara\Models\RoleUser', 'role_id', 'id');
    }
}