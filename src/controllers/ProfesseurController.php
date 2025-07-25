<?php
namespace App\Controllers;

use Config\Database;
use App\Models\Professeur;
use PDO;

class ProfesseurController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // 1. Lister tous les profs
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM professeur");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $profs = [];
        foreach ($rows as $row) {
            $profs[] = new Professeur($row['id'], $row['nom'], $row['prenom'], $row['grade'], $row['id_etab']);
        }

        return $profs;
    }

    // 2. Enregistrer un prof
    public function new(Professeur $prof): Professeur {
        $stmt = $this->pdo->prepare("INSERT INTO professeur (nom, prenom, grade, id_etab) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $prof->getNom(),
            $prof->getPrenom(),
            $prof->getGrade(),
            $prof->getIdEtab()
        ]);
        $prof->setId($this->pdo->lastInsertId());
        return $prof;
    }

    // 3. Modifier un prof
    public function edit(int $id, Professeur $prof): ?Professeur {
        $stmt = $this->pdo->prepare("UPDATE professeur SET nom=?, prenom=?, grade=?, id_etab=? WHERE id=?");
        $stmt->execute([
            $prof->getNom(),
            $prof->getPrenom(),
            $prof->getGrade(),
            $prof->getIdEtab(),
            $id
        ]);
        return $prof;
    }

    // 4. Supprimer un prof
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM professeur WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
