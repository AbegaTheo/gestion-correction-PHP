<?php
namespace App\Models;

use App\Models\BaseModel;

class Correction extends BaseModel {
    private ?int $id;
    private ?int $idProfesseur;
    private ?int $idEpreuve;
    private string $date;
    private ?int $nbrCopie;

    public function __construct(?int $idProfesseur = null, ?int $idEpreuve = null, string $date = '', ?int $nbrCopie = null, ?int $id = null) {
        $this->id = $id;
        $this->idProfesseur = $idProfesseur;
        $this->idEpreuve = $idEpreuve;
        $this->date = $date;
        $this->nbrCopie = $nbrCopie;
    }

    public function getId(): ?int { return $this->id; }
    public function getIdProfesseur(): ?int { return $this->idProfesseur; }
    public function getIdEpreuve(): ?int { return $this->idEpreuve; }
    public function getDate(): string { return $this->date; }
    public function getNbrCopie(): ?int { return $this->nbrCopie; }

    public function setIdProfesseur(int $idProfesseur): void { $this->idProfesseur = $idProfesseur; }
    public function setIdEpreuve(int $idEpreuve): void { $this->idEpreuve = $idEpreuve; }
    public function setDate(string $date): void { $this->date = $date; }
    public function setNbrCopie(int $nbrCopie): void { $this->nbrCopie = $nbrCopie; }
    public function setId(?int $id): void { $this->id = $id; }
}
