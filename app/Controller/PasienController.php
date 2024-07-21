<?php 

namespace UmamZ\UkppLubangsa\Controller;

use Exception;
use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\AlamatPasienAddRequest;
use UmamZ\UkppLubangsa\Model\PasienAddRequest;
use UmamZ\UkppLubangsa\Repository\Impl\AlamatRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PasienRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PendidikanRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\PasienRepository;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;
use UmamZ\UkppLubangsa\Service\AlamatService;
use UmamZ\UkppLubangsa\Service\Impl\AlamatServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PasienServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PendidikanServiceImpl;
use UmamZ\UkppLubangsa\Service\PasienService;
use UmamZ\UkppLubangsa\Service\PendidikanService;

class PasienController
{
    private PasienService $pasienService;
    private AlamatService $alamatService;
    private PendidikanService $pendidikanService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $pasienRepository = new PasienRepositoryImpl($connection);
        $pendidikanRepository = new PendidikanRepositoryImpl($connection);
        $alamatRepository = new AlamatRepositoryImpl($connection);
        $this->pendidikanService = new PendidikanServiceImpl($pendidikanRepository);
        $this->pasienService = new PasienServiceImpl($pasienRepository, $pendidikanRepository);
        $this->alamatService = new AlamatServiceImpl($alamatRepository, $pasienRepository);

    }

    public function pasien() : void
    {
        View::render('/Pasien/show-pasien', [
            'title' => 'Pasien | UKPP',
            'data' => [
                'pasien' => $this->alamatService->dataAlamatPasien(),
                'pendidikan' => $this->pendidikanService->dataPendidikan()
            ]
        ]);
    }

    public function create() : void
    {
        $request = new PasienAddRequest;
        $request->nama = htmlspecialchars($_POST['nama']);
        $request->nis = (int) htmlspecialchars($_POST['nis']);
        $request->pedidikanId = (int) htmlspecialchars($_POST['pendidikan'] ?? 0);
        try {
            $response = $this->pasienService->addPasien($request);
            $request = new AlamatPasienAddRequest;
            $request->pasienId = $response->pasien->getId();
            $request->blok = htmlspecialchars($_POST['blok']);
            $request->no = (int)htmlspecialchars($_POST['no']);
            $request->desa = htmlspecialchars($_POST['desa']);
            $request->kecamatan = htmlspecialchars($_POST['kecamatan']);
            $request->kabupaten = htmlspecialchars($_POST['kabupaten']);
            $this->alamatService->addAlamatPasien($request);
            View::redirect('/pasien');
        } catch (ValidationException | Exception $e) {
            View::render('/Pasien/show-pasien', [
                'title' => 'Pasien | UKPP',
                'error' => $e->getMessage(),
                'data' => [
                    'pasien' => $this->alamatService->dataAlamatPasien(),
                    'pendidikan' => $this->pendidikanService->dataPendidikan()
                ]
            ]);
        }
    }

    public function delete(string $pasienId) : void
    {
        try {
            $this->pasienService->delete((int)htmlspecialchars($pasienId));
            View::redirect('/pasien');
        } catch (ValidationException $e) {
            View::render('/Pasien/show-pasien', [
                'title' => 'Pasien | UKPP',
                'error' => $e->getMessage(),
                'data' => [
                    'pasien' => $this->alamatService->dataAlamatPasien(),
                    'pendidikan' => $this->pendidikanService->dataPendidikan()
                ]
            ]);
        }
    }

    public function surat(string $pasienId): void
    {
        try {
            $result = $this->alamatService->dataSurat((int)htmlspecialchars($pasienId));
            $this->pasienService->sendEmail($result);
            View::redirect('/');
        } catch (ValidationException $e) {
           
        }
    }
}