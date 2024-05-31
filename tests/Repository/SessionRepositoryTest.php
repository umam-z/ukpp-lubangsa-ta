<?php

namespace UmamZ\UkppLubangsa\Repository;

use PHPUnit\Framework\TestCase;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\Session;
use UmamZ\UkppLubangsa\Domain\User;

class SessionRepositoryTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->sessionRepository = new SessionRepository($connection);
        $this->userRepository = new UserRepository($connection);
        
        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User;
        $user->id = 123;
        $user->nama = 'fulan';
        $user->password = 'tidakada';
        $this->userRepository->save($user);
    }
    
    public function testSave() : void
    {
        $session = new Session;
        $session->id = uniqid();
        $session->userId = 123;
        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);


        $this->assertEquals($session->id, $result->id);
        $this->assertEquals($session->userId, $result->userId);
    }

    public function testDeleteByIdSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = 123;

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->userId, $result->userId);

        $this->sessionRepository->deleteById($session->id);

        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->sessionRepository->findById('notfound');
        self::assertNull($result);
    }
}