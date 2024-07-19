<?php 

namespace UmamZ\UkppLubangsa\Domain;

class Pendidikan{
    public function __construct(
        private int $id,
        private string $lembaga,
        private string $email,
        private string $staff
    )
    {
        $this->id = $id;
        $this->lembaga = $lembaga;
        $this->email = $email;
        $this->staff = $staff;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setLembaga(string $lembaga) : void
    {
        $this->lembaga = $lembaga;
    }

    public function getLembaga() : string
    {
        return $this->lembaga;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getEmail() : string
    {
        return $this->email;
    
    }

    public function setStaff(string $staff) : void
    {
        $this->staff = $staff;
    }

    public function getStaff() : string
    {
        return $this->staff;
    }
}
