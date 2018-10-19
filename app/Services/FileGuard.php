<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class FileGuard implements Guard
{
	protected $request;
	protected $provider;
	protected $user;

	/**
	 * Create a new authentication guard.
	 *
	 * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 */
	public function __construct(UserProvider $provider, Request $request)
	{
		$this->request = $request;
		$this->provider = $provider;
	}

	/**
	 * Determine if the current user is authenticated.
	 *
	 * @return bool
	 */
	public function check()
	{
		return !is_null($this->user());
	}

	/**
	 * Determine if the current user is a guest.
	 *
	 * @return bool
	 */
	public function guest()
	{
		return !$this->check();
	}

	/**
	 * Get the currently authenticated user.
	 *
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function user()
	{
		return $this->user;
	}

	/**
	 * Get the ID for the currently authenticated user.
	 *
	 * @return int|null
	 */
	public function id()
	{
		if ($user = $this->user()) {
			return $this->user()->getAuthIdentifier();
		}
	}

	/**
	 * Validate a user's credentials.
	 *
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validate(array $credentials = [])
	{
		if (empty($credentials['username']) || empty($credentials['password'])) {
			if (!$credentials = $this->getCredentialsFromRequest()) {
				return false;
			}
		}

		$user = $this->provider->retrieveByCredentials($credentials);

		if (!is_null($user) && $this->provider->validateCredentials($user, $credentials)) {
			$this->setUser($user);

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Set the current user.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
	 * @return void
	 */
	public function setUser(Authenticatable $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get credentials from request.
	 *
	 * @return mixed
	 */
	public function getCredentialsFromRequest()
	{
		$authorization = explode(' ', $this->request->header('Authorization'));

		$hash = explode(':', base64_decode($authorization[1]));

		return [
			'username' => $hash[0],
			'password' => $hash[1]
		];
	}
}