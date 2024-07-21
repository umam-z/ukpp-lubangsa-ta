<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Model\PetugasAddRequest;
use UmamZ\UkppLubangsa\Model\PetugasAddResponse;

interface PetugasService 
{
    public function dataPetugas(): array;

    public function addPetugas(PetugasAddRequest $request) : PetugasAddResponse;

    public function deletePetugas(int $petugasId) : void;

    public function count() : int;
}
