<header>
  <!--  Menu haut page -->
  <nav id="main_nav" class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3 sticky-top">
    <div class="container">
      <a href="index.php?uc=accueil" class="navbar-brand d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
        <img src="assets/images/logo.jpg" id="img-size-header" alt="GsbLogo" title="GsbLogo" height="50" class="me-2"/>
      </a>
      
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbar-toggler-success" aria-controls="navbar-toggler-success" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbar-toggler-success">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold align-items-center">
          
          <li class="nav-item">
            <a href="index.php?uc=accueil" class="nav-link px-3 active">Accueil</a>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle px-3" href="#" id="navbarDropdownBoutique" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Catalogue
            </a>
            <ul class="dropdown-menu shadow border-0" aria-labelledby="navbarDropdownBoutique">
              <li><a class="dropdown-item" href="index.php?uc=voirProduits&action=nosProduits">Tous nos produits</a></li>
              <li><a class="dropdown-item" href="index.php?uc=voirProduits&action=voirProduits&categorie=CH">Produits par catégorie</a></li>
            </ul>
          </li>

          <!-- Section Administration (peut être masquée par la suite si non admin) -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle px-3" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Administration
            </a>
            <ul class="dropdown-menu shadow border-0" aria-labelledby="navbarDropdownAdmin">
              <li><h6 class="dropdown-header text-primary">Gestion Catégories</h6></li>
              <li><a class="dropdown-item" href="index.php?uc=categories&action=listeCategories">Lister / Modifier</a></li>
              <li><a class="dropdown-item" href="index.php?uc=categories&action=ajouterCategorie">Ajouter une catégorie</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><h6 class="dropdown-header text-primary">Gestion Produits</h6></li>
              <li><a class="dropdown-item" href="index.php?uc=voirProduits&action=listeProduitsModif">Lister / Modifier</a></li>
              <li><a class="dropdown-item" href="index.php?uc=categories&action=ajouterProduit">Ajouter un produit</a></li>
            </ul>
          </li>
          
        </ul>

        <div class="d-flex align-items-center flex-column flex-lg-row mt-3 mt-lg-0">
          <a href="index.php?uc=gererPanier&action=voirPanier" class="btn btn-outline-primary position-relative me-lg-3 mb-2 mb-lg-0 rounded-pill px-4 fw-bold w-100 w-lg-auto">
            Mon panier
            <?php if(isset($_SESSION['produits']) && count($_SESSION['produits']) > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              <?php echo count($_SESSION['produits']); ?>
            </span>
            <?php endif; ?>
          </a>
          
          <?php if (isset($_SESSION['client'])): ?>
            <div class="dropdown w-100 w-lg-auto text-center">
              <button class="btn btn-primary rounded-pill px-4 fw-bold dropdown-toggle w-100" type="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                Bonjour, <?php echo htmlspecialchars($_SESSION['client']->prenom); ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0 w-100" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="index.php?uc=utilisateur&action=deconnexion">Déconnexion</a></li>
              </ul>
            </div>
          <?php else: ?>
            <div class="d-flex w-100 w-lg-auto">
                <a href="index.php?uc=utilisateur&action=connexion" class="btn btn-primary rounded-pill px-4 fw-bold me-2 w-100">Connexion</a>
                <a href="index.php?uc=utilisateur&action=inscription" class="btn btn-light rounded-pill px-4 fw-bold border w-100">S'inscrire</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
</header>
<div id="container" class="mt-4">