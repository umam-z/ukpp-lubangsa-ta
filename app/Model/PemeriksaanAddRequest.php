<?php 

namespace UmamZ\UkppLubangsa\Model;

class PemeriksaanAddRequest 
{
    public null | string | int $petugasId = null;
    public null | string | int $pasienId = null;
    public null | string | int $tensi = null;
    public null | string | int $suhu = null;
    public? string $keluhan = null;
    public? string $diagnos = null;
}