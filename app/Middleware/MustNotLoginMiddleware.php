<?php

namespace UmamZ\UkppLubangsa\Middleware;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Repository\Impl\SessionRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\UserRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\SessionServiceImpl;
use UmamZ\UkppLubangsa\Service\SessionService;

class MustNotLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepositoryImpl($connection);
        $userRepository = new UserRepositoryImpl($connection);
        $this->sessionService = new SessionServiceImpl($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user != null) {
            View::redirect('/');
        }
    }
}
