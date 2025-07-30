<?php
namespace App\Controllers;

use Config\Database;
use App\Models\Examen;
use PDO;

class ExamenController {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    //* 1. Lister tous les examens
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM examen");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $examens = [];
        foreach ($rows as $row) {
            $examens[] = new Examen($row['nom'], $row['description'], (int)$row['id']);
        }

        return $examens;
    }

    //* 2. Enregistrer un examen
    public function new(Examen $examen): Examen {
        $stmt = $this->pdo->prepare("INSERT INTO examen (nom, description) VALUES (:nom, :description)");
        $stmt->execute([
            'nom'         => $examen->getNom(),
            'description' => $examen->getDescription()
        ]);
        $examen->setId((int)$this->pdo->lastInsertId());
        return $examen;
    }

    //* 3. Modifier un examen
    public function edit(int $id, Examen $examen): ?Examen {
        $stmt = $this->pdo->prepare("UPDATE examen SET nom= :nom, description= :description WHERE id=:id");
        $stmt->execute([
            'nom'         => $examen->getNom(),
            'description' => $examen->getDescription(),
            'id'          => $id
        ]);
        $examen->setId($id);
        return $examen;
    }

    //* 4. Supprimer un examen
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM examen WHERE id = :id");
        return $stmt->execute([$id]);
    }

    //* READ ONE : retourne un objet ou null
    public function find(int $id): ?Examen {
        $stmt = $this->pdo->prepare("SELECT * FROM examen WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return (new Examen())->formArray($row);
    }
}
