<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\Pendidikan;

interface PendidikanRepository
{
    public function save(Pendidikan $pendidikan) : Pendidikan;

    public function findById(int $pendidikanId): ?Pendidikan;

    public function deleteById(int $pendidikanId) : void;

    public function getAll() : array;
}
