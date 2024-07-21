<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Domain\Pendidikan;
use UmamZ\UkppLubangsa\Model\PendidikanAddRequest;
use UmamZ\UkppLubangsa\Model\PendidikanAddResponse;

interface PendidikanService 
{
    public function dataPendidikan(): array;

    public function addPetugas(PendidikanAddRequest $request) : PendidikanAddResponse;

    public function deletePendidikan(int $pendidikanId) : Pendidikan;
}
