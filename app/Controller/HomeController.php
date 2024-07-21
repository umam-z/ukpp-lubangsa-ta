<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Repository\Impl\ObatRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PasienRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PemeriksaanRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PendidikanRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\PetugasRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\SessionRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\UserRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\ObatServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PasienServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PemeriksaanServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\PetugasServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\SessionServiceImpl;
use UmamZ\UkppLubangsa\Service\ObatService;
use UmamZ\UkppLubangsa\Service\PasienService;
use UmamZ\UkppLubangsa\Service\PemeriksaanService;
use UmamZ\UkppLubangsa\Service\PetugasService;
use UmamZ\UkppLubangsa\Service\SessionService;

class HomeController{

    private SessionService $sessionService;
    private PasienService $pasienService;
    private PemeriksaanService $pemeriksaanService;
    private PetugasService $petugasService;
    private ObatService $obatService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepositoryImpl($connection);
        $sessionRepository = new SessionRepositoryImpl($connection);
        $pasienRepository = new PasienRepositoryImpl($connection);
        $pendidikanRepository = new PendidikanRepositoryImpl($connection);
        $pemeriksaanRepository = new PemeriksaanRepositoryImpl($connection);
        $petugasRepository = new PetugasRepositoryImpl($connection);
        $obatRepository = new ObatRepositoryImpl($connection);
        $this->sessionService = new SessionServiceImpl($sessionRepository, $userRepository);
        $this->pasienService = new PasienServiceImpl($pasienRepository, $pendidikanRepository);
        $this->pemeriksaanService = new PemeriksaanServiceImpl($pemeriksaanRepository, $pasienRepository);
        $this->petugasService = new PetugasServiceImpl($petugasRepository);
        $this->obatService = new ObatServiceImpl($obatRepository);
    }

    public function index() :  void
    {
        $user = $this->sessionService->current();

        if ($user == null) {
            View::render('/Home/login', [
                'title' => 'Login | UKPP',
                
            ]);
        } else {
            View::render('/Home/dashboard', [
                'title' => 'Home | UKPP',
                'jumlah' => [
                    'pasien' => $this->pasienService->count(),
                    'pemeriksaan' => $this->pemeriksaanService->count(),
                    'petugas' => $this->petugasService->count(),
                    'obat' => $this->obatService->count()
                ]
            ]);

        }
    }
}