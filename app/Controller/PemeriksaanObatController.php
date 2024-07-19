<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\PemeriksaanObatAddRequest;
use UmamZ\UkppLubangsa\Repository\ObatRepository;
use UmamZ\UkppLubangsa\Repository\PasienRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanObatRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanRepository;
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
        $pemeriksaanRepository = new PemeriksaanRepository($connection);
        $pasienRepository = new PasienRepository($connection);
        $obatRepository = new ObatRepository($connection);
        $pemeriksaanObatRepository = new PemeriksaanObatRepository($connection);
        $this->pemeriksaanService = new PemeriksaanService($pemeriksaanRepository, $pasienRepository);
        $this->pemeriksaanObatService = new PemeriksaanObatService($pemeriksaanObatRepository, $pemeriksaanRepository, $obatRepository);
        $this->obatService = new ObatService($obatRepository);
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