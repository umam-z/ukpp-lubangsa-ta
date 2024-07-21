<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Domain\Pemeriksaan;
use UmamZ\UkppLubangsa\Model\PemeriksaanAddRequest;
use UmamZ\UkppLubangsa\Model\PemeriksaanAddResponse;

interface PemeriksaanService 
{
    public function dataPemeriksaan(int $pasienId): array;

    public function addPemeriksaan(PemeriksaanAddRequest $request) : PemeriksaanAddResponse;

    public function delete(int $pemeriksaanId): ?Pemeriksaan;
    
    public function findPemeriksaan(int $pemeriksaanId): Pemeriksaan;

    public function count() : int;
}
