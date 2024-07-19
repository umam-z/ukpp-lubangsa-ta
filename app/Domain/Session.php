<?php

namespace UmamZ\UkppLubangsa\Domain;

class Session {
    public function __construct(
        private string $id,
        private int $userId
    )
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function setId(string $id) : void
    {
        $this->id = $id;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function setUserId(int $userId) : void
    {
        $this->userId = $userId;
    }

    public function getUserId() : int
    {
        return $this->userId;
    }
}