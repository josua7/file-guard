<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;

class FileUser implements Authenticatable
{
	public $username;
	private $password;
	protected $rememberTokenName = 'remember_token';

	/**
	 * Get user by Credentials
	 *
	 * @param array $credentials
	 * @return \Illuminate\Contracts\Auth\Authenticatable
	 */
	public function getUserByCredentials(Array $credentials)
	{
		$users = config('auth_api.users');

		if (isset($users[$credentials['username']])) {
			$this->username = $credentials['username'];
			$this->password = $users[$credentials['username']];
		}

		return $this;
	}

	/**
	 * Get the name of the unique identifier for the user.
	 *
	 * @return string
	 */
	public function getAuthIdentifierName()
	{
		return "username";
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->{$this->getAuthIdentifierName()};
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		if (!empty($this->getRememberTokenName())) {
			return $this->{$this->getRememberTokenName()};
		}
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		if (!empty($this->getRememberTokenName())) {
			$this->{$this->getRememberTokenName()} = $value;
		}
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return $this->rememberTokenName;
	}
}