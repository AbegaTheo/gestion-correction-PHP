<?php
namespace App\Models;

use App\Models\BaseModel;

class Etablissement extends BaseModel {
    private ?int $id;
    private string $nom;
    private string $ville;

    public function __construct(string $nom = '', string $ville = '', ?int $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->ville = $ville;
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getVille(): string { return $this->ville; }

    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setVille(string $ville): void { $this->ville = $ville; }
    public function setId(?int $id): void { $this->id = $id; }
}
