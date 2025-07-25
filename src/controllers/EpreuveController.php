<?php

namespace App\Controllers;

use Config\Database;
use App\Models\Epreuve;
use PDO;

class EpreuveController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // 1. Lister toutes les épreuves
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM epreuve");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $epreuves = [];
        foreach ($rows as $row) {
            $epreuves[] = new Epreuve($row['id'], $row['nom'], $row['type'], $row['id_examen']);
        }

        return $epreuves;
    }

    // 2. Enregistrer une épreuve
    public function new(Epreuve $epreuve): Epreuve {
        $stmt = $this->pdo->prepare("INSERT INTO epreuve (nom, type, id_examen) VALUES (?, ?, ?)");
        $stmt->execute([
            $epreuve->getNom(),
            $epreuve->getType(),
            $epreuve->getIdExamen()
        ]);
        $epreuve->setId($this->pdo->lastInsertId());
        return $epreuve;
    }

    // 3. Modifier une épreuve
    public function edit(int $id, Epreuve $epreuve): ?Epreuve {
        $stmt = $this->pdo->prepare("UPDATE epreuve SET nom=?, type=?, id_examen=? WHERE id=?");
        $stmt->execute([
            $epreuve->getNom(),
            $epreuve->getType(),
            $epreuve->getIdExamen(),
            $id
        ]);
        return $epreuve;
    }

    // 4. Supprimer une épreuve
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM epreuve WHERE id = ?");
        return $stmt->execute([$id]);
    }
}