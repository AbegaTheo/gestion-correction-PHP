<!DOCTYPE html>
<html lang="fr-FR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      --accent-color: #4facfe;
      --text-light: #ffffff;
      --shadow-light: rgba(0, 0, 0, 0.1);
      --shadow-medium: rgba(0, 0, 0, 0.2);
    }

    * {
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      margin-bottom: 30px;
      background: var(--primary-gradient) !important;
      box-shadow: 0 8px 32px var(--shadow-light);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 1rem 0;
      transition: all 0.3s ease;
    }

    .navbar:hover {
      box-shadow: 0 12px 40px var(--shadow-medium);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
      color: var(--text-light) !important;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.3s ease;
      position: relative;
    }

    .navbar-brand::before {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 3px;
      background: var(--secondary-gradient);
      border-radius: 2px;
      transition: width 0.3s ease;
    }

    .navbar-brand:hover::before {
      width: 100%;
    }

    .navbar-brand:hover {
      transform: translateY(-2px);
      color: #f8f9fa !important;
    }

    .brand-icon {
      background: var(--secondary-gradient);
      padding: 8px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }

      100% {
        transform: scale(1);
      }
    }

    .navbar-nav .nav-link {
      color: var(--text-light) !important;
      font-weight: 500;
      margin: 0 8px;
      padding: 10px 20px !important;
      border-radius: 25px;
      transition: all 0.3s ease;
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }

    .navbar-nav .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 25px;
      opacity: 0;
      transition: all 0.3s ease;
      z-index: -1;
    }

    .navbar-nav .nav-link:hover::before,
    .navbar-nav .nav-link.active::before {
      opacity: 1;
      transform: scale(1.05);
    }

    .navbar-nav .nav-link:hover {
      color: #f8f9fa !important;
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    }

    .navbar-nav .nav-link.active {
      background: var(--secondary-gradient);
      box-shadow: 0 6px 20px rgba(245, 87, 108, 0.4);
      font-weight: 600;
    }

    .navbar-nav .nav-link.active::before {
      display: none;
    }

    .navbar-toggler {
      border: none;
      padding: 8px 12px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      transition: all 0.3s ease;
    }

    .navbar-toggler:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: scale(1.05);
    }

    .navbar-toggler:focus {
      box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .nav-icon {
      font-size: 1.1rem;
      transition: transform 0.3s ease;
    }

    .navbar-nav .nav-link:hover .nav-icon {
      transform: scale(1.2) rotate(5deg);
    }

    /* Animation d'entrée */
    .navbar {
      animation: slideDown 0.8s ease-out;
    }

    @keyframes slideDown {
      from {
        transform: translateY(-100%);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    /* Responsive amélioré */
    @media (max-width: 991.98px) {
      .navbar-nav {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 15px;
        margin-top: 15px;
        backdrop-filter: blur(10px);
      }

      .navbar-nav .nav-link {
        margin: 5px 0;
        text-align: center;
      }

      .navbar-brand {
        font-size: 1.3rem;
      }
    }

    /* Effet de survol global */
    .container-fluid {
      position: relative;
      z-index: 1;
    }

    /* Particules décoratives */
    .navbar::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
    }
  </style>

  <nav class="navbar navbar-expand-lg navbar-dark px-3">
    <div class="container-fluid">
      <a class="navbar-brand" href="/gestion-correction/index.php">
        <div class="brand-icon">
          <i class="fas fa-clipboard-check text-white"></i>
        </div>
        <span>Fiche de Correction</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/gestion-correction/index.php">
              <i class="fas fa-home nav-icon"></i>
              <span>Accueil</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/gestion-correction/controllers/formulaire_correction.php">
              <i class="fas fa-plus-circle nav-icon"></i>
              <span>Ajouter une correction</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/gestion-correction/controllers/liste_tables.php">
              <i class="fas fa-list-alt nav-icon"></i>
              <span>Liste des tables</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/gestion-correction/controllers/dernier_enregistrement.php">
              <i class="fas fa-history nav-icon"></i>
              <span>Dernier enregistrement</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navbar = document.querySelector('.navbar');
      const links = navbar.querySelectorAll('.nav-link');

      links.forEach(link => {
        link.addEventListener('click', function() {
          links.forEach(l => l.classList.remove('active'));
          this.classList.add('active');
        });
      });
    });
  </script>
</body>

</html>