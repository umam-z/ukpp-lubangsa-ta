<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\PetugasAddRequest;
use UmamZ\UkppLubangsa\Repository\Impl\PetugasRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\PetugasServiceImpl;
use UmamZ\UkppLubangsa\Service\PetugasService;

class PetugasController
{
    private PetugasService $petugasService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $petugasRepository = new PetugasRepositoryImpl($connection);
        $this->petugasService = new PetugasServiceImpl($petugasRepository);
    }

    public function petugas() : void
    {
        
        View::render('/Petugas/show-petugas', [
            'title' => 'Petugas | UKPP',
            'data' => $this->petugasService->dataPetugas()
        ]);
    }

    public function create() : void
    {
        $request = new PetugasAddRequest;
        $request->kontak = htmlspecialchars($_POST['kontak']);
        $request->nama = htmlspecialchars($_POST['nama']);
        try {
            $this->petugasService->addPetugas($request);
            View::redirect('/petugas');
        } catch (ValidationException $e) {
            View::render('/Petugas/show-petugas', [
                'title' => 'Petugas | UKPP',
                'data' => $this->petugasService->dataPetugas(),
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete(string $petugasId) : void
    {
        try {
            $this->petugasService->deletePetugas($petugasId);
            View::redirect('/petugas');
        } catch (\Exception $e) {
            View::render('/Petugas/show-petugas', [
                'title' => 'Petugas | UKPP',
                'data' => $this->petugasService->dataPetugas(),
                'error' => $e->getMessage()
            ]);
        }
    }
    
}
