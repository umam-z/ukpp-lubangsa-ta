<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\Petugas;

interface PetugasRepository
{
    public function save(Petugas $petugas) : Petugas;

    public function findById(int $id): ?Petugas;

    public function findByNama(string $nama): ?Petugas;

    public function deleteById(string $petugasId) : void;

    public function getAll() : array;

    public function countAll() : int;
}
