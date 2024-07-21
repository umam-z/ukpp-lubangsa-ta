<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\Session;

interface SessionRepository
{
    public function save(Session $session) : Session;

    public function findById(string $id): ?Session;

    public function deleteAll() : void;

    public function deleteById(string $id) : void;
}
