<h1 class="text-center p-4">Matchs</h1>
<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
  <div style="height: 500px" class="list-group overflow-y-scroll">
    <?php if (isset($games)): ?>
    <?php foreach ($games as $game): ?>
    <a href="index.php?game/show/<?=$game['id_game']?>" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
      <div class="d-flex flex-column gap-2 w-100 justify-content-between  text-center">
      <small class="opacity-50 text-nowrap"><?=$game['game_date']?></small>
        <div>
          <h6 class="mb-1"><?=$game['t1_name']?> vs <?=$game['t2_name']?></h6>
          <p class="mb-0 opacity-75"><?=$game['status']?></p>
          <p class="mb-0 opacity-75"><?=$game['score_1'] . ' - ' . $game['score_2']?></p>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php
      if (isset($errorMessage)) {
          echo "<div class='alert alert-danger text-center' role='alert'>$errorMessage</div>";
      }
    ?>
  </div>
</div>