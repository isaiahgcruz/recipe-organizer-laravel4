<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = ['email', 'password', 'first_name', 'last_name'];

	protected $appends = ['full_name'];

	private $rules = [
		'email' => 'required|email|unique:users',
		'password' => 'confirmed|required',
		'first_name' => 'required',
		'last_name' => 'required',
		//'nick_name' => 'required'			
	];

	private $errors;

	public function validate($data)
	{
		$validator = Validator::make($data, $this->rules);
		if ($validator->fails())
		{
			$this->errors = $validator->errors();
			return false;
		}
		return true;
	}


	public function errors()
	{
		return $this->errors;
	}

	public function setPasswordAttribute($password)
	{
		return $this->attributes['password'] = Hash::make($password);
	}

	public function getFullNameAttribute()
	{
		return $this->attributes['first_name'] . " " .$this->attributes['last_name'];
	}
}
