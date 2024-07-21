<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\PendidikanAddRequest;
use UmamZ\UkppLubangsa\Repository\Impl\PendidikanRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\PendidikanServiceImpl;
use UmamZ\UkppLubangsa\Service\PendidikanService;

class PendidikanController
{
    private PendidikanService $pendidikanService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $pendidikanRepository = new PendidikanRepositoryImpl($connection);
        $this->pendidikanService = new PendidikanServiceImpl($pendidikanRepository);
    }

    public function pendidikan() : void
    {
        View::render('/Pendidikan/show-pendidikan', [
            'title' => 'Pendidikan Pasien | UKPP',
            'data' => $this->pendidikanService->dataPendidikan()
        ]);
    }
    
    public function create() : void
    {
        $request = new PendidikanAddRequest;
        $request->staff = htmlspecialchars($_POST['staff']);
        $request->email = htmlspecialchars($_POST['email']);
        $request->lembaga = htmlspecialchars($_POST['lembaga']);
        
        try {
            $this->pendidikanService->addPetugas($request);
            View::redirect('/pendidikan');
        } catch (ValidationException $e) {
            View::render('/Pendidikan/show-pendidikan', [
                'title' => 'Pendidikan Pasien | UKPP',
                'error' => $e->getMessage(),
                'data' => $this->pendidikanService->dataPendidikan()
            ]);
        }
    }

    public function delete(string $pendidikanId) : void
    {
        $this->pendidikanService->deletePendidikan($pendidikanId);
        View::redirect('/pendidikan');
    }
}
