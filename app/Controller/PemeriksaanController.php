<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\PemeriksaanAddRequest;
use UmamZ\UkppLubangsa\Repository\Impl\ObatRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PasienRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PemeriksaanObatRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PemeriksaanRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PendidikanRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PetugasRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\PemeriksaanRepository;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;
use UmamZ\UkppLubangsa\Repository\PetugasRepository;
use UmamZ\UkppLubangsa\Service\Impl\PasienServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PemeriksaanObatServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PemeriksaanServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PetugasServiceImpl;
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
        $pasienRepository = new PasienRepositoryImpl($connection);
        $pemeriksaanRepository = new PemeriksaanRepositoryImpl($connection);
        $petugasRepository = new PetugasRepositoryImpl($connection);
        $obatRepository = new ObatRepositoryImpl($connection);
        $pendidikanRepository = new PendidikanRepositoryImpl($connection);
        $pemeriksaanObatRepository = new PemeriksaanObatRepositoryImpl($connection);
        $this->pemeriksaanService = new PemeriksaanServiceImpl($pemeriksaanRepository, $pasienRepository);
        $this->petugasService = new PetugasServiceImpl($petugasRepository);
        $this->pasienService = new PasienServiceImpl($pasienRepository, $pendidikanRepository);
        $this->pemeriksaanObatService = new PemeriksaanObatServiceImpl($pemeriksaanObatRepository, $pemeriksaanRepository, $obatRepository);
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