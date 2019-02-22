<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 20:40
 */

namespace Vanessa;


class User
{
	const SESSION_NAME = "USER_SESSION";

	private $user;

	public function __construct(array $user)
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		$this->user = $user;
	}

	public final function getArray(): array {
		return [
			"username" => $this->user['username']
		];
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @return bool
	 * @throws \\Vanessa\\Exception
	 */
	public static function login(string $username, string $password): bool
	{
		$userStorage = NoSQL::open('users');
		$user = $userStorage->where("username", "=", strtolower($username))->fetch()[0];


		if ($user == NULL) {
			throw new VanessaException(new __("Couldn't match user nor password."));
		}

		if (password_verify($password, $user['password']) === FALSE) {
			throw new VanessaException(new __("Couldn't match password."));
		}

		$_SESSION[self::SESSION_NAME] = (new User($user))->getArray();

		$userStorage = NULL;
		return TRUE;
	}

	public static function create(string $username, string $password)
	{
		$userStorage = NoSQL::open('users');

		if(count($userStorage->where("username", "=", strtolower($username))->fetch()) > 0){
			throw new VanessaException(new __("Username is already in use"));
		}

		$userStorage->insert([
			"username" => $username,
			"password" => password_hash($password, PASSWORD_BCRYPT)
		]);

		$userStorage = NULL;

		return TRUE;
	}

	public static function getLoggedInUser()
	{
		return @$_SESSION[self::SESSION_NAME] ?: null;
	}

	public static function logout(){
		unset($_SESSION[self::SESSION_NAME]);
	}

	public static function isAuthed(): bool {
		return self::getLoggedInUser() !== null;
	}
}
