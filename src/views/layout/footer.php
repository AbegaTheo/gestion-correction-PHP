<?php
namespace App\Views\Layout;

class Footer {
    public function render() {
        ?>
        <!-- footer.php : Pour inclure le pied de page -->
        <footer>
            <p>&copy; <?= date('Y') ?> Gestion Correction. Tous droits réservés.</p>
        </footer>
        <?php
    }
} ?>
