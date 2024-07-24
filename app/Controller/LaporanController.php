<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\LaporanFindRequest;
use UmamZ\UkppLubangsa\Repository\Impl\LaporanRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\LaporanServiceImpl;
use UmamZ\UkppLubangsa\Service\LaporanService;

class LaporanController
{
    private LaporanService $laporanService;

    public function __construct()
    {
        $laporanRepository = new LaporanRepositoryImpl(Database::getConnection());
        $this->laporanService = new LaporanServiceImpl($laporanRepository);
    }
    public function laporan() : void
    {
        View::render('/Laporan/show-laporan', [
            'title'=> 'Laporan | UKPP'
        ]);
    } 
    
    public function postLaporan() : void
    {
        $request = new LaporanFindRequest;
        $request->dari = htmlspecialchars($_POST['dari']);
        $request->sampai= htmlspecialchars($_POST['sampai']);
        try {
            View::render('/Laporan/show-laporan', [
                'title'=> 'Laporan | UKPP',
                'data' => $this->laporanService->filterDate($request),
                'range' => [
                    'awal' => $request->dari,
                    'akhir' => $request->sampai
                ]
            ]);
        } catch (ValidationException $e) {
            View::render('/Laporan/show-laporan', [
                'title'=> 'Laporan | UKPP',
                'error' => 'terjadi kesalahan'
            ]);
        }
    }
}