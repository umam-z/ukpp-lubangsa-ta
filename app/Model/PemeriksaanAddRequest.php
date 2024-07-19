<?php 

namespace UmamZ\UkppLubangsa\Model;

class PemeriksaanAddRequest 
{
    public? int $petugasId = null;
    public? int $pasienId = null;
    public? int $tensi = null;
    public? int $suhu = null;
    public? string $keluhan = null;
    public? string $diagnos = null;
}