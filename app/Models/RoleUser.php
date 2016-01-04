<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {
    protected $table = 'role_user';
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    function users()
    {
        return $this->belongsTo('qilara\Models\User');
    }

    function roles()
    {
        return $this->belongsTo('qilara\Models\Role', 'role_id', 'id');
    }
}
