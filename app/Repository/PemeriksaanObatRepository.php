<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\PemeriksaanObat;

interface PemeriksaanObatRepository
{
    public function save(PemeriksaanObat $pemeriksaanObat) : PemeriksaanObat;

    public function getPeriksaObat(int $pemeriksaanId) : array | false;

    public function findByDuplicate(int $pemeriksaanId, int $obatId): ? PemeriksaanObat;

    public function delete(int $pemeriksaanId, int $obatId):  void;

    public function findByPemeriksaanId(int $pemeriksaanId): ?PemeriksaanObat;
    
    public function deleteByPemeriksaanId(int $pemeriksaanId): void;
}
