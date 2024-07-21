<?php

namespace UmamZ\UkppLubangsa\Repository;

use PDO;
use UmamZ\UkppLubangsa\Domain\Pemeriksaan;

interface PemeriksaanRepository
{
    public function save(Pemeriksaan $pemeriksaan) : Pemeriksaan;

    public function findById(int $pemeriksaanId): ?Pemeriksaan;

    public function getPasienPeriksa(int $pasienId) : array | false;

    public function deleteById(int $pemeriksaanId): void;

    public function countAll() : int;
}
