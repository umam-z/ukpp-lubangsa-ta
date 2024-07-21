<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Domain\Pasien;
use UmamZ\UkppLubangsa\Model\AlamatPasienAddRequest;
use UmamZ\UkppLubangsa\Model\AlamatPasienAddResponse;

interface AlamatService 
{
    public function addAlamatPasien(AlamatPasienAddRequest $request) : AlamatPasienAddResponse;
    
    public function dataAlamatPasien() : array;

    public function delete(int $pasienId) : Pasien;

    public function dataSurat(int $pasienId): array;
}
