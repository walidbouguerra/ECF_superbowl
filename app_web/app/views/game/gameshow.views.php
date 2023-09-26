<div class="row text-center">
    <div class="col">
        <h2><?=$game['t1_name']?></h2>
        <p>Score : <?= $game['score_1']?></p>
        <p>Cote : <?= $game['odds_1']?></p>
        <div class="compo">
            <h4>Joueurs (<?=count($game['players_1'])?>)</h4>
            <ul class="list-group">
                <?php foreach($game['players_1'] as $player) : ?>
                    <li class="list-group-item"><?=$player['id_player'] . ' - ' . $player['first_name'] . ' ' . $player['name']?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="col">
        <h3>Détails</h3>
        <p class='m-0'><?=$game['game_date']?></p>
        <p class='m-0'>Météo : <?=$game['weather']?></p>
        <p class='m-0'>Statut : <?=$game['status']?></p>
        <p class='m-0'><?=$game['end'] ? 'Fin : '. $game['end'] : ''?></p>
        <?php
            if($game['status'] == 'À venir' && !empty($_SESSION['user'])) {?> 
                <a class="btn btn-primary px-4 m-2" href="index.php?bet/show/<?=$game['id_game']?>" role="button">Miser</a>
           <?php }
        ?>
        <h4 class='mt-2'>Commentaires</h4>
        <ul class="list-group">
            <?php foreach($game['comments'] as $comment) : ?>
                <li class="list-group-item text-break"><?=substr($comment['time'], -8, 5) . '<br>' . $comment['text']?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="col">
        <h2><?=$game['t2_name']?></h2>
        <p>Score : <?= $game['score_2']?></p>
        <p>Cote : <?= $game['odds_2']?></p>
        <div class="compo">
            <h4>Joueurs (<?=count($game['players_2'])?>)</h4>
            <ul class="list-group">
                <?php foreach($game['players_2'] as $player) : ?>
                    <li class="list-group-item"><?=$player['id_player'] . ' - ' . $player['first_name'] . ' ' . $player['name']?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>