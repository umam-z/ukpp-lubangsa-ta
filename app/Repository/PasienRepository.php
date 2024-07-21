<?php

namespace UmamZ\UkppLubangsa\Repository;

use PDO;
use UmamZ\UkppLubangsa\Domain\Pasien;

interface PasienRepository
{
    public function save(Pasien $pasien) : Pasien;

    public function findById(int $pasienId): ?Pasien;

    public function deleteById(int $pasienId) : void;

    public function countAll() : int;
}
