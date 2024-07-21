<?php

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Domain\Session;
use UmamZ\UkppLubangsa\Domain\User;

interface SessionService
{
    function create(int $userId) : Session;

    public function destroy(): void;

    public function current(): ?User;
}
