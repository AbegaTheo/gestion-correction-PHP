<?php
namespace App\Controllers;

use Config\Database;
use App\Models\Etablissement;
use PDO;

class EtablissementController {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // 1. Lister tous les établissements
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM etablissement");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $etabs = [];
        foreach ($rows as $row) {
            $etabs[] = new Etablissement($row['id'], $row['nom'], $row['ville']);
        }

        return $etabs;
    }

    // 2. Enregistrer un établissement
    public function new(Etablissement $etab): Etablissement {
        $stmt = $this->pdo->prepare("INSERT INTO etablissement (nom, ville) VALUES (?, ?)");
        $stmt->execute([
            $etab->getNom(),
            $etab->getVille()
        ]);
        $etab->setId($this->pdo->lastInsertId());
        return $etab;
    }

    // 3. Modifier un établissement
    public function edit(int $id, Etablissement $etab): ?Etablissement {
        $stmt = $this->pdo->prepare("UPDATE etablissement SET nom=?, ville=? WHERE id=?");
        $stmt->execute([
            $etab->getNom(),
            $etab->getVille(),
            $id
        ]);
        return $etab;
    }

    // 4. Supprimer un établissement
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM etablissement WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
