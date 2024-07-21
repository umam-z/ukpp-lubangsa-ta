<?php

namespace UmamZ\UkppLubangsa\Repository\Impl;

use UmamZ\UkppLubangsa\Domain\Obat;
use UmamZ\UkppLubangsa\Repository\ObatRepository;

class ObatRepositoryImpl implements ObatRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Obat $obat) : Obat
    {
        $statement = $this->connection->prepare('INSERT INTO obat(obat_id, obat, stock) VALUES (?, ?, ?)');
        $statement->execute([$obat->getId(), $obat->getObat(), $obat->getStock()]);
        return $obat;
    }

    public function update(Obat $obat) : Obat
    {
        $statement = $this->connection->prepare('UPDATE obat SET  obat = ?, stock = ? WHERE obat_id = ?');
        $statement->execute([$obat->getObat(), $obat->getStock(), $obat->getId()]);
        return $obat;
    }

    public function findById(int $obatId): ?Obat
    {
        $statement = $this->connection->prepare('SELECT obat_id, obat, stock FROM obat WHERE obat_id = ?');
        $statement->execute([$obatId]);

        try {
            if ($row = $statement->fetch()) {
                $obat = new Obat(
                    $row['obat_id'],
                    $row['obat'],
                    $row['stock']
                );
                
                return $obat;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(int $obatId) : void
    {
        $statement = $this->connection->prepare('DELETE FROM obat WHERE obat_id = ?');
        $statement->execute([$obatId]);
    }

    public function getAll() : array
    {
        $statement = $this->connection->prepare('SELECT obat_id, obat, stock FROM obat');
        $statement->execute();

        $result = [];

        foreach ($statement as $row) {
            $obat = new Obat(
                $row['obat_id'],
                $row['obat'],
                $row['stock']
            );

            $result[] = $obat;
        }
        return $result;
    }

    public function countAll() : int
    {
        $statement = $this->connection->prepare('SELECT count(*) as count FROM obat');
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        $jumlah = $row['count'];

        return $jumlah;
    }
}
