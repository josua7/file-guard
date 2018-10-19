<?php

namespace App\Providers;

use App\FileUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class FileUserProvider implements UserProvider
{
	/**
	 * The File User Model
	 */
	private $model;

	/**
	 * Create a new mongo user provider.
	 *
	 * @param FileUser $fileUser
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 * @return void
	 */
	public function __construct(FileUser $fileUser)
	{
		$this->model = $fileUser;
	}

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed  $identifier
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveById($identifier) {}

	/**
	 * Retrieve a user by their unique identifier and "remember me" token.
	 *
	 * @param  mixed   $identifier
	 * @param  string  $token
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByToken($identifier, $token) {}

	/**
	 * Update the "remember me" token for the given user in storage.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
	 * @param  string  $token
	 * @return void
	 */
	public function updateRememberToken(Authenticatable $user, $token) {}

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		if (empty($credentials)) {
			return;
		}

		$user = $this->model->getUserByCredentials(['username' => $credentials['username']]);

		return $user;
	}

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validateCredentials(Authenticatable $user, array $credentials)
	{
		return ($credentials['username'] == $user->getAuthIdentifier() &&
			$credentials['password'] == $user->getAuthPassword());
	}
}