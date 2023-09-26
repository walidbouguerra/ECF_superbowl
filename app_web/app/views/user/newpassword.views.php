<div class="d-flex align-items-center py-4 justify-content-center">
    <form action="index.php?user/addpassword" method="post">
        <h1 class="h3 mb-3 fw-normal">Nouveau mot de passe</h1>
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="form-floating">
          <input type="password" class="form-control" id="password" name="password">
          <label for="password">Mot de passe</label>
        </div>
        <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Valider mot de passe</button>
    </form>
</div>