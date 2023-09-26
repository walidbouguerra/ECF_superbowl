<?php
  // Afficher un message d'erreur ou de succès
  if (isset($errorMessage)) {
    echo "<div class='alert alert-danger text-center' role='alert'>$errorMessage</div>";
  } else if (isset($successMessage)) {
    echo "<div class='alert alert-success text-center' role='alert'>$successMessage</div>";
  }
?>

<div class="d-flex align-items-center py-4 justify-content-center">
    <form action="index.php?user/loginverif" method="post">
        <h1 class="h3 mb-3 fw-normal text-center">Connexion</h1>
        <div class="form-floating">
          <input type="email" class="form-control" id="floatingInput" name="email" required>
          <label for="floatingInput">E-mail</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" name="password" required>
          <label for="floatingPassword">Mot de passe</label>
        </div>
        <div class="text-center mt-2">
          <a href="index.php?user/resetpassword">Mot de passe oublié ?</a>
        </div>
        <button class="btn btn-primary w-100 py-2 mt-4" type="submit">Se connecter</button>
    </form>
</div>