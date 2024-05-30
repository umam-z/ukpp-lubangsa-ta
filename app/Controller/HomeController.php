<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Repository\ObatRepository;
use UmamZ\UkppLubangsa\Repository\PasienRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanRepository;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;
use UmamZ\UkppLubangsa\Repository\PetugasRepository;
use UmamZ\UkppLubangsa\Repository\SessionRepository;
use UmamZ\UkppLubangsa\Repository\UserRepository;
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
        $userRepository = new UserRepository($connection);
        $sessionRepository = new SessionRepository($connection);
        $pasienRepository = new PasienRepository($connection);
        $pendidikanRepository = new PendidikanRepository($connection);
        $pemeriksaanRepository = new PemeriksaanRepository($connection);
        $petugasRepository = new PetugasRepository($connection);
        $obatRepository = new ObatRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
        $this->pasienService = new PasienService($pasienRepository, $pendidikanRepository);
        $this->pemeriksaanService = new PemeriksaanService($pemeriksaanRepository, $pasienRepository);
        $this->petugasService = new PetugasService($petugasRepository);
        $this->obatService = new ObatService($obatRepository);
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