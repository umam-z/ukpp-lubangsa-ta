<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\PemeriksaanAddRequest;
use UmamZ\UkppLubangsa\Repository\ObatRepository;
use UmamZ\UkppLubangsa\Repository\PasienRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanObatRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanRepository;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;
use UmamZ\UkppLubangsa\Repository\PetugasRepository;
use UmamZ\UkppLubangsa\Service\PasienService;
use UmamZ\UkppLubangsa\Service\PemeriksaanObatService;
use UmamZ\UkppLubangsa\Service\PemeriksaanService;
use UmamZ\UkppLubangsa\Service\PetugasService;

class PemeriksaanController
{
    private PemeriksaanService $pemeriksaanService;
    private PetugasService $petugasService;
    private PasienService $pasienService;
    private PemeriksaanObatService $pemeriksaanObatService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $pasienRepository = new PasienRepository($connection);
        $pemeriksaanRepository = new PemeriksaanRepository($connection);
        $petugasRepository = new PetugasRepository($connection);
        $obatRepository = new ObatRepository($connection);
        $pendidikanRepository = new PendidikanRepository($connection);
        $pemeriksaanObatRepository = new PemeriksaanObatRepository($connection);
        $this->pemeriksaanService = new PemeriksaanService($pemeriksaanRepository, $pasienRepository);
        $this->petugasService = new PetugasService($petugasRepository);
        $this->pasienService = new PasienService($pasienRepository, $pendidikanRepository);
        $this->pemeriksaanObatService = new PemeriksaanObatService($pemeriksaanObatRepository, $pemeriksaanRepository, $obatRepository);
    }

    public function pemeriksaan(string $pasienId) : void
    { 
        try {
            View::render('/Pemeriksaan/show-pemeriksaan', [
                'title' => 'Pemeriksaan | UKPP',
                'data' => [
                    'pemeriksaan' => $this->pemeriksaanService->dataPemeriksaan($pasienId),
                    'petugas' => $this->petugasService->dataPetugas(),
                    'pasienperiksa' => $this->pasienService->findPasienPeriksa($pasienId)
                ]
            ]);
        } catch (ValidationException $e) {
            View::render('/Pemeriksaan/show-pemeriksaan', [
                'title' => 'Pemeriksaan | UKPP',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function create(string $pasienId): void
    {
        $request = new PemeriksaanAddRequest;
        $request->diagnos = htmlspecialchars($_POST['diagnos']);
        $request->keluhan = htmlspecialchars($_POST['keluhan']);
        $request->pasienId = (int)htmlspecialchars($pasienId);
        $request->petugasId = (int)htmlspecialchars($_POST['petugas']);
        $request->suhu = (int)htmlspecialchars($_POST['suhu']);
        $request->tensi = (int)htmlspecialchars($_POST['tensi']);
        try {
            $this->pemeriksaanService->addPemeriksaan($request);
            View::redirect("/pasien/$pasienId/periksa");
        } catch (ValidationException $e) {
            View::render('/Pemeriksaan/show-pemeriksaan', [
                'title' => 'Pemeriksaan | UKPP',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete(string $pasienId, string $pemeriksaanId) : void
    {
        try {
            $this->pemeriksaanObatService->deleteByPemeriksaanId($pemeriksaanId);
            $this->pemeriksaanService->delete($pemeriksaanId);
            View::redirect("/pasien/$pasienId/periksa");
        } catch (ValidationException $e) {
            View::render('/Pemeriksaan/show-pemeriksaan', [
                'title' => 'Pemeriksaan | UKPP',
                'error' => $e->getMessage()
            ]);
        }
    }
}