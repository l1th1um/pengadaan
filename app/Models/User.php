<?php namespace qilara\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
	use EntrustUserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function procurement()
    {
        return $this->hasMany('qilara\Models\Procurement','created_by', 'id');
    }

    public function invoice()
    {
        return $this->hasMany('qilara\Models\Invoice');
    }

    function userRole()
    {
        return $this->hasOne('qilara\Models\RoleUser');
    }

	public function memo()
	{
		return $this->hasMany('\qilara\Models\Memo');
	}

	public function additionalRole()
	{
		return $this->hasOne('qilara\Models\AdditionalRole','id','add_role');
	}

}
