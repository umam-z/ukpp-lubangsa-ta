<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Model\LaporanFindRequest;

interface LaporanService 
{
    public function filterDate(LaporanFindRequest $request): array;
}
