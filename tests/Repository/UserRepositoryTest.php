<?php

namespace UmamZ\UkppLubangsa\Repository;

use PHPUnit\Framework\TestCase;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\User;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->sessionRepository = new SessionRepository($connection);
        
        $this->sessionRepository->deleteAll();

        $this->userRepository->deleteAll();
    }

    public function testSave(): void
    {
        $user = new User(mt_rand(), 'umam', 'tidakada');

        $response = $this->userRepository->save($user);
        
        $result = $this->userRepository->findById($response->getId());

        self::assertEquals($user->getId(), $result->getId());
        self::assertEquals($user->getNama(), $result->getNama());
        self::assertEquals($user->getPassword(), $result->getPassword());
    }

    public function testFindByIdNotFound()
    {
        $user = $this->userRepository->findById(7878);
        self::assertNull($user);
    }
    
    public function testFindByUsernameNotFound()
    {
        $user = $this->userRepository->findByUsername('tidakada');
        self::assertNull($user);
    }

    public function testFindByUsername()
    {
        $user = new User(mt_rand(), 'umam', 'tidakada');

        $response = $this->userRepository->save($user);

        $result = $this->userRepository->findByUsername($response->getNama());

        $this->assertEquals($user->getId(), $result->getId());
        $this->assertEquals($user->getNama(), $result->getNama());
        $this->assertEquals($user->getPassword(), $result->getPassword());
    }
}