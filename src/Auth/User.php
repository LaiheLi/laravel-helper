<?php

namespace LaiheLi\LaravelHelper\Auth;

use LaiheLi\LaravelHelper\Entity\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword, Notifiable;

	protected $hidden = ['password', 'remember_token'];

	/**
	 * 加密密码
	 *
	 * @param $value
	 */
	protected function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}
}
