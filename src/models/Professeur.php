<?php
namespace App\Models;

use App\Models\BaseModel;
use App\Models\Etablissement;

class Professeur extends BaseModel {
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $grade;
    private ?int $idEtab;

    public function __construct(string $nom = '', string $prenom = '', string $grade = '', ?int $idEtab = null, ?int $id = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->grade = $grade;
        $this->idEtab = $idEtab;
        $this->id = $id;
    }

    // Getters et Setters
    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getGrade(): string { return $this->grade; }
    public function getIdEtab(): ?int { return $this->idEtab; }

    public function setId(int $id): void { $this->id = $id; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setGrade(string $grade): void { $this->grade = $grade; }
    public function setIdEtab(int $idEtab): void { $this->idEtab = $idEtab; }
}
