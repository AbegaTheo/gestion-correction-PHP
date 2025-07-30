<?php
namespace App\Controllers;

use Config\Database;
use App\Models\Professeur;
use PDO;

class ProfesseurController {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    //* 1. Lister tous les profs
    public function index(): array {
        $stmt = $this->pdo->query("SELECT * FROM professeur");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $profs = [];
        foreach ($rows as $row) {
            $profs[] = new Professeur(
                $row['nom'],
                $row['prenom'],
                $row['grade'],
                (int)$row['id_etab'],
                (int)$row['id']
            );
        }

        return $profs;
    }

    //* 2. Enregistrer un prof
    public function new(Professeur $prof): Professeur {
        $stmt = $this->pdo->prepare("INSERT INTO professeur (nom, prenom, grade, id_etab) VALUES (:nom, :prenom, :grade, :id_etab)");
        $stmt->execute([
            'nom' => $prof->getNom(),
            'prenom' => $prof->getPrenom(),
            'grade' => $prof->getGrade(),
            'id_etab' => $prof->getIdEtab()
        ]);
        $prof->setId((int)$this->pdo->lastInsertId());
        return $prof;
    }

    //* 3. Modifier un prof
    public function edit(int $id, Professeur $prof): ?Professeur {
        $stmt = $this->pdo->prepare("UPDATE professeur SET nom= :nom, prenom= :prenom, grade= :grade, id_etab= :id_etab WHERE id= :id");
        $stmt->execute([
            'nom'     => $prof->getNom(),
            'prenom'  => $prof->getPrenom(),
            'grade'   => $prof->getGrade(),
            'id_etab' => $prof->getIdEtab(),
            'id'      => $id
        ]);
        $prof->setId($id);
        return $prof;
    }

    //* 4. Supprimer un prof
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM professeur WHERE id = :id");
        return $stmt->execute([$id]);
    }

    //* READ ONE : retourne un objet ou null
    public function find(int $id): ?Professeur {
        $stmt = $this->pdo->prepare("SELECT * FROM professeur WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return (new Professeur())->formArray($row);
    }
}
