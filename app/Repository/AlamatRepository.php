<?php

namespace UmamZ\UkppLubangsa\Repository;

use PDO;
use UmamZ\UkppLubangsa\Domain\Alamat;

interface AlamatRepository
{
    public function save(Alamat $alamat) : Alamat;

    public function findById(int $pasienId): ?Alamat;

    public function findByPasienId(int $pasienId): ?Alamat;

    public function deleteById(int $pasienId) : void;

    public function getAlamatPasien() : array | false;

    public function findPasienAlamat(int $pasienId): array;
}