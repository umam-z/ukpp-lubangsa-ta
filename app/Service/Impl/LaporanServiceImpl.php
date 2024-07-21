<?php 

namespace UmamZ\UkppLubangsa\Service\Impl;

use UmamZ\UkppLubangsa\Repository\LaporanRepository;
use UmamZ\UkppLubangsa\Service\LaporanService;

class LaporanServiceImpl implements LaporanService
{
    private LaporanRepository $laporanRepository;

    public function __construct(LaporanRepository $laporanRepository)
    {
        $this->laporanRepository = $laporanRepository;
    }

    public function filterDate(string $dari, string $sampai): array
    {
        return $this->laporanRepository->getDateFilter($dari, $sampai);
    }
}
