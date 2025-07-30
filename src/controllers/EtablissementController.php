<?php
namespace App\Controllers;

use Config\Database;
use App\Models\Etablissement;
use PDO;

class EtablissementController {
    private PDO $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    //* 1. Lister tous les établissements - Retourne un tableau d'objets Etablissement
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM etablissement");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $etabs = [];
        foreach ($rows as $row) {
            $etabs[] = new Etablissement($row['nom'], $row['ville'], (int)$row['id']);
        }

        return $etabs;
    }

    //* 2. Enregistrer un établissement - Retourne l'objet nouvellement inséré
    public function new(Etablissement $etab): Etablissement {
        $stmt = $this->pdo->prepare("INSERT INTO etablissement (nom, ville) VALUES (:nom, :ville)");
        $stmt->execute([
            'nom' => $etab->getNom(),
            'ville' => $etab->getVille()
        ]);
        $etab->setId((int)$this->pdo->lastInsertId());
        return $etab;
    }

    //* 3. Modifier un établissement - Retourne l'objet modifié ou null si rien n'a été modifié
    public function edit(int $id, Etablissement $etab): ?Etablissement {
        $stmt = $this->pdo->prepare("UPDATE etablissement SET nom = :nom, ville = :ville WHERE id = :id");
        $stmt->execute([
            'nom'   => $etab->getNom(),
            'ville' => $etab->getVille(),
            'id'    => $id
        ]);

        $etab->setId($id);
        return $etab;
    }

    //* 4. Supprimer un établissement
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM etablissement WHERE id = ?");
        return $stmt->execute([$id]);
    }

     //* READ ONE : retourne un objet ou null
    public function find(int $id): ?Etablissement {
        $stmt = $this->pdo->prepare("SELECT * FROM etablissement WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return (new Etablissement())->formArray($row);
    }
}
