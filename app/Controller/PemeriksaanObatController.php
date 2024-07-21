<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\PemeriksaanObatAddRequest;
use UmamZ\UkppLubangsa\Repository\Impl\ObatRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PasienRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PemeriksaanObatRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PemeriksaanRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\ObatServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PemeriksaanObatServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PemeriksaanServiceImpl;
use UmamZ\UkppLubangsa\Service\ObatService;
use UmamZ\UkppLubangsa\Service\PemeriksaanObatService;
use UmamZ\UkppLubangsa\Service\PemeriksaanService;

class PemeriksaanObatController{
    private PemeriksaanService $pemeriksaanService;
    private PemeriksaanObatService $pemeriksaanObatService;
    private ObatService $obatService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $pemeriksaanRepository = new PemeriksaanRepositoryImpl($connection);
        $pasienRepository = new PasienRepositoryImpl($connection);
        $obatRepository = new ObatRepositoryImpl($connection);
        $pemeriksaanObatRepository = new PemeriksaanObatRepositoryImpl($connection);
        $this->pemeriksaanService = new PemeriksaanServiceImpl($pemeriksaanRepository, $pasienRepository);
        $this->pemeriksaanObatService = new PemeriksaanObatServiceImpl($pemeriksaanObatRepository, $pemeriksaanRepository, $obatRepository);
        $this->obatService = new ObatServiceImpl($obatRepository);
    }

    public function pemeriksaanObat(string $pemeriksaanId): void
    {
        try {
            View::render('/Pemeriksaan/pemeriksaan-obat', 
            [
                'title' => 'Pemeriksaan Obat | UKPP',
                'data' => [
                    'pemeriksaan' => $this->pemeriksaanService->findPemeriksaan($pemeriksaanId),
                    'obatperiksa' => $this->pemeriksaanObatService->dataObatPeriksa($pemeriksaanId),
                    'obat' => $this->obatService->dataObat()
                ]
            ]);
        } catch (ValidationException $e) {
            View::render('/Pemeriksaan/pemeriksaan-obat', 
            [
                'title' => 'Pemeriksaan Obat | UKPP',
                'error' => $e->getMessage(),
            ]);
            
        }
    }

    public function addPemeriksaanObat(string $pemeriksaanId, string $obatId): void
    {
        $request = new PemeriksaanObatAddRequest;
        $request->obatId = (int)htmlspecialchars($obatId);
        $request->pemeriksaanId = (int)htmlspecialchars($pemeriksaanId);
        $request->qty = (int)htmlspecialchars($_POST['qty']);
        try {
            $this->pemeriksaanObatService->addObatPemeriksaan($request);
            View::redirect("/periksa/$pemeriksaanId/obat");
        } catch (ValidationException $e) {
            View::render('/Pemeriksaan/pemeriksaan-obat', [
                'title' => 'Pemeriksaan Obat | UKPP',
                'error' => $e->getMessage(),
                'data' => [
                    'pemeriksaan' => $this->pemeriksaanService->findPemeriksaan($pemeriksaanId),
                    'obatperiksa' => $this->pemeriksaanObatService->dataObatPeriksa($pemeriksaanId),
                    'obat' => $this->obatService->dataObat()
                ]
            ]);
        }
    }

    public function delete(string $pemeriksaanId, string $obatId): void
    {
        try {
            $this->pemeriksaanObatService->delete($pemeriksaanId, $obatId);
            View::redirect("/periksa/$pemeriksaanId/obat");
        } catch (ValidationException $e) {
            View::render('/Pemeriksaan/pemeriksaan-obat', [
                'title' => 'Pemeriksaan Obat | UKPP',
                'error' => $e->getMessage(),
                'data' => [
                    'pemeriksaan' => $this->pemeriksaanService->findPemeriksaan($pemeriksaanId),
                    'obatperiksa' => $this->pemeriksaanObatService->dataObatPeriksa($pemeriksaanId),
                    'obat' => $this->obatService->dataObat()
                ]
            ]);
        };
    }
}