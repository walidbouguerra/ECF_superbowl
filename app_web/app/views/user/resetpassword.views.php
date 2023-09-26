<div class="d-flex align-items-center py-4 justify-content-center">
    <form action="index.php?user/newpassword" method="post">
        <h1 class="h3 mb-3 fw-normal">Demander un nouveau mot de passe</h1>
        <div class="form-floating">
          <input type="text" class="form-control" id="name" name="name" required>
          <label for="name">Nom</label>
        </div>
        <div class="form-floating">
          <input type="text" class="form-control" id="firstname" name="first_name" required>
          <label for="firstname">Prénom</label>
        </div>
        <div class="form-floating">
          <input type="email" class="form-control" id="floatingInput" name="email" required>
          <label for="floatingInput">E-mail</label>
        </div>
        <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Envoyer la demande</button>
    </form>
</div>