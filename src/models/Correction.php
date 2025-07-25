<?php

namespace App\models;

use App\models\BaseModel;

class Correction extends BaseModel {
    private ?int $id;
    private ?int $id_professeur;
    private ?int $id_epreuve;
    private string $date;
    private ?int $nbr_copie;

    public function __construct(?int $id_professeur = null, ?int $id_epreuve = null, string $date = '', ?int $nbr_copie = null, ?int $id = null) {
        $this->id = $id;
        $this->id_professeur = $id_professeur;
        $this->id_epreuve = $id_epreuve;
        $this->date = $date;
        $this->nbr_copie = $nbr_copie;
    }

    public function getId(): ?int { return $this->id; }
    public function getIdProfesseur(): ?int { return $this->id_professeur; }
    public function getIdEpreuve(): ?int { return $this->id_epreuve; }
    public function getDate(): string { return $this->date; }
    public function getNbrCopie(): ?int { return $this->nbr_copie; }

    public function setIdProfesseur(int $id_professeur): void { $this->id_professeur = $id_professeur; }
    public function setIdEpreuve(int $id_epreuve): void { $this->id_epreuve = $id_epreuve; }
    public function setDate(string $date): void { $this->date = $date; }
    public function setNbrCopie(int $nbr_copie): void { $this->nbr_copie = $nbr_copie; }
    public function setId(?int $id): void { $this->id = $id; }
}

?>