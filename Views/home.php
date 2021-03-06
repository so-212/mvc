<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>

  <?php if(!empty($_SESSION['erreur'])): ?>

      <div class="alert alert-warning mt-2" role="alert">
        <?= $_SESSION['erreur']; unset($_SESSION['erreur']);  ?>
      </div>

  <?php endif; ?>

  <?php if(!empty($_SESSION['message'])): ?>

      <div class="alert alert-success mt-2" role="alert">
        <?= $_SESSION['message']; unset($_SESSION['message']);  ?>
      </div>

  <?php endif; ?>
  
  <!-- navbar -->

  <nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="/">Mes annonces</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
     </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="navbar-nav mr-auto">

              <li class="nav-item active">
               <a class="nav-link" href="/">Accueil </a>
              </li>
              <li class="nav-item">
                 <a class="nav-link" href="/annonces">Liste des annonces</a>
              </li>
     
          </ul>
  
       </div>
   </nav>

<!-- fin navbar -->

    <div class="jumbotron">
        <h1 class="display-4">Accueil Annonces</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <a class="btn btn-primary btn-lg" href="/annonces" role="button">Liste dees annonces</a>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>