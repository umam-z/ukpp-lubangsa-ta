<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Model\PemeriksaanObatAddRequest;
use UmamZ\UkppLubangsa\Model\PemeriksaanObatAddResponse;

interface PemeriksaanObatService 
{
    public function addObatPemeriksaan(PemeriksaanObatAddRequest $request) : PemeriksaanObatAddResponse;

    public function dataObatPeriksa(int $pemeriksaanId) : array;

    public function delete(int $pemeriksaanId, int $obatId): void;

    public function deleteByPemeriksaanId(int $pemeriksaanId): void;
}
