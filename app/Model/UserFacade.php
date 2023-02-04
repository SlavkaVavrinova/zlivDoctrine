<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Nette;
use Nette\Security\Passwords;


/**
 * Users management.
 */
final class UserFacade implements Nette\Security\Authenticator
{
	use Nette\SmartObject;

	public const PasswordMinLength = 7;

	private const
		TableName = 'users',
		ColumnId = 'id',
		ColumnName = 'username',
		ColumnPasswordHash = 'password'
//      ,
//		ColumnEmail = 'email',
//		ColumnRole = 'role'
    ;
    private EntityManagerInterface $em;
    private Passwords $passwords;


    public function __construct(EntityManagerInterface $em, Passwords $passwords)
	{
		$this->em = $em;
		$this->passwords = $passwords;
	}


	/**
	 * Performs an authentication.
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(string $username, string $password): Nette\Security\SimpleIdentity
	{
		$row = $this->em->getRepository(User::class)
			->findOneBy([self::ColumnName => $username])
			;
        bdump($row);

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		} elseif (!$this->passwords->verify($password, $row->getPassword())) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif ($this->passwords->needsRehash($row->getPassword())) {
			$row->update([
				self::ColumnPasswordHash => $this->passwords->hash($password),
			]);
		}

        $userArray = [];
        foreach ($row as $key => $value) {
            $userArray[$key] = $value;
        }


		unset($userArray[self::ColumnPasswordHash]);
        return new Nette\Security\SimpleIdentity($row->getId(), null, $userArray);
	}


	/**
	 * Adds new user.
	 * @throws DuplicateNameException
	 */
	public function add(string $username, string $password): void
	{
		try {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwords->hash($password));

            $this->em->persist($user);
            $this->em->flush();
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}
}



class DuplicateNameException extends \Exception
{
}
