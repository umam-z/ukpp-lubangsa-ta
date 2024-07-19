<?php

namespace UmamZ\UkppLubangsa\Domain;

class User {
    public function __construct(
        private int $id,
        private string $nama,
        private string $password
    )
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->password = $password;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setNama(string $nama) : void
    {
        $this->nama = $nama;
    }

    public function getNama() : string
    {
        return $this->nama;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function getPassword() : string
    {
        return $this->password;
    }
}