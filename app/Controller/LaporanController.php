<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
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
        $tglAwal = htmlspecialchars($_POST['dari']);
        $tglAkhir = htmlspecialchars($_POST['sampai']);
        try {
            View::render('/Laporan/show-laporan', [
                'title'=> 'Laporan | UKPP',
                'data' => $this->laporanService->filterDate($tglAwal, $tglAkhir),
                'range' => [
                    'awal' => $tglAwal,
                    'akhir' => $tglAkhir
                ]
            ]);
        } catch (ValidationException $th) {
            
        }
    }
}