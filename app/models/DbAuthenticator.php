<?php
/**
 * DbAuthenticator
 *
 * @author Tomas Goldir <tomas.goldir@gmail.com>
 * @copyright Copyleft (@) http://www.gnu.org/copyleft
 * @package webcreatio
 */

class DbAuthenticator extends Object implements IAuthenticator
{
	public function authenticate(array $credentials)
	{
		// Get username and password
		$username = $credentials[self::USERNAME];
		$password = $credentials[self::PASSWORD];

		// Get user
		$dbuser = dibi::fetch('SELECT id, realname, password FROM :wc:users WHERE username=%s', $username);

		// User not found
		if (!$dbuser) {
			throw new AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
		}

		// Invalid password
		if ($dbuser->password !== $password) {
			throw new AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
		}

		// Get user roles
		$roles = dibi::query('
			SELECT :wc:users_roles.id_role, :wc:roles.role FROM :wc:users_roles
			LEFT JOIN :wc:roles ON :wc:roles.id = :wc:users_roles.id_role
			WHERE id_user=%u', $dbuser->id)
			->fetchPairs('id_role', 'role');

		// Set guest role for user without any role
		if (empty($roles))
			$roles = Environment::getUser()->guestRole;

		// Save user information to session
		/*$namespace = Environment::getSession('user');
		if (isset($namespace->count))
			$namespace->count++;
		else
			$namespace->count = 1;
		$namespace->username = $username;
		$namespace->realname = $dbuser->realname;
		$namespace->roles = $roles;*/
		$user = Environment::getUser();
		$user->setNamespace('myApp');
		$user->setExpiration(86400, FALSE);

		// Return Identity
		return new Identity($dbuser->realname, $roles);
	}
}
