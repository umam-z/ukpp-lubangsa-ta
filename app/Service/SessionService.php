<?php

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Domain\Session;
use UmamZ\UkppLubangsa\Domain\User;
use UmamZ\UkppLubangsa\Repository\SessionRepository;
use UmamZ\UkppLubangsa\Repository\UserRepository;

class SessionService
{
    public static string $COOKIE_NAME = 'X-ZP-SESSION';
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

   
    function create(string $userId) : Session {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = $userId;

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->id, time() + (60 * 60 * 24 * 30), "/");

        return $session;
    }
 

    public function destroy() {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }

    public function current(): ?User {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if($session == null){
            return null;
        }

        return $this->userRepository->findById($session->userId);
    }

}
