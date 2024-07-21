<?php

namespace UmamZ\UkppLubangsa\Service\Impl;

use UmamZ\UkppLubangsa\Domain\Session;
use UmamZ\UkppLubangsa\Domain\User;
use UmamZ\UkppLubangsa\Repository\SessionRepository;
use UmamZ\UkppLubangsa\Repository\UserRepository;
use UmamZ\UkppLubangsa\Service\SessionService;

class SessionServiceImpl  implements SessionService
{
    public static string $COOKIE_NAME = 'X-ZP-SESSION';
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

   
    function create(int $userId) : Session
    {
        $session = new Session(
            uniqid(),
            $userId
        );

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->getId(), time() + (60 * 60 * 24 * 30), "/");

        return $session;
    }
 

    public function destroy(): void
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }

    public function current(): ?User 
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if($session == null){
            return null;
        }

        return $this->userRepository->findById($session->getUserId());
    }

}
