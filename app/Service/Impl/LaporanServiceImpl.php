<?php 

namespace UmamZ\UkppLubangsa\Service\Impl;

use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\LaporanFindRequest;
use UmamZ\UkppLubangsa\Repository\LaporanRepository;
use UmamZ\UkppLubangsa\Service\LaporanService;

class LaporanServiceImpl implements LaporanService
{
    private LaporanRepository $laporanRepository;

    public function __construct(LaporanRepository $laporanRepository)
    {
        $this->laporanRepository = $laporanRepository;
    }

    public function filterDate(LaporanFindRequest $request): array
    {
        ValidationUtil::validate($request);
        return $this->laporanRepository->getDateFilter($request->dari, $request->sampai);
    }
}
