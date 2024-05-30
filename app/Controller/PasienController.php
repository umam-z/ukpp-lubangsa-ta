<?php 

namespace UmamZ\UkppLubangsa\Controller;

use Exception;
use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\AlamatPasienAddRequest;
use UmamZ\UkppLubangsa\Model\PasienAddRequest;
use UmamZ\UkppLubangsa\Repository\AlamatRepository;
use UmamZ\UkppLubangsa\Repository\ObatRepository;
use UmamZ\UkppLubangsa\Repository\PasienRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanObatRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanRepository;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;
use UmamZ\UkppLubangsa\Service\AlamatService;
use UmamZ\UkppLubangsa\Service\PasienService;
use UmamZ\UkppLubangsa\Service\PemeriksaanObatService;
use UmamZ\UkppLubangsa\Service\PemeriksaanService;
use UmamZ\UkppLubangsa\Service\PendidikanService;

class PasienController
{
    private PasienService $pasienService;
    private AlamatService $alamatService;
    private PendidikanService $pendidikanService;
    private PemeriksaanObatService $pemeriksaanObatService;
    private PemeriksaanService $pemeriksaanService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $pasienRepository = new PasienRepository($connection);
        $pendidikanRepository = new PendidikanRepository($connection);
        $alamatRepository = new AlamatRepository($connection);
        $obatRepository = new ObatRepository($connection);
        $pemeriksaanObatRepository = new PemeriksaanObatRepository($connection);
        $pemeriksaanRepository = new PemeriksaanRepository($connection);
        $this->pendidikanService = new PendidikanService($pendidikanRepository);
        $this->pasienService = new PasienService($pasienRepository, $pendidikanRepository);
        $this->alamatService = new AlamatService($alamatRepository, $pasienRepository);
        $this->pemeriksaanService = new PemeriksaanService($pemeriksaanRepository, $pasienRepository);
        $this->pemeriksaanObatService = new PemeriksaanObatService($pemeriksaanObatRepository , $pemeriksaanRepository, $obatRepository);

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
        $request->nama = $_POST['nama'];
        $request->nis = $_POST['nis'];
        $request->pedidikanId = $_POST['pendidikan'] ?? 0 ;
        try {
            $response = $this->pasienService->addPasien($request);
            $request = new AlamatPasienAddRequest;
            $request->pasienId = $response->pasien->id;
            $request->blok = $_POST['blok'];
            $request->no = $_POST['no'];
            $request->desa = $_POST['desa'];
            $request->kecamatan = $_POST['kecamatan'];
            $request->kabupaten = $_POST['kabupaten'];
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
            $this->pasienService->delete($pasienId);
            View::redirect('/pasien');
        } catch (\Exception $e) {
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
            $result = $this->alamatService->dataSurat($pasienId);
            $this->pasienService->sendEmail($result);
            View::redirect('/');
        } catch (ValidationException $e) {
           
        }
    }
}