<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\ObatAddRequest;
use UmamZ\UkppLubangsa\Model\ObatStockUpdateRequest;
use UmamZ\UkppLubangsa\Repository\ObatRepository;
use UmamZ\UkppLubangsa\Service\ObatService;

class ObatController
{
    private ObatService $obatService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $obatRepository = new ObatRepository($connection);
        $this->obatService = new ObatService($obatRepository);
    }

    public function obat(): void
    {
        View::render('/Obat/show-obat', [
            'title' => 'Obat | UKPP',
            'data' => $this->obatService->dataObat()
        ]);
    }
    
    public function create(): void
    {
        $request = new ObatAddRequest;
        $request->obat = $_POST['obat'];
        $request->stock = $_POST['stock'];
        try {
            $this->obatService->addObat($request);
            View::redirect('/obat');
        } catch (ValidationException $e) {
            View::render('/Obat/show-obat', [
                'title' => 'Obat | UKPP',
                'error' => $e->getMessage(),
                'data' => $this->obatService->dataObat()
            ]);
        }
    }

    public  function delete(string $obatId) : void
    {
        try {
            $this->obatService->delete($obatId);
            View::redirect('/obat');
        } catch (ValidationException $e) {
            View::render('/Obat/show-obat', [
                'title' => 'Obat | UKPP',
                'error' => $e->getMessage(),
                'data' => $this->obatService->dataObat()
            ]);
        }
    }

    public function updateStock(string $obatId) : void
    {
        try {
            $obat = $this->obatService->findObat($obatId); 
            view::render('/Obat/edit-stock',[
                'title' => 'Stock Obat | UKPP',
                'data' => $obat
            ]);
        } catch (ValidationException $e) {
            view::render('/Obat/edit-stock',[
                'title' => 'Stock Obat | UKPP',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function postUpdateStock (string $obatId) : void
    {
        $request = new ObatStockUpdateRequest;
        $request->id = $obatId;
        $request->stock = $_POST['stock'];

        try {
            $this->obatService->updateStock($request);
            View::redirect('/obat');
        } catch (ValidationException $e) {
            view::render('/Obat/edit-stock',[
                'title' => 'Stock Obat | UKPP',
                'error' => $e->getMessage()
            ]);   
        }
    }
}
