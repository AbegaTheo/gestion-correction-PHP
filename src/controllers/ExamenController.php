<?php

namespace App\Controllers;

use Config\Database;
use App\Models\Examen;
use PDO;

class ExamenController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // 1. Lister tous les examens
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM examen");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $examens = [];
        foreach ($rows as $row) {
            $examens[] = new Examen($row['id'], $row['nom']);
        }

        return $examens;
    }

    // 2. Enregistrer un examen
    public function new(Examen $examen): Examen {
        $stmt = $this->pdo->prepare("INSERT INTO examen (nom) VALUES (?)");
        $stmt->execute([$examen->getNom()]);
        $examen->setId($this->pdo->lastInsertId());
        return $examen;
    }

    // 3. Modifier un examen
    public function edit(int $id, Examen $examen): ?Examen {
        $stmt = $this->pdo->prepare("UPDATE examen SET nom=? WHERE id=?");
        $stmt->execute([
            $examen->getNom(),
            $id
        ]);
        return $examen;
    }

    // 4. Supprimer un examen
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM examen WHERE id = ?");
        return $stmt->execute([$id]);
    }
}