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

        $user = new User(123,'fulan','tidakada');
        $this->userRepository->save($user);
    }
    
    public function testSave() : void
    {
        $session = new Session(uniqid(), 123);

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->getId());


        $this->assertEquals($session->getId(), $result->getId());
        $this->assertEquals($session->getUserId(), $result->getUserId());
    }

    public function testDeleteByIdSuccess()
    {
        $session = new Session(uniqid(), 123);

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->getId());
        self::assertEquals($session->getId(), $result->getId());
        self::assertEquals($session->getUserId(), $result->getUserId());

        $this->sessionRepository->deleteById($session->getId());

        $result = $this->sessionRepository->findById($session->getId());
        self::assertNull($result);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->sessionRepository->findById('notfound');
        self::assertNull($result);
    }
}