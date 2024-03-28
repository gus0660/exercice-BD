<nav class="navbar navbar-expand-lg bg-body-tertiary d-inline-flex">

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profil">Profil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login">Connexion</a>
      </li>
        <?php
        if(!isset($_SESSION['profil']) && empty($_SESSION['profil'])) {
          echo '<li class="nav-item">
          <a class="nav-link" href="register">Inscription</a>
        </li>';
        }
        
        if (isset($_SESSION['profil']) && in_array('role_admin', $_SESSION['profil']['roleLevel'])) {
          echo '<li class="nav-item"><a class="nav-link" href="admin">Accés Administration</a></li>';
        } 
        if(isset($_SESSION['profil'])) {
          echo '<li class="nav-item">
          <a class="nav-link" href="controllers/logout.php">Déconnexion</a>
        </li>';
        }
        ?>
    </ul>
  </div>

</nav>