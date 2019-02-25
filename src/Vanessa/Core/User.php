<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 22:50
 */

namespace Vanessa\Core;



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

	public function __toArray(){
		unset($this->user['password']);
		return $this->user;
	}


	/**
	 * @param string $username
	 * @param string $password
	 * @return bool
	 * @throws \\Vanessa\\Exception
	 */
	public static function login(string $username, string $password): bool
	{
		$userStorage = StorageFileHandler::openSecuredStorage(StorageFileHandler::SECURED_FILE_USERS);

		$user = $userStorage->get($username);

		if ($user === YamlSQL::RESULT_NONE) {
			throw new VanessaException( Localization::__("Couldn\'t match user nor password."));
		}

		if (password_verify($password, $user['password']) === FALSE) {
			throw new VanessaException( Localization::__("Couldn\'t match password."));
		}

		$_SESSION[self::SESSION_NAME] = (new User($user))->__toArray();

		$userStorage = NULL;
		return TRUE;
	}

	public static function create(string $username, string $password, string $role = "editor")
	{
		$userStorage = StorageFileHandler::openSecuredStorage(StorageFileHandler::SECURED_FILE_USERS);
		$userStorage->add($username, [
			"password" => password_hash($password, PASSWORD_BCRYPT),
			"role" => $role
		]);

		$userStorage = NULL;

		return TRUE;
	}

	public static function getLoggedInUser()
	{
		return @$_SESSION[self::SESSION_NAME] ?: YamlSQL::RESULT_NONE;
	}

	public static function logout(){
		unset($_SESSION[self::SESSION_NAME]);
	}

	public static function isAuthed(): bool {
		return self::getLoggedInUser() !== YamlSQL::RESULT_NONE;
	}
}