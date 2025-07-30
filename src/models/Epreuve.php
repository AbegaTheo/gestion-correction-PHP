<?php
namespace App\models;

use App\models\BaseModel;

class Epreuve extends BaseModel {
    private ?int $id;
    private string $nom;
    private string $type;
    private ?int $idExamen;

    public function __construct(string $nom = '', string $type = '', ?int $idExamen = null, ?int $id = null) {
        $this->nom = $nom;
        $this->type = $type;
        $this->idExamen = $idExamen;
        $this->id = $id;
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getType(): string { return $this->type; }
    public function getIdExamen(): ?int { return $this->idExamen; }

    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setType(string $type): void { $this->type = $type; }
    public function setIdExamen(?int $idExamen): void { $this->idExamen = $idExamen; }
    public function setId(?int $id): void { $this->id = $id; }
}
