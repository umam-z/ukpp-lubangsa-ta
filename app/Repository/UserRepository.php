<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\User;

interface UserRepository
{
    public function save(User $user) : User;

    public function findById(int $id): ?User;
    
    public function findByUsername(string $username): ?User;

    public function deleteAll() : void;
}
