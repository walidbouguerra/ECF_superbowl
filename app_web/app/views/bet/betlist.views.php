<h1 class="text-center mb-3">Misez sur vos équipes</h1>
<form action="index.php?bet/addlist" method="post" class="text-center" id="betsForm">
    <?php foreach($games as $game) :?>
        <div class="row border-bottom p-4">
            <p><?=$game['game_date']?></p>
            <div class="col">
                <input type="hidden" name="id_game[]" value="<?=$game['id_game']?>">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="id_team[<?=$game['id_game']?>]" value="<?=$game['id_team1']?>" required>
                    <label class="form-check-label"><?=$game['t1_name'] . ' - Cote (' . $game['odds_1'] . ')'?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="id_team[<?=$game['id_game']?>]" value="<?=$game['id_team2']?>">
                    <label class="form-check-label"><?=$game['t2_name'] . ' - Cote (' . $game['odds_2'] . ')'?></label>
                </div>
                <div class="form-group mt-3">
                    <label for="amount">Mise</label>
                    <input type="number" class="form-control w-25 mx-auto" id="amount" name="amount[]" required>
                </div>
            </div>
        </div>
    <?php endforeach;?>
    <button type="submit" class="btn btn-primary btn-lg mt-3">Miser sur la sélection</button>
</form>