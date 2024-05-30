<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\Obat;

class ObatRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Obat $obat) : Obat
    {
        $statement = $this->connection->prepare('INSERT INTO obat(obat_id, obat, stock) VALUES (?, ?, ?)');
        $statement->execute([$obat->id, $obat->obat, $obat->stock]);
        return $obat;
    }

    public function update(Obat $obat) : Obat
    {
        $statement = $this->connection->prepare('UPDATE obat SET  obat = ?, stock = ? WHERE obat_id = ?');
        $statement->execute([$obat->obat, $obat->stock, $obat->id]);
        return $obat;
    }

    public function findById(int $obatId): ?Obat
    {
        $statement = $this->connection->prepare('SELECT obat_id, obat, stock FROM obat WHERE obat_id = ?');
        $statement->execute([$obatId]);

        try {
            if ($row = $statement->fetch()) {
                $petugas = new Obat;
                $petugas->id = $row['obat_id'];
                $petugas->obat = $row['obat'];
                $petugas->stock = $row['stock'];
                
                return $petugas;
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
            $obat = new Obat();
            $obat->id = $row['obat_id'];
            $obat->obat = $row['obat'];
            $obat->stock = $row['stock'];

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
