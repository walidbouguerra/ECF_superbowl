<div class="d-flex align-items-center py-4 justify-content-center">
    <form action="index.php?user/add" method="post">
        <h1 class="h3 mb-3 fw-normal text-center">Inscription</h1>
        <div class="form-floating">
          <input type="text" class="form-control" id="name" name="name">
          <label for="name">Nom</label>
        </div>
        <div class="form-floating">
          <input type="text" class="form-control" id="firstname" name="first_name">
          <label for="firstname">Prénom</label>
        </div>
        <div class="form-floating">
          <input type="email" class="form-control" id="floatingInput" name="email">
          <label for="floatingInput">E-mail</label>
        </div>
        <button class="btn btn-primary w-100 py-2 mt-3" type="submit">S'inscrire</button>
    </form>
</div>