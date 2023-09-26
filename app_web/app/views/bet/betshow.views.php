<div class="row text-center">
    <div class="col">
        <h2><?=$game['t1_name']?></h2>
        <p>Cote : <?= $game['odds_1']?></p>
    </div>
    <div class="col">
        <form action="index.php?bet/<?= $action ?>/<?=$game['id_game']?>" method="post" id="betForm">
            <h1>Misez sur votre équipe</h1>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="id_team" id="inlineRadio1" value="<?=$game['id_team1']?>" required>
                <label class="form-check-label" for="inlineRadio1"><?=$game['t1_name']?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="id_team" id="inlineRadio2" value="<?=$game['id_team2']?>">
                <label class="form-check-label" for="inlineRadio2"><?=$game['t2_name']?></label>
            </div>
            <div class="form-group mt-3">
                <label for="amount">Montant</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <?php
                if ($action == "update") {
                    echo "<button type='submit' class='btn btn-primary btn-lg mt-2'>Actualiser</button>";
                } elseif ($action == "add") {
                    echo "<button type='submit' class='btn btn-primary btn-lg mt-2'>Miser</button>";
                }
            ?>
        </form>
    </div>
    <div class="col">
        <h2><?=$game['t2_name']?></h2>
        <p>Cote : <?= $game['odds_2']?></p>
    </div>
</div>