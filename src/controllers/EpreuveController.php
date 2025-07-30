<?php

namespace App\Controllers;

use Config\Database;
use App\Models\Epreuve;
use PDO;

class EpreuveController {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    //* 1. Lister toutes les épreuves
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM epreuve");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $epreuves = [];
        foreach ($rows as $row) {
            $epreuves[] = new Epreuve($row['nom'], $row['type'], (int)$row['id_examen'], (int)$row['id']);
        }

        return $epreuves;
    }

    //* 2. Enregistrer une épreuve
    public function new(Epreuve $epreuve): Epreuve {
        $stmt = $this->pdo->prepare("INSERT INTO epreuve (nom, type, id_examen) VALUES (:nom, :type, :id_examen)");
        $stmt->execute([
            'nom'       => $epreuve->getNom(),
            'type'      => $epreuve->getType(),
            'id_examen' => $epreuve->getIdExamen()
        ]);
        $epreuve->setId((int)$this->pdo->lastInsertId());
        return $epreuve;
    }

    //* 3. Modifier une épreuve
    public function edit(int $id, Epreuve $epreuve): ?Epreuve {
        $stmt = $this->pdo->prepare("UPDATE epreuve SET nom= :nom, type= :type, id_examen= :id_examen WHERE id= :id");
        $stmt->execute([
            'nom'       => $epreuve->getNom(),
            'type'      => $epreuve->getType(),
            'id_examen' => $epreuve->getIdExamen(),
            'id'        => $id
        ]);
        $epreuve->setId($id);
        return $epreuve;
    }

    //* 4. Supprimer une épreuve
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM epreuve WHERE id = :id");
        return $stmt->execute([$id]);
    }

    //* READ ONE: retourne un objet ou null
    public function find(int $id): ?Epreuve {
        $stmt = $this->pdo->prepare("SELECT * FROM epreuve WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return (new Epreuve())->formArray($row);
    }
}
