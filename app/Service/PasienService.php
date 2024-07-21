<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Domain\Pasien;
use UmamZ\UkppLubangsa\Model\PasienAddRequest;
use UmamZ\UkppLubangsa\Model\PasienAddResponse;

interface PasienService 
{
  public function addPasien(PasienAddRequest $request): PasienAddResponse;

  public function delete(int $pasienId) : Pasien;

  public function findPasienPeriksa(int $pasienId) : Pasien;

  public function sendEmail(array $pasienAlamat) : void;

  public function count(): int;
}
