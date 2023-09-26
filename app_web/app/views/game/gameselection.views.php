<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
  <form class="list-group" action="index.php?bet/list" method="post">
    <h1 class="text-center mb-5">Parier</h1>
    <?php if (isset($games)): ?>
    <?php foreach($games as $game): ?>
        <label class="list-group-item d-flex gap-2">
          <input class="form-check-input flex-shrink-0" type="checkbox" name="id_games[]" value="<?=$game['id_game']?>">
          <span>
            <?=$game['t1_name']?> vs <?=$game['t2_name']?>
            <small class="d-block text-body-secondary"><?=$game['game_date']?></small>
          </span>
        </label>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php
      if (isset($errorMessage)) {
          echo "<div class='alert alert-danger text-center' role='alert'>$errorMessage</div>";
      } else {
          if (!empty($_SESSION['user'])) {
            echo  "<button type='submit' class='btn btn-primary mt-3'>Miser sur la sélection</button>";
          } else {
            echo "<p class='my-3'>Veuillez vous connecter pour parier.</p>";
          }
      }
    ?>
  </form>
</div>