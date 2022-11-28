<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Atlantik</title>
  </head>
  <body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Atlantik</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo site_url('Welcome/index') ?>">Accueil</a>
          </li>
            <?php if (!is_null($this->session->id)) : ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Afficher
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="<?php echo site_url('Client/afficherLiaisonsSecteur') ?>">Liaisons par secteur</a>
                  <a class="dropdown-item" href="<?php echo site_url('Client/horrairesTravs') ?>">Horraires traversés</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="<?php echo site_url('Visiteur/afficherRes') ?>">Afficher réservations</a>
              </li>
            <?php else : ?>
              <li class="nav-item dropdown">
                <a class="nav-link" href="<?php echo site_url('Visiteur/afficherRes') ?>">Afficher réservations</a>
              </li>
            <?php endif; ?>
        </ul>

        <?php if (!is_null($this->session->id)) : ?>
          <li class="nav-item active">
                <a class="nav-link" href="<?php echo site_url('Client/updateAccount') ?>">Edit Account</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo site_url('Visiteur/logout') ?>">Logout</a>
            </li>
        <?php else : ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo site_url('Visiteur/login') ?>">Login</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo site_url('Visiteur/signIn') ?>">Sign In</a>
            </li>
        <?php endif; ?>

        

        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <br/><br/>