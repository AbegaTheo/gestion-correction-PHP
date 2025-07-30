<?php
namespace App\Controllers;

use Config\Database;
use App\Models\Correction;
use PDO;

class CorrectionController {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    //* 1. Lister toutes les corrections
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM correction");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $corrections = [];
        foreach ($rows as $row) {
            $corrections[] = new Correction(
                (int)$row['id_professeur'],
                (int)$row['id_epreuve'],
                $row['date'],
                (int)$row['nbr_copie'],
                (int)$row['id']
            );
        }

        return $corrections;
    }

    //* 2. Enregistrer une correction
    public function new(Correction $correction): Correction {
        $stmt = $this->pdo->prepare("INSERT INTO correction (id_professeur, id_epreuve, date, nbr_copie) VALUES (:id_professeur, :id_epreuve, :date, :nbr_copie)");
        $stmt->execute([
            'id_professeur' => $correction->getIdProfesseur(),
            'id_epreuve'    => $correction->getIdEpreuve(),
            'date'          => $correction->getDate(),
            'nbr_copie'     => $correction->getNbrCopie()
        ]);
        $correction->setId((int)$this->pdo->lastInsertId());
        return $correction;
    }

    //* 3. Modifier une correction
    public function edit(int $id, Correction $correction): ?Correction {
        $stmt = $this->pdo->prepare("UPDATE correction SET id_professeur= :id_professeur, id_epreuve= :id_epreuve, date= :date, nbr_copie= :nbr_copie WHERE id= :id");
        $stmt->execute([
            'id_professeur' => $correction->getIdProfesseur(),
            'id_epreuve'    => $correction->getIdEpreuve(),
            'date'          => $correction->getDate(),
            'nbr_copie'     => $correction->getNbrCopie(),
            'id'            => $id
        ]);
        $correction->setId($id);
        return $correction;
    }

    //* 4. Supprimer une correction
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM correction WHERE id = :id");
        return $stmt->execute([$id]);
    }

    //* 5. Trouver une correction par ID
    public function find(int $id): ?Correction {
        $stmt = $this->pdo->prepare("SELECT * FROM correction WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return (new Correction())->formArray($row);
    }
}
