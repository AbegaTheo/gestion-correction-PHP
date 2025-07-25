<?php

namespace App\Controllers;

use Config\Database;
use App\Models\Correction;
use PDO;

class CorrectionController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // 1. Lister toutes les corrections
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM correction");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $corrections = [];
        foreach ($rows as $row) {
            $corrections[] = new Correction(
                $row['id'],
                $row['id_professeur'],
                $row['id_epreuve'],
                $row['date'],
                $row['nbr_copie']
            );
        }

        return $corrections;
    }

    // 2. Enregistrer une correction
    public function new(Correction $correction): Correction {
        $stmt = $this->pdo->prepare("INSERT INTO correction (id_professeur, id_epreuve, date, nbr_copie) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $correction->getIdProfesseur(),
            $correction->getIdEpreuve(),
            $correction->getDate(),
            $correction->getNbrCopie()
        ]);
        $correction->setId($this->pdo->lastInsertId());
        return $correction;
    }

    // 3. Modifier une correction
    public function edit(int $id, Correction $correction): ?Correction {
        $stmt = $this->pdo->prepare("UPDATE correction SET id_professeur=?, id_epreuve=?, date=?, nbr_copie=? WHERE id=?");
        $stmt->execute([
            $correction->getIdProfesseur(),
            $correction->getIdEpreuve(),
            $correction->getDate(),
            $correction->getNbrCopie(),
            $id
        ]);
        return $correction;
    }

    // 4. Supprimer une correction
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM correction WHERE id = ?");
        return $stmt->execute([$id]);
    }
}