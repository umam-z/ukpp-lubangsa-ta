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
        $user = new User;
        $user->id = mt_rand();
        $user->nama = 'umam';
        $user->password = 'tidakada';

        $response = $this->userRepository->save($user);
        
        $result = $this->userRepository->findById($response->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->nama, $result->nama);
        self::assertEquals($user->password, $result->password);
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
        $user = new User;
        $user->id = mt_rand();
        $user->nama = 'umam';
        $user->password = 'tidakada';

        $response = $this->userRepository->save($user);

        $result = $this->userRepository->findByUsername($response->nama);

        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->nama, $result->nama);
        $this->assertEquals($user->password, $result->password);
    }
}