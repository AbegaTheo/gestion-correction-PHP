<?php namespace App\Views\Layout;

class Header {
    public function render() {
        ?>
        <!-- Navbar pour le projet  -->
        <style>
            nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 32px;
                background-color: #eee;
                font-size: 18px;
                font-family: 'Open Sans', Arial, sans-serif;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .nav-links {
                display: flex;
                gap: 18px;
            }

            nav a {
                color: #333;
                text-decoration: none;
                padding: 6px 12px;
                border-radius: 5px;
                transition: background 0.2s, color 0.2s;
            }

            nav a:hover {
                background: #e2e6ea;
                color: #007bff;
            }

            nav a.active {
                background: #007bff;
                color: #fff;
                font-weight: bold;
            }
        </style>

        <nav>
            <div class="nav-brand">
                <a href="/gestion-correction/index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Accueil</a>
            </div>
            <div class="nav-links">
                <a href="/gestion-correction/src/views/Professeur/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'Professeur') !== false ? 'active' : '' ?>">Professeurs</a>
                <a href="/gestion-correction/src/views/Etablissement/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'Etablissement') !== false ? 'active' : '' ?>">Etablissements</a>
                <a href="/gestion-correction/src/views/Epreuve/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'Epreuve') !== false ? 'active' : '' ?>">Epreuves</a>
                <a href="/gestion-correction/src/views/Examen/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'Examen') !== false ? 'active' : '' ?>">Examens</a>
                <a href="/gestion-correction/src/views/Correction/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'Correction') !== false ? 'active' : '' ?>">Corrections</a>
            </div>
        </nav>
        <?php
    }
} ?>
